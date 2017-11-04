<?php
namespace Mobile\Controller;

/*
|--------------------------------------------------------------------------
| Theme controller
|--------------------------------------------------------------------------
|
| Theme related logic
|
*/

class ThemeController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
		if(\Auth::check())
		{
			$this->parent_user_id = (\Auth::user()->parent_id == NULL) ? \Auth::user()->id : \Auth::user()->parent_id;
		}
		else
		{
			$this->parent_user_id = NULL;
		}
    }

    /**
     * Load all theme config
     */
    public static function loadAllThemeConfig($first = NULL)
    {
		$first_element = NULL;
		$themes_dir = public_path() . '/themes/';
		$themes = \File::directories($themes_dir);

		$theme_config = array();

		foreach($themes as $theme)
		{
			$theme_config_file = $theme . '/config/theme.php';
			$theme_lang_file = $theme . '/lang/' . \App::getLocale() . '/global.php';

			if (! \File::exists($theme_lang_file)) $theme_lang_file = $theme . '/lang/en/global.php';

			if(\File::exists($theme_config_file) && \File::exists($theme_lang_file))
			{
				$config = \File::getRequire($theme_config_file);
				$lang = \File::getRequire($theme_lang_file);
				$config['dir'] = basename($theme);

				if($config['active'])
				{
					if($first == $config['dir'])
					{
						$first_element[$lang['name']] = $config;
					}
					else
					{
						$theme_config[$lang['name']] = $config;
					}
				}
			}
		}

		ksort($theme_config);

		if($first_element != NULL)
		{
			$theme_config = array_merge($first_element, $theme_config);
		}

        return $theme_config;
    }

    /**
     * Load theme config
     */
    public static function loadThemeConfig($theme)
    {
		$theme_config_file = public_path() . '/themes/' . $theme . '/config/theme.php';
		$theme_lang_file = public_path() . '/themes/' . $theme . '/lang/' . \App::getLocale() . '/global.php';

		if (! \File::exists($theme_lang_file)) $theme_lang_file = $theme . '/lang/en/global.php';

		if(\File::exists($theme_config_file) && \File::exists($theme_lang_file))
		{
			$config = \File::getRequire($theme_config_file);
			$lang = \File::getRequire($theme_lang_file);
			$config['dir'] = $theme;
			$config['name'] = $lang['name'];
		}

        return $config;
    }

    /**
     * Generate template
     */
    public static function getGenerate()
    {
        $screenshot = true;
        $preview = \Request::get('preview', false);
/*
        $themes = array(
            'blog' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#cacbd0', 'tab_active' =>'#243542'),
            'breakfast' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'business' => array('type' =>'dark', 'dark_color' =>'#78abc8', 'light_color' =>'#fff'),
            'concrete' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'education' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'events' => array('type' =>'light', 'dark_color' =>'#fc0000', 'light_color' =>'#f4e0da', 'tab_active' =>'#222'),
            'fireplace' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'music' => array('type' =>'dark', 'dark_color' =>'#555', 'light_color' =>'#fff'),
            'other' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#57a0f2', 'text_color' =>'#222'),
            'photography' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#111'),
            'restaurants' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'font_family' =>'serif', 'tab_active' =>'#fcdd91', 'text_color' =>'#efefef'),
            'sunset' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'water' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'wood' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222')
        );

        $themes = array(
            'business' => array('type' =>'dark', 'dark_color' =>'#78abc8', 'light_color' =>'#fff'),
        );
 */
        $themes = array(
            'blog' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#cacbd0', 'tab_active' =>'#243542'),
            'breakfast' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'business' => array('type' =>'dark', 'dark_color' =>'#78abc8', 'light_color' =>'#fff'),
            'concrete' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'education' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'events' => array('type' =>'light', 'dark_color' =>'#fc0000', 'light_color' =>'#f4e0da', 'tab_active' =>'#222'),
            'fireplace' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'music' => array('type' =>'dark', 'dark_color' =>'#555', 'light_color' =>'#fff'),
            'other' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#57a0f2', 'text_color' =>'#222'),
            'photography' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#111'),
            'restaurants' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'font_family' =>'serif', 'tab_active' =>'#fcdd91', 'text_color' =>'#efefef'),
            'sunset' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222'),
            'water' => array('type' =>'dark', 'dark_color' =>'#222', 'light_color' =>'#fff', 'tab_active' =>'#888'),
            'wood' => array('type' =>'light', 'dark_color' =>'#222', 'light_color' =>'#fff', 'text_color' =>'#222')
        );

		foreach($themes as $_theme => $_val)
		{
			$theme = $_theme;

            // Theme paths
            $target_css = public_path() . '/themes/' . $theme . '/assets/css/style.css';
            $bg_image = public_path() . '/themes/' . $theme . '/assets/img/background-phone.png';
            $preview_image = public_path() . '/themes/' . $theme . '/assets/img/preview.png';

			// Extract theme bg image colors
			$color_extract = new \League\ColorExtractor\Client;
			$image = $color_extract->loadPng($bg_image);
			//$image->setMinColorRatio(0);
			$palette = $image->extract(7);

            if(! isset($palette[0])) $palette[0] = '#f8f8f8';
            if(! isset($palette[1])) $palette[1] = '#387ef5';
            if(! isset($palette[2])) $palette[2] = '#11c1f3';
            if(! isset($palette[3])) $palette[3] = '#33cd5f';
            if(! isset($palette[4])) $palette[4] = '#ffc900';
            if(! isset($palette[5])) $palette[5] = '#ef473a';
            if(! isset($palette[6])) $palette[6] = '#886aea';

            // Dark or light theme?
            $theme_type = $_val['type']; //'light';

            // Sort colors
            $palette = \Mobile\Controller\ThemeController::cf_sort_hex_colors($palette);

            if($theme_type == 'light')
            {
                $palette = array_reverse($palette);
            }

            // Ionic paths
            $ionic_scss_path = public_path() . '/build/vendor/ionic/scss/';
            $ionic_scss = \File::get($ionic_scss_path . 'ionic.scss');

            // Remove icons
            $ionic_scss = str_replace('"ionicons/ionicons.scss",', '', $ionic_scss);

            // Variables
			$stable = $palette[0];
			$positive = $palette[1];
			$calm = $palette[2];
			$balanced = $palette[3];
			$energized = $palette[4];
			$assertive = $palette[5];
			$royal = $palette[6];

			$stable_contrast = \Mobile\Controller\ThemeController::getContrast($stable);
			$positive_contrast = \Mobile\Controller\ThemeController::getContrast($positive);
			$calm_contrast = \Mobile\Controller\ThemeController::getContrast($calm);
			$balanced_contrast = \Mobile\Controller\ThemeController::getContrast($balanced);
			$energized_contrast = \Mobile\Controller\ThemeController::getContrast($energized);
			$assertive_contrast = \Mobile\Controller\ThemeController::getContrast($assertive);
			$royal_contrast = \Mobile\Controller\ThemeController::getContrast($royal);
			if(isset($_val['tab_active'])) $tab_active_contrast = \Mobile\Controller\ThemeController::getContrast($_val['tab_active']);

            if($theme_type == 'light')
            {
                $light = $_val['light_color'];
                $dark = $_val['dark_color'];
                $base_color = '#222222';
                $link_color = 'darken($stable, 50%)';
                $link_color_hover = 'darken($stable, 70%)';
            }
            elseif($theme_type == 'dark')
            {
                $light = $_val['dark_color'];
                $dark = $_val['light_color'];
                $base_color = '#ffffff';
                $link_color = 'lighten($stable, 60%) !default';
                $link_color_hover = 'lighten($stable, 90%) !default';

				$stable = $stable_contrast; //$palette[0];
				$stable_contrast = $palette[0]; //$stable_contrast;
            }

            $light_contrast = \Mobile\Controller\ThemeController::getContrast($light);
            $dark_contrast = \Mobile\Controller\ThemeController::getContrast($dark);

			$text_color = (isset($_val['text_color'])) ? $_val['text_color']: $light_contrast;

			if(isset($_val['font_family'])) 
			{
				$font_family = $_val['font_family'];
				$font_family_light = $_val['font_family'];
				$font_family_serif = $_val['font_family'];
			}
			else
			{
				$font_family = '"Helvetica Neue", "Roboto", sans-serif';
				$font_family_light = '"HelveticaNeue-Light", "Roboto-Light", sans-serif-light';
				$font_family_serif = 'serif';
			}

            // Transparent background for text
            $rgb = \Mobile\Controller\ThemeController::hex2rgb($palette[0]);

            $ionic_vars = '
$light:                           ' . $light . ' !default;
$stable:                          ' . $stable . ' !default;
$positive:                        ' . $positive . ' !default;
$calm:                            ' . $calm . ' !default;
$balanced:                        ' . $balanced . ' !default;
$energized:                       ' . $energized . ' !default;
$assertive:                       ' . $assertive . ' !default;
$royal:                           ' . $royal . ' !default;
$dark:                            ' . $dark . ' !default;

// Base
// -------------------------------

$font-family-sans-serif:          ' . $font_family . ' !default;
$font-family-light-sans-serif:    ' . $font_family_light . ' !default;
$font-family-serif:               ' . $font_family_serif . ' !default;
$font-family-monospace:           monospace !default;

$base-background-color:           ' . $positive . ' !default;
$base-color:                      ' . $text_color . ' !default;
.item-body p { color: ' . $text_color . ' !important;}

$link-color:                      ' . $link_color . ';
$link-hover-color:                ' . $link_color_hover . ';

$button-stable-bg:                $stable !default;
$button-stable-text:              ' . $stable_contrast . ' !default;
$button-stable-border:            darken($stable, 10%) !default;
$button-stable-active-bg:         darken($stable, 10%) !default;
$button-stable-active-border:     darken($stable, 30%) !default;

$button-positive-bg:              $positive !default;
$button-positive-text:            ' . $positive_contrast . ' !default;
$button-positive-border:          darken($positive, 10%) !default;
$button-positive-active-bg:       darken($positive, 10%) !default;
$button-positive-active-border:   darken($positive, 30%) !default;

$button-calm-bg:                  $calm !default;
$button-calm-text:                ' . $calm_contrast . ' !default;
$button-calm-border:              darken($calm, 10%) !default;
$button-calm-active-bg:           darken($calm, 10%) !default;
$button-calm-active-border:       darken($calm, 30%) !default;

$button-assertive-bg:             $assertive !default;
$button-assertive-text:           ' . $assertive_contrast . ' !default;
$button-assertive-border:         darken($assertive, 10%) !default;
$button-assertive-active-bg:      darken($assertive, 10%) !default;
$button-assertive-active-border:  darken($assertive, 30%) !default;

$button-balanced-bg:              $balanced !default;
$button-balanced-text:            ' . $balanced_contrast . ' !default;
$button-balanced-border:          darken($balanced, 10%) !default;
$button-balanced-active-bg:       darken($balanced, 10%) !default;
$button-balanced-active-border:   darken($balanced, 30%) !default;

$button-energized-bg:             $energized !default;
$button-energized-text:           ' . $energized_contrast . ' !default;
$button-energized-border:         darken($energized, 5%) !default;
$button-energized-active-bg:      darken($energized, 5%) !default;
$button-energized-active-border:  darken($energized, 5%) !default;

$button-royal-bg:                 $royal !default;
$button-royal-text:               ' . $royal_contrast . ' !default;
$button-royal-border:             darken($royal, 8%) !default;
$button-royal-active-bg:          darken($royal, 8%) !default;
$button-royal-active-border:      darken($royal, 8%) !default;

$button-light-bg:                 $light !default;
$button-light-text:               ' . $dark . ' !default;
$button-light-border:             darken($button-light-bg, 10%) !default;
$button-light-active-bg:          darken($button-light-bg, 10%) !default;
$button-light-active-border:      darken($button-light-bg, 30%) !default;

$button-dark-bg:                  $dark !default;
$button-dark-text:                ' . $light . ' !default;
$button-dark-border:              darken($button-dark-bg, 10%) !default;
$button-dark-active-bg:           darken($button-dark-bg, 10%) !default;
$button-dark-active-border:       darken($button-dark-bg, 30%) !default;

$button-default-bg:               $button-stable-bg !default;
$button-default-text:             $button-stable-text !default;
$button-default-border:           $button-stable-border !default;
$button-default-active-bg:        $button-stable-active-bg !default;
$button-default-active-border:    $button-stable-active-border !default;

// Items
// -------------------------------

$item-default-text:               ' . $_val['dark_color'] . ' !default;
$item-default-active-bg:          darken($light, 20%) !default;

.item.item-body { color: ' . $text_color . '; }

// Custom
// -------------------------------

.transparent { 
	background-color: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.5); 
	padding:20px; 
	width:100%;
	display:list-item;
	margin-bottom:10px;
}
.transparent > a { color: $link-color; }
.transparent > a:hover { color: $link-color-hover; }
.transparent ol,
.transparent ul {
	list-style: inside;
}
.transparent ol li,
.transparent ul li{
	margin-left:5px;
}
.transparent ol li {
	list-style: decimal;
	margin-left:25px;
}

