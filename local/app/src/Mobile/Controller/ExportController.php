<?php
namespace Mobile\Controller;

use Auth, View, Input;

/*
|--------------------------------------------------------------------------
| Export controller
|--------------------------------------------------------------------------
|
| App Export related logic
|
*/

class ExportController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
		if(Auth::check())
		{
			$this->parent_user_id = (Auth::user()->parent_id == NULL) ? Auth::user()->id : Auth::user()->parent_id;
		}
		else
		{
			$this->parent_user_id = NULL;
		}
    }

    /**
     * Export loading status
     */
    public function postAppExportStatus()
    {
        return \Response::json(\Session::get('app_export_status'));
    }

    /**
     * Export app
     */
    public function postAppExport()
    {
        \Session::put('app_export_status', array('status' => 'pending'));

		$filename = \Request::input('filename', '');
		$sl = \Request::input('sl', '');
		$qs = \App\Core\Secure::string2array($sl);
   		$app = \Mobile\Model\App::where('id', '=', $qs['app_id'])->where('user_id', '=', $this->parent_user_id)->first();

        if(count($app) > 0)
        {
			// Create directory for export
			$export_dir = storage_path() . '/userdata/exports/app_' . $app->id;
			if(\File::isDirectory($export_dir))
			{
				// Dir exists, empty before exporting again
				\File::cleanDirectory($export_dir);
			}

			\File::makeDirectory($export_dir . '/www/css', 0777, true);
			\File::makeDirectory($export_dir . '/www/fonts', 0777, true);
			\File::makeDirectory($export_dir . '/www/img', 0777, true);
			\File::makeDirectory($export_dir . '/www/js', 0777, true);
			\File::makeDirectory($export_dir . '/www/templates', 0777, true);

			// Copy Ionic font
			\File::copy(public_path() . '/assets/fonts/ionicons.eot', $export_dir . '/www/fonts/ionicons.eot');
			\File::copy(public_path() . '/assets/fonts/ionicons.svg', $export_dir . '/www/fonts/ionicons.svg');
			\File::copy(public_path() . '/assets/fonts/ionicons.ttf', $export_dir . '/www/fonts/ionicons.ttf');
			\File::copy(public_path() . '/assets/fonts/ionicons.woff', $export_dir . '/www/fonts/ionicons.woff');

			// Get index html
			$app_root = url('/mobile/' . $app->local_domain);

			\Mobile\Controller\ExportController::parseUrl($app, $app_root, $export_dir, '', 'index');

			// Navigation
			$url = url('api/v1/mobile/view/' . $app->local_domain);

			$client = new \GuzzleHttp\Client();
			$response = $client->get($url);
			$html = $response->getBody()->getContents();
			//$html = call_user_func_array('mb_convert_encoding', array(&$html, 'HTML-ENTITIES', 'UTF-8')); 
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

			// Format html
			$indenter = new \Gajus\Dindent\Indenter();
			$html = $indenter->indent($html);

			\File::put($export_dir . '/www/nav.html', $html);

			// Get pages
			foreach ($app->appPages as $page)
			{
				if ($page->hidden == 0 && $page->hidden_parent == 0)
				{
					\Mobile\Controller\ExportController::parseUrl($app, url('api/v1/mobile/view/' . $app->local_domain . '/' . $page->slug), $export_dir, 'templates/', $page->slug);
				}
			}
        }

		// Get real path for our folder
		$rootPath = $export_dir . '/www';

		// Initialize archive object
		$zip = new \ZipArchive();
		$zip->open($export_dir . '/www.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath),
			\RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (! $file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
		
				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		$file = $export_dir . '/www.zip';
		$headers = array(
			'Content-Type: application/zip',
		);

		// Clear generated files after zip is served
		\App::finish(function($request, $response) use ($export_dir)
		{
			\File::deleteDirectory($export_dir, false);
		});

		if ($filename == '')
		{
			$slugify = new \Slugify();
			$filename = $slugify->slugify($app->name);
			$filename = $filename . '-' . date('Y-m-d');
		}
		else
		{
			$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $filename);
		}

        \Session::put('app_export_status', array('status' => 'finished'));

		return \Response::download($file, $filename . '.zip', $headers);
    }

	/**
	 * Parse url, extract and combine js, css, images
	 */
	public static function parseUrl($app, $url, $export_dir, $html_path, $asset_name)
	{
		$cordova = (boolean) \Request::input('cordova', 0);

		$client = new \GuzzleHttp\Client();

		$response = $client->get($url);

		$html = $response->getBody()->getContents();

		$dom = new \DOMDocument();

		// Prevent errors
		libxml_use_internal_errors(true);

		//avoid the whitespace after removing the node
		$dom->preserveWhiteSpace = false;
		$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

		$head = $dom->getElementsByTagName('head');
		$html_remove = array();
		$head_append = array();

		// Append Content-Security-Policy for android remote urls
		if ($asset_name == 'index' && $cordova)
		{
			$head_append[] = '<meta http-equiv="Content-Security-Policy" content="default-src \'self\' * ws://localhost:35729 data: gap: https://ssl.gstatic.com; style-src \'self\' \'unsafe-inline\'; media-src *;script-src \'self\' localhost:35729 \'unsafe-eval\' \'unsafe-inline\';"></meta>';
		}

		// Rewrite meta tags
		$metas = $dom->getElementsByTagName('meta');

		foreach ($metas as $meta)
		{
			$name = $meta->getAttribute('name');

			if ($name == 'viewport')
			{
				$meta->setAttribute('content', 'initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width');
			}
			else
			{
				if ($meta->getAttribute('charset') == NULL)
				{
					$string = $meta->ownerDocument->saveHTML($meta);
					$html_remove[] = $string;
				}
			}
		}

		// Remove link tags (stylesheet, icons), combine stylesheets
		$links = $dom->getElementsByTagName('link');
		$image = 1;

		foreach ($links as $link)
		{
			$rel = $link->getAttribute('rel');

			if ($rel == 'stylesheet')
			{
				$href = $link->getAttribute('href');

				$response = $client->get($href);
				$css = $response->getBody();

				$url_parsed = parse_url($href);
				$url_path = $url_parsed['path'];

				$script_name = basename($url_path);
				$script_name = str_replace('.css', '', $script_name);

				if (str_contains($href, 'app-asset/style'))
				{
					$script_name = 'style';
				}
				elseif (str_contains($href, 'mobile/global-css'))
				{
					$script_name = 'global';
				}
				elseif (str_contains($href, '/themes/'))
				{
					$script_name = 'theme';
				}
				elseif (str_contains($href, '/widgets/'))
				{
					$path_parts = explode('/', $url_path);
			 		$script_name = $path_parts[2] . '-' . $script_name;
				}

				// Get images from css, rewrite css paths
				$file_paths = \Mobile\Controller\ExportController::extract_css_urls($css);

				if (isset($file_paths['property']))
				{
					foreach ($file_paths['property'] as $file_path)
					{
						if (! starts_with($file_path, '../fonts') && ! str_contains($file_path, '#'))
						{
							$copy = true;

							if (starts_with($file_path, 'data:'))
							{
								$copy = false;

								// Create image dir
								if (! \File::isDirectory($export_dir . '/www/img/' . $asset_name . '/')) \File::makeDirectory($export_dir . '/www/img/' . $asset_name . '/', 0777, true);

								$data = explode(',', $file_path);
								$file_path2 = 'content' . $image . '.jpg';
								\File::put($export_dir . '/www/img/' . $asset_name . '/' . $file_path2, base64_decode($data[1]));
								$image++;
							}

							// Create image dir
							if(! \File::isDirectory($export_dir . '/www/img/' . $asset_name . '/')) \File::makeDirectory($export_dir . '/www/img/' . $asset_name . '/', 0777, true);

							// Copy image
							$file_path2 = \Mobile\Controller\ExportController::parsePath($file_path, $url_path);

							if ($copy && \Mobile\Controller\ExportController::url_validate($file_path2)) 
                            {
                                \File::copy($file_path2, $export_dir . '/www/img/' . $asset_name . '/' . basename($file_path2));
                            }

							// Replace in css
							$css = str_replace($file_path, '../img/' . $asset_name . '/' . basename($file_path2), $css);
						}
					}
				}

				if ($css != '')
				{
					\File::put($export_dir . '/www/css/' . $script_name . '.css', $css);
					$head_append[] = '<link rel="stylesheet" href="css/' . $script_name . '.css"/>';
				}
				
				$string = $link->ownerDocument->saveHTML($link);
				$html_remove[] = $string;
			}
			else
			{
				$string = $link->ownerDocument->saveHTML($link);
				$html_remove[] = $string;
			}
		}

		// Remove js tags & combine
		$scripts = $dom->getElementsByTagName('script');

		foreach ($scripts as $script)
		{
			$src = $script->getAttribute('src');

			if ($src != '' && ! str_contains($src, 'api/v1/track'))
			{
				$response = $client->get($src);
				$js = $response->getBody();

				$url_parsed = parse_url($src);
				$url_path = $url_parsed['path'];

				$script_name = basename($url_path);
				$script_name = str_replace('.js', '', $script_name);
				if ($script_name == 'mobile') $script_name = 'lib';

				if (str_contains($src, 'app-asset/app/'))
				{
					$script_name = 'app';
				}
				elseif (str_contains($src, 'app-asset/controllers/'))
				{
					$script_name = 'controllers';
				}
				elseif (str_contains($src, 'app-asset/services/'))
				{
					$script_name = 'services';
				}
				elseif (str_contains($src, 'mobile/global-js/'))
				{
					$script_name = 'global';
				}
				elseif (str_contains($src, '/widgets/'))
				{
					$path_parts = explode('/', $url_path);
			 		$script_name = $path_parts[2] . '-' . $script_name;
				}

				// Extract urls from js
				preg_match_all('/\'http([^\"]*?)\'/', $js, $match);
	
				$app_url = url();
				$app_url_root = url();
				$app_root = url('/mobile/' . $app->local_domain);
				$view_url = '/api/v1/mobile/view/' . $app->local_domain;

				if (isset($match[0]))
				{
					foreach ($match[0] as $url)
					{
						$url = str_replace('\'', '', $url);
						$new_url = str_replace($app_url . '', '', $url);
						$new_url = str_replace('/api/v1/widget/route/', 'widget/route/', $new_url);

						if (str_contains($new_url, $view_url))
						{
							if ($new_url == $view_url)
							{
								$new_url = 'nav.html';
							}
							else
							{
								$new_url = 'templates/' . str_replace($view_url . '/', '', $new_url) . '.html';
							}
						}

						// Replace remote urls
						$js = str_replace("'" . $url . "'", "'" . $new_url . "'", $js);
						$js = str_replace("var url = '';", "var url = '" . $app_url . "';", $js);

						// Replace remote urls back for detail pages
						$js = str_replace("'widget/route/' + params.widget + '/' + params.func + '/' + params.sl", "url + '/api/v1/widget/route/' + params.widget + '/' + params.func + '/' + params.sl", $js);
					}
				}

				if ($js != '')
				{
					\File::put($export_dir . '/www/js/' . $script_name . '.js', $js);
					$head_append[] = '<script src="js/' . $script_name . '.js"></script>';

					// Append Cordova
					if ($asset_name == 'index' && $script_name == 'lib' && $cordova)
					{
						$head_append[] = '<script src="cordova.js"></script>';
					}
				}
			}

			if ($src != '')
			{
				$string = $script->ownerDocument->saveHTML($script);
				$html_remove[] = $string;
			}
		}

		// Parse images
		preg_match_all('/<img src=["\'](.*?)["\']/i', $html, $match);
		$image = 1;
		if (isset($match[1]) && ! empty($match[1]))
		{
			foreach($match[1] as $url)
			{
				$src = $url;
				$target_src = $src;

				$url_parsed = parse_url($src);
				$url_path = $url_parsed['path'];
				$copy = true;

				// Copy image
				if (str_contains($src, '?'))
				{
					parse_str($url_parsed['query'], $url_parts);
					unset($url_parts['img']);
					$target_src = implode('-', $url_parts) . '-' . basename($src);
				}
				else
				{
					if (starts_with($url, 'data:'))
					{
						$copy = false;

						// Create image dir
						if (! \File::isDirectory($export_dir . '/www/img/' . $asset_name . '/')) \File::makeDirectory($export_dir . '/www/img/' . $asset_name . '/', 0777, true);

						$data = explode(',', $url);
						$target_src = 'content' . $image . '.jpg';
						\File::put($export_dir . '/www/img/' . $asset_name . '/' . $target_src, base64_decode($data[1]));
						$image++;
					}
					elseif (! \File::isFile($src)) 
					{
						$src = url($url);
						$target_src = basename($src);
					}
				}

				// Create image dir
				if (! \File::isDirectory($export_dir . '/www/img/' . $asset_name . '/')) \File::makeDirectory($export_dir . '/www/img/' . $asset_name . '/', 0777, true);

				// Copy image
				$src2 = \Mobile\Controller\ExportController::parsePath($src, $url_path);

                if ($copy && \Mobile\Controller\ExportController::url_validate($src2)) 
                {
				    \File::copy($src2, $export_dir . '/www/img/' . $asset_name . '/' . $target_src);
                }

				// Replace 
				$image_replace[$url] = '../img/' . $asset_name . '/' . $target_src;
				//$html = str_replace($url, '../img/' . $asset_name . '/' . $target_src, $html);
			}
		}

		// Append head elements
		foreach ($head_append as $append)
		{
			$fragment = $dom->createDocumentFragment();
			$fragment->appendXML($append);

			$head->item(0)->appendChild($fragment);
		}

		if ($html_path == '')
		{
			$html = $dom->saveHTML();
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
			//$html = html_entity_decode($html);
		}
		else
		{
			$html_fragment = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
			//$html = html_entity_decode($html_fragment);

			// Debug
			if ($asset_name == 'content')
			{
				//header('Content-Type: text/html; charset=utf-8');
				//echo '测试';
				//$html = mb_convert_encoding($html,"UTF-81","auto");
				//$html = html_entity_decode($html);
				//dd($html);
			}
		}

		// Remove elements from html
		foreach ($html_remove as $remove)
		{
			$html = str_replace(trim($remove), '', $html);
		}

		// Replace image text
		if (isset($image_replace))
		{
			foreach ($image_replace as $replace => $replace_with)
			{
				$html = str_replace($replace, $replace_with, $html);
				//$html = str_replace(htmlentities($replace), $replace_with, $html);
			}
		}

		// Format html
		$indenter = new \Gajus\Dindent\Indenter();
		$html = $indenter->indent($html);

		if(! \File::isDirectory($export_dir . '/www/' . $html_path . '/')) \File::makeDirectory($export_dir . '/www/' . $html_path . '/', 0777, true);

		\File::put($export_dir . '/www/' . $html_path . $asset_name . '.html', $html);
	}

	/**
	 * Parse file path to copyable url
	 */
	public static function parsePath($path, $url_path)
	{
		// Check if image is base64 encoded
		if (starts_with($path, 'data:')) return '';

		if (str_contains($path, '../'))
		{
			$dirs = substr_count($path, '../');
			$path = \Mobile\Controller\ExportController::dirname2($url_path, $dirs + 1) . '/' . str_replace('../', '', $path);
			$path = url($path);
		}
		
		// Make url if path starts with /
		if (starts_with($path, '/')) $path = url($path);

		return $path;
	}

   /*
    * @return boolean
    * @param  string $link
    * @desc   Test url for availability (HTTP-Code: 200)
    */
    public static function url_validate( $link )
    {        
        $url_parts = @parse_url( $link );

        if ( empty( $url_parts["host"] ) ) return( false );

        if ( !empty( $url_parts["path"] ) )
        {
            $documentpath = $url_parts["path"];
        }
        else
        {
            $documentpath = "/";
        }

        if ( !empty( $url_parts["query"] ) )
        {
            $documentpath .= "?" . $url_parts["query"];
        }

        $host = $url_parts["host"];
        $port = isset($url_parts["port"]) ? $url_parts["port"] : 80;
        // Now (HTTP-)GET $documentpath at $host";

        if (empty( $port ) ) $port = "80";
        $socket = @fsockopen( $host, $port, $errno, $errstr, 30 );
        if (!$socket)
        {
            return(false);
        }
        else
        {
            fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
            $http_response = fgets( $socket, 22 );
            
            if ( preg_match("/200 OK/", $http_response, $regs ) )
            {
                return(true);
                fclose( $socket );
            } else
            {
//                echo "HTTP-Response: $http_response<br>";
                return(false);
            }
        }
    }

	/**
	 * Multiple dirs up
	 */
	public static function dirname2( $path, $depth = 2 )
	{
		for ($d=1 ; $d <= $depth ; $d++)
			$path = dirname( $path );
		
		return $path;
	}

	/**
	 * Extract URLs from CSS text.
	 */
	public static function extract_css_urls($text)
	{
		$urls = array( );
	 
		$url_pattern     = '(([^\\\\\'", \(\)]*(\\\\.)?)+)';
		$urlfunc_pattern = 'url\(\s*[\'"]?' . $url_pattern . '[\'"]?\s*\)';
		$pattern         = '/(' .
			 '(@import\s*[\'"]' . $url_pattern     . '[\'"])' .
			'|(@import\s*'      . $urlfunc_pattern . ')'      .
			'|('                . $urlfunc_pattern . ')'      .  ')/iu';
		if ( !preg_match_all( $pattern, $text, $matches ) )
			return $urls;
	 
		// @import '...'
		// @import "..."
		foreach ( $matches[3] as $match )
			if ( !empty($match) )
				$urls['import'][] = 
					preg_replace( '/\\\\(.)/u', '\\1', $match );
	 
		// @import url(...)
		// @import url('...')
		// @import url("...")
		foreach ( $matches[7] as $match )
			if ( !empty($match) )
				$urls['import'][] = 
					preg_replace( '/\\\\(.)/u', '\\1', $match );
	 
		// url(...)
		// url('...')
		// url("...")
		foreach ( $matches[11] as $match )
			if ( !empty($match) )
				$urls['property'][] = 
					preg_replace( '/\\\\(.)/u', '\\1', $match );
	 
		return $urls;
	}
}