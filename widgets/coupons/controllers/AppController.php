<?php
namespace Widget\Controller;

/*
|--------------------------------------------------------------------------
| Widget app controller
|--------------------------------------------------------------------------
|
| App related logic
|
*/

class AppController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
    }

    /**
     * Main view
     */
    public function getIndex($app, $page)
    {
        $sl =  \App\Core\Secure::array2string(array('app_id' => $app->id, 'page_id' => $page->id));
		$hashPrefix = (\Config::get('system.seo', true)) ? '!' : '';

        $coupons = \Mobile\Controller\WidgetController::getData($page, 'coupons[]', NULL);
        $coupons = (count($coupons) == 0) ? false : true;

        echo \View::make('widget::app.index')->with([
			'app' => $app,
			'page' => $page,
			'sl' => $sl,
			'coupons' => $coupons,
			'hashPrefix' => $hashPrefix
		]);
	}

    /**
     * Edit coupon
     */
    public function editCoupon($app, $page)
    {
        $sl =  \App\Core\Secure::array2string(array('app_id' => $app->id, 'page_id' => $page->id));

        $all_currencies = trans('currencies');
        $currencies = array();
        foreach($all_currencies as $currency => $currency_symbol)
        {
            $currencies[$currency] = $currency_symbol[0] . ' (' . $currency_symbol[1] . ')';
        }

        return \View::make('admin.edit-coupon')->with([
			'app' => $app,
			'page' => $page,
			'currencies' => $currencies,
			'sl' => $sl
		]);
	}

    /**
     * Check if coupon is redeemed with fingerprint
     */
    public static function isRedeemed($page_id, $fingerprint, $code)
    {
		if($fingerprint == '') return 1;

		$check = \Mobile\Model\AppUserData::where('app_page_id', $page_id)->where('name', $code . ';' . $fingerprint . '')->first();

		return (empty($check)) ? 0 : 1;
	}

    /**
     * Currency formatter
     */
    public static function formatCurrency($amount)
    {
		$num_decimals = (intval($amount) == $amount) ? 0 :2;
		return number_format($amount, $num_decimals);
	}

    /**
     * Get coupon
     */
    public function getCoupon($app, $page, $id, $fingerprint)
    {
		$hashPrefix = (\Config::get('system.seo', true)) ? '!' : '';
		$found = false;
		$back = '#' . $hashPrefix . '/nav/' . $page->slug;
        $sl =  \App\Core\Secure::array2string(array('app_id' => $app->id, 'page_id' => $page->id));
        $coupon = \Mobile\Controller\WidgetController::getData($page, 'coupons[' . $id . ']', NULL);
		$social_share = (boolean) \Mobile\Controller\WidgetController::getData($page, 'social_share', 1);

		if($coupon != NULL)
		{
			$coupon = json_decode($coupon);
			$now = \Carbon::now();
			$valid_start = \Carbon::parse($coupon->valid_start)->timezone($app->timezone)->format('Y-m-d H:i:s');
			$valid_end = ($coupon->valid_end != '') ? \Carbon::parse($coupon->valid_end)->timezone($app->timezone)->format('Y-m-d') . ' 23:59:59' : \Carbon::parse($coupon->valid_start)->timezone($app->timezone)->format('Y-m-d') . ' 23:59:59';

			if($valid_start <= $now && $valid_end >= $now)
			{
				// Redeem check
				//$coupon->redeemed = \Widget\Controller\AppController::isRedeemed($page->id, $fingerprint, $coupon->code);
				$coupon->id = $id;
				$found = true;
			}
		}

        return \View::make('app.coupon')->with([
			'app' => $app,
			'page' => $page,
			'sl' => $sl,
			'found' => $found,
			'back' => $back,
			'coupon' => $coupon,
			'social_share' => $social_share
		]);
	}

    /**
     * Get coupons
     */
    public function getCoupons($app, $page)
    {
		$found = 0;
		$return = array();
		$now = \Carbon::now();
		$coupons = \Mobile\Controller\WidgetController::getData($page, 'coupons[]', NULL);

		if($coupons != NULL)
		{
			foreach($coupons as $key => $coupon)
			{
				$valid_start = \Carbon::parse($coupon->valid_start)->timezone($app->timezone)->format('Y-m-d H:i:s');
				$valid_end = ($coupon->valid_end != '') ? \Carbon::parse($coupon->valid_end)->timezone($app->timezone)->format('Y-m-d') . ' 23:59:59' : \Carbon::parse($coupon->valid_start)->timezone($app->timezone)->format('Y-m-d') . ' 23:59:59';
	
				if($valid_start <= $now && $valid_end >= $now)
				{
					// Redeem check
					$fingerprint = \Input::get('fp', '');
					$coupon->redeemed =\Widget\Controller\AppController::isRedeemed($page->id, $fingerprint, $coupon->code);
					$coupon->id = $key;
					$coupon->image = ($coupon->image != '') ? url($coupon->image) : url('widgets/coupons/assets/img/coupon.png');

					$return[] = $coupon;
					$found++;
				}
			}
		}

		if($found == 0) $return = array('found' => 0);

		return \Response::json($return);
	}

    /**
     * Check if redeemed
     */
    public function checkRedeemed($app, $page)
    {
		$code = \Input::get('code', '');
		$fingerprint = \Input::get('fp', '');

		if($code == '') return 1;
		if($fingerprint == '') return 1;

		$check = \Mobile\Model\AppUserData::where('app_page_id', $page->id)->where('name', $code . ';' . $fingerprint . '')->first();

		return (empty($check)) ? 0 : 1;
	}

    /**
     * Redeem coupon
     */
    public function redeemCoupon($app, $page)
    {
        $sl =  \App\Core\Secure::array2string(array('app_id' => $app->id, 'page_id' => $page->id));
		$code = \Input::get('code', '');
		$fingerprint = \Input::get('fp', '');

		if($code == '') die('No code');
		if($fingerprint == '') die('No fingerprint');

		$coupons = \Mobile\Controller\WidgetController::getData($page, 'coupons[]', NULL);

		if($coupons == NULL) die('Coupon not found');

		$found = false;
		foreach($coupons as $coupon)
		{
			if($coupon->code == $code)
			{
				$found = true;
				break;
			}
		}

		if($found === false) die('Code not found');

		$data = array(
			'ip' => \App\Core\IP::address(),
			'coupon' => array(
				'title' => $coupon->title,
				'brief_description' => $coupon->brief_description,
				'deal' => $coupon->deal,
				'original_price' => $coupon->original_price,
				'currency' => $coupon->currency,
				'currency_symbol' => $coupon->currency_symbol,
				'discount' => $coupon->discount,
				'discount_type' => $coupon->discount_type,
				'new_price' => $coupon->new_price,
				'buy' => $coupon->buy,
				'get' => $coupon->get
			)
		);

		$app_user_data = new \Mobile\Model\AppUserData;

		$app_user_data->app_id = $app->id;
		$app_user_data->app_page_id = $page->id;

		$app_user_data->name = $coupon->code . ';' . $fingerprint . '';
		$app_user_data->value = json_encode($data);

		$app_user_data->save();
	}
}