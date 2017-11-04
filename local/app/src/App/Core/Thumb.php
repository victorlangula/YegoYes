<?php
namespace App\Core;

/**
 * Thumbnail class
 *
 *
 * @package		Core
 * @category	Base
 * @version		0.01
 * @since		2014-08-06
 * @author		Sem Kokhuis
 */

class Thumb extends \BaseController {

    /**
     * Create thumbnail
     */
    public function getNail() {
		$return = \Input::get('return', 'img');
		$img = \Input::get('img', '');
		$target = \Input::get('target', ''); // If empty elFinder .tmb path is used
		$w = \Input::get('w', 0);
		$h = \Input::get('h', 0);
		$t = \Input::get('t', 'crop');

		$img_part = pathinfo($img);

		$root = substr(url('/'), strpos(url('/'), \Request::server('HTTP_HOST')));
		$abs_path_prefix = str_replace(\Request::server('HTTP_HOST'), '', $root);

		$img_part['dirname'] = str_replace($abs_path_prefix, '', $img_part['dirname']);
		$img = str_replace($abs_path_prefix, '', $img);

		if($target == '')
		{
			$target = $img_part['dirname'] . '/.tmb/' . $img_part['filename'] . '-' . $w . 'x' . $h . '-' . $t . '.' . $img_part['extension'];
		}

		if($w == 0) $w = NULL;
		if($h == 0) $h = NULL;

		if(! \File::exists(public_path() . $target))
		{
			// Create dir
			if(! \File::isDirectory(public_path() . $img_part['dirname'] . '/.tmb/'))
			{
				\File::makeDirectory(public_path() . $img_part['dirname'] . '/.tmb/');
			}

			if ($t == 'crop')
			{
				$img = \Image::make(public_path() . $img)->fit($w, $h, function ($constraint) use($t) {
					//$constraint->aspectRatio();
				})->save(public_path() . $target);
			}
			elseif($t == 'fit')
			{
				$img = \Image::make(public_path() . $img)->crop($w, $h, function ($constraint) use($t) {
					//$constraint->aspectRatio();
				})->save(public_path() . $target);
			}
			elseif($t == 'resize')
			{
				$img = \Image::make(public_path() . $img)->resize($w, $h, function ($constraint) use($t) {
				
				})->save(public_path() . $target);
			}
			elseif($t == 'resize-ratio')
			{
				$img = \Image::make(public_path() . $img)->resize($w, $h, function ($constraint) use($t) {
					$constraint->aspectRatio();
				})->save(public_path() . $target);
			}
		}

		if($return == 'img')
		{
			$type = 'image/' . $img_part['extension'];

			\Response::make('', 200, 
							array(
							'Content-Type'              => $type,
							'Content-Transfer-Encoding' => 'binary',
							'Content-Disposition'       => 'inline',
							'Expires'                   => 0,
							'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
							'Pragma'                    => 'public',
						 
							));

			readfile(public_path() . $target);
		}
		elseif($return == 'path')
		{
			return $target;
		}
	}
}