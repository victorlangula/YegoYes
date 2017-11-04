<?php
/** * UsersController Class * * Implements actions regarding user management */
class UsersController extends Controller

	{
	/** * Displays the form for account creation * * @return Illuminate\Http\Response */
	public

	function create()
		{
		return View::make(Config::get('confide::signup_form'));
		}

	/** * Stores new account * * @return Illuminate\Http\Response */
	public

	function store()
		{
		$repo = App::make('UserRepository');
		$user = $repo->signup(Input::all());
		if ($user->id)
		{
			$userid = $user->id;
			$username = $user->username;
			//$shopname = $user->shop_name;
			$shopname = $username.'Shop';
            // Set initial plan (free)
            $user->plan_id = 1;
            $user->save();

			Mail::send(Config::get('confide::email_account_confirmation') , compact('user') ,
			function ($message) use($user)
				{
				$message->to($user->email, $user->username)->subject(Lang::get('confide.email.account_confirmation.subject'));
				});
				
			function generateRandomString($length = 10) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				return $randomString;
			}				
				
			$randomkey = generateRandomString();
			$app_details = array(
								'status' => '1',
								'user_id' => $userid,
								'campaign_id' => '1',
								'app_type_id' => '1',
								'theme' => 'black-office',
								'layout' => 'tabs-top',
								'icon' => NULL,
								'name' => $shopname,
								'header_text' => NULL,
								'local_domain' => $randomkey,
								'domain' => NULL,
								'language' => 'en',
								'timezone' => 'UTC',
								'created_by' => $userid,
								'updated_by' => $userid
								);
			
			//Save the App
			$appid = DB::table('apps')->insertGetId($app_details);
								
			$key_details = array(
								'key' => $randomkey,
								'match' => '',
								'expire' => '0',
								'active' => '1'
								);
								
								
			$ecom_page = array(
								'app_id' => $appid,
								'widget' => 'e-commerce',
								'lft' => '1',
								'rgt' => '2',
								'depth' => '0',
								'name' => 'Shop',
								'slug' => 'e-commerce',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
								'created_by' => $userid,
								'updated_by' => $userid
								);
								
			$contact_page = array(
								'app_id' => $appid,
								'widget' => 'contact-us',
								'lft' => '3',
								'rgt' => '4',
								'depth' => '0',
								'name' => 'Contact us',
								'slug' => 'contact-us',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
								'created_by' => $userid,
								'updated_by' => $userid
								);							
								
			//Save the Key
			DB::table('keys')->insert($key_details);
			
			//Save the E-Commarce Page
			$ecom_page_id = DB::table('app_pages')->insertGetId($ecom_page);
			
			//Save the Contact-us Page
			$cont_page_id = DB::table('app_pages')->insertGetId($contact_page);
			
			//***************** E-Commarce Widget Data *********************//					
			$ecom_widget_curr = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'currency',
								'value' => 'TZS',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_flat = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'flat_rate',
								'value' => '0',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_qtty = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'quantity_rate',
								'value' => '0',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_tax = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'tax_rate',
								'value' => '0.00',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_ship = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'tax_shipping',
								'value' => '0.00',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_paym = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'payment_provider',
								'value' => 'Paypal',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);			
								
			$ecom_widget_paymail = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'payment_provider_email',
								'value' => 'victor.langula@gmail.com',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);		
								
			$ecom_widget_sand = array(
								'sort' => NULL,
								'app_page_id' => $ecom_page_id,
								'name' => 'sandbox',
								'value' => '0',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);	
								
			DB::table('app_widget_data')->insert($ecom_widget_curr);
			DB::table('app_widget_data')->insert($ecom_widget_flat);
			DB::table('app_widget_data')->insert($ecom_widget_qtty);
			DB::table('app_widget_data')->insert($ecom_widget_tax);
			DB::table('app_widget_data')->insert($ecom_widget_ship);
			DB::table('app_widget_data')->insert($ecom_widget_paym);
			DB::table('app_widget_data')->insert($ecom_widget_paymail);
			DB::table('app_widget_data')->insert($ecom_widget_sand);
			//###############################################################//
			

			//***************** Contact us Widget Data *********************//
			$cont_widget_imgbox = array(
								'sort' => NULL,
								'app_page_id' => $cont_page_id,
								'name' => 'image_box',
								'value' => '1',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);	
			DB::table('app_widget_data')->insert($cont_widget_imgbox);
			
			$cont_widget_title = array(
								'sort' => NULL,
								'app_page_id' => $cont_page_id,
								'name' => 'title',
								'value' => 'Contact us',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);
			DB::table('app_widget_data')->insert($cont_widget_title);
			
			$cont_widget_cont = array(
								'sort' => NULL,
								'app_page_id' => $cont_page_id,
								'name' => 'content',
								'value' => 'We are here to answer any questions.',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);	
			DB::table('app_widget_data')->insert($cont_widget_cont);
			
			$cont_widget_phonebtn = array(
								'sort' => NULL,
								'app_page_id' => $cont_page_id,
								'name' => 'phone_number_btn',
								'value' => 'Call us directly',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);
			DB::table('app_widget_data')->insert($cont_widget_phonebtn);
			
			$cont_widget_list = array(
								'sort' => NULL,
								'app_page_id' => $cont_page_id,
								'name' => 'list',
								'value' => '{"icon":["ion-ios-telephone","ion-android-mail","ion-ios-world"],"title":["Phone","Email","Website"],"value":["(123) 456-7890","info@example.com","http:\/\/www.example.com"]}',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
								);	
			DB::table('app_widget_data')->insert($cont_widget_list);
			//#################################################################//

			
			return Redirect::action('UsersController@login')->with('notice', Lang::get('confide.alerts.account_created'));
		}
        else
		{
			$error = $user->errors()->all(':message');
			return Redirect::action('UsersController@create')->withInput(Input::except('password'))->with('error', $error);
			}
		}

	/** * Displays the login form * * @return Illuminate\Http\Response */
	public

	function login()
		{
		if (Confide::user())
			{
				return Redirect::to('/platform');
			}
		  else
			{
			return View::make(Config::get('confide::login_form'));
			}
		}

	/** * Attempt to do login * * @return Illuminate\Http\Response */
	public

	function doLogin()
		{
		$repo = App::make('UserRepository');
		$input = Input::all();
		if ($repo->login($input))
			{
				// Increment login count
				$user = User::where('email', '=', $input['email'])
                    ->orWhere('username', '=', $input['email'])
                    ->first();

				$user->increment('logins');
				$user->last_login = date('Y-m-d H:i:s');

				// Set language
				$lang = \Input::get('lang', '');
				if ($lang != '')
				{
					$user->language = $lang;
				}

				$user->save();

                $logout = Session::get('logout', '');

                if($logout == '')
                {
                    // Log
                    \App\Controller\LogController::Log($user, 'Login', 'logged in');
                }

				return Redirect::intended('/platform');
			}
		  else
			{
			if ($repo->isThrottled($input))
				{
				$err_msg = Lang::get('confide.alerts.too_many_attempts');
				}
			elseif ($repo->existsButNotConfirmed($input))
				{
				$err_msg = Lang::get('confide.alerts.not_confirmed');
				}
			  else
				{
				$err_msg = Lang::get('confide.alerts.wrong_credentials');
				}

			return Redirect::action('UsersController@login')->withInput(Input::except('password'))->with('error', $err_msg);
			}
		}

	/** * Attempt to confirm account with code * * @param string $code * * @return Illuminate\Http\Response */
	public

	function confirm($code)
		{
		if (Confide::confirm($code))
			{
			$notice_msg = Lang::get('confide.alerts.confirmation');
			return Redirect::action('UsersController@login')->with('notice', $notice_msg);
			}
		  else
			{
			$error_msg = Lang::get('confide.alerts.wrong_confirmation');
			return Redirect::action('UsersController@login')->with('error', $error_msg);
			}
		}

	/** * Displays the forgot password form * * @return Illuminate\Http\Response */
	public

	function forgotPassword()
		{
		return View::make(Config::get('confide::forgot_password_form'));
		}

	/** * Attempt to send change password link to the given email * * @return Illuminate\Http\Response */
	public

	function doForgotPassword()
		{
		if (Confide::forgotPassword(Input::get('email')))
			{
			$notice_msg = Lang::get('confide.alerts.password_forgot');
			return Redirect::action('UsersController@login')->with('notice', $notice_msg);
			}
		  else
			{
			$error_msg = Lang::get('confide.alerts.wrong_password_forgot');
			return Redirect::action('UsersController@forgotPassword')->withInput()->with('error', $error_msg);
			}
		}

	/** * Shows the change password form with the given token * * @param string $token * * @return Illuminate\Http\Response */
	public

	function resetPassword($token)
		{
		return View::make(Config::get('confide::reset_password_form'))->with('token', $token);
		}

	/** * Attempt change password of the user * * @return Illuminate\Http\Response */
	public

	function doResetPassword()
		{
		$repo = App::make('UserRepository');
		$input = array(
			'token' => Input::get('token') ,
			'password' => Input::get('password') ,
			'password_confirmation' => Input::get('password_confirmation') ,
		);

		// By passing an array with the token, password and confirmation

		if ($repo->resetPassword($input))
			{
			$notice_msg = Lang::get('confide.alerts.password_reset');
			return Redirect::action('UsersController@login')->with('notice', $notice_msg);
			}
		  else
			{
			$error_msg = Lang::get('confide.alerts.wrong_password_reset');
			return Redirect::action('UsersController@resetPassword', array(
				'token' => $input['token']
			))->withInput()->with('error', $error_msg);
			}
		}

	/** * Log the user out of the application. * * @return Illuminate\Http\Response */
	public

	function logout()
		{
            $sl = Session::pull('logout', '');
            if($sl != '')
            {
                $qs = \App\Core\Secure::string2array($sl);
                \Auth::loginUsingId($qs['user_id']);
                return \Redirect::to('/platform#/admin/users');
            }
            else
            {
                // Log
                \App\Controller\LogController::Log(Auth::user(), 'Login', 'logged out');

                Confide::logout();
                return Redirect::to('/login?lang=' . \App::getLocale());
            }
		}
	}