// Forms
// -------------------------------

$input-bg:                        ' . $light . ' !default;
$input-bg-disabled:               $stable !default;

$input-color:                     ' . $light_contrast . ' !default;
$input-border:                    $item-default-border !default;
$input-border-width:              $item-border-width !default;
$input-label-color:               ' . $dark . ' !default;
$input-color-placeholder:         lighten($dark, 40%) !default;

textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"] {
  color: ' . $light_contrast . ' !important;
  background: ' . $light . ' !important;
}
.item-checkbox {
  color: ' . $light_contrast . ' !important;
}

$modal-bg-color:                  ' . $positive . ' !default;
.modal { color: ' . $text_color . '; }
';

if(isset($_val['tab_active']))
{
	$ionic_vars .= 'ion-tabs.tabs-color-active-positive .tab-item.tab-item-active, ion-tabs.tabs-color-active-positive .tab-item.active, ion-tabs.tabs-color-active-positive .tab-item.activated { color:' . $_val['tab_active'] . ' !important; }';
	$ionic_vars .= '.item-content.activated { color:' . $tab_active_contrast . ' !important; }';
}

            $scss = new \scssc();
            $scss->setFormatter("scss_formatter_compressed");
            $scss->setImportPaths($ionic_scss_path);

            $css = $scss->compile($ionic_vars . $ionic_scss);

            $css_extra = '';

            if (! $preview)
            {
                \File::put($target_css, $css . $css_extra);

                // Generate screenshot
                if($screenshot)
                {
                    $url = url('/api/v1/app-theme/preview/' . $theme);

                    \Mobile\Controller\ThemeController::screenshot($url, $preview_image, 1);
                }
                echo $theme . ' done<br>';
            }
            else
            {
                return \View::make('user.app.preview', array(
                    'theme' => $theme,
                    'css' => $css . $css_extra
                ));
                echo 'prev';
            }
		}
		return 'Ready';
    }


    /**
     * Generate default template
     */
    public static function getGenerateDefault()
    {
        $screenshot = true;
        $preview = \Request::get('preview', false);
        $themes = array(
            'blog' => array('type' =>'light'),
            'business' => array('type' =>'dark'),
            'education' => array('type' =>'light'),
            'events' => array('type' =>'light'),
            'music' => array('type' =>'dark'),
            'other' => array('type' =>'light'),
            'photography' => array('type' =>'light'),
            'restaurants' => array('type' =>'dark'),
        );

        $themes = array(
            'education' => array('type' =>'light'),
            'other' => array('type' =>'light'),
        );

		foreach($themes as $_theme => $_val)
		{
			$theme = $_theme;

            // Theme paths
            $target_css = public_path() . '/themes/' . $theme . '/assets/css/style.css';
            $bg_image = public_path() . '/themes/' . $theme . '/assets/img/background-phone.png';
            $preview_image = public_path() . '/themes/' . $theme . '/assets/img/preview.png';

            // Dark or light theme?
            $theme_type = $_val['type']; //'light';

            // Ionic paths
            $ionic_scss_path = public_path() . '/build/vendor/ionic/scss/';
            $ionic_scss = \File::get($ionic_scss_path . 'ionic.scss');

            // Remove icons
            $ionic_scss = str_replace('"ionicons/ionicons.scss",', '', $ionic_scss);

            $ionic_vars = '
// Custom
// -------------------------------

.transparent { background-color: rgba(255,255,255, 0.5); padding:20px; }
.transparent a { color: $link-color; }
.transparent a:hover { color: $link-color-hover; }
';

            $scss = new \scssc();
            $scss->setFormatter("scss_formatter_compressed");
            $scss->setImportPaths($ionic_scss_path);

            $css = $scss->compile($ionic_vars . $ionic_scss);

            $css_extra = '';

            if (! $preview)
            {
                \File::put($target_css, $css . $css_extra);

                // Generate screenshot
                if($screenshot)
                {
                    $url = url('/api/v1/app-theme/preview/' . $theme);

                    \Mobile\Controller\ThemeController::screenshot($url, $preview_image, 1);
                }
                echo $theme . ' done<br>';
            }
            else
            {
                return \View::make('user.app.preview', array(
                    'theme' => $theme,
                    'css' => $css . $css_extra
                ));
                echo 'prev';
            }
		}
		return 'Ready';
    }

    public static function screenshot($url, $thumbnail, $empty_cache = 0, $timeout = 800)
    {
		\Config::set('screenshotserver.url', 'http://screenshotserver.dev');

        if($empty_cache == '0' && \File::exists($thumbnail))
        {
            return false;
        }

		$img = \Image::canvas(120, 200);

		$thumb_phone_url = file_get_contents(\Config::get('screenshotserver.url') . '/grab?url=' . $url . '&empty_cache=' . $empty_cache . '&browser_width=480&browser_height=800&thumb_width=120&thumb_height=null&timeout=' . $timeout);
		$thumb_phone = \Image::make('http:' . $thumb_phone_url);

		//$img->insert(public_path() . '/assets/images/mockups/shadow.png');
		$img->insert($thumb_phone, NULL, 0, 0);

		$img->save($thumbnail, 60);

		return $img->response();
    }

    /**
     * Preview template
     */
    public static function getPreview($theme)
    {
        return \View::make('user.app.preview', array(
            'theme' => $theme
        ));
    }

    public static function cf_sort_hex_colors($colors) {
        $map = array(
            '0' => 0,
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            'a' => 10,
            'b' => 11,
            'c' => 12,
            'd' => 13,
            'e' => 14,
            'f' => 15,
        );
        $c = 0;
        $sorted = array();
        foreach ($colors as $color) {
            $color = strtolower(str_replace('#', '', $color));
            if (strlen($color) == 6) {
                $condensed = '';
                $i = 0;
                foreach (preg_split('//', $color, -1, PREG_SPLIT_NO_EMPTY) as $char) {
                    if ($i % 2 == 0) {
                        $condensed .= $char;
                    }
                    $i++;
                }
                $color_str = $condensed;
            }
            $value = 0;
            foreach (preg_split('//', $color_str, -1, PREG_SPLIT_NO_EMPTY) as $char) {
                $value += intval($map[$char]);
            }
            $value = str_pad($value, 5, '0', STR_PAD_LEFT);
            $sorted['_'.$value.$c] = '#'.$color;
            $c++;
        }
        ksort($sorted);
        $colors = array();
        foreach($sorted as $color)
        {
            $colors[] = $color;
        }
        return $colors;
    }

	public static function getContrast($hexcolor, $dark = '#222', $light = '#fff')
	{
		if($hexcolor == '#ffffff' || $hexcolor == '#fff') return $dark;
		return (hexdec($hexcolor) > 0xffffff/2) ? $dark : $light;
	}

	public static function hex2rgb($hex)
	{
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}

    public static function adjustBrightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }
}