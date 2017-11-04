<?php
namespace App\Controller;

use RedBeanPHP\R;

/*
|--------------------------------------------------------------------------
| Admin controller
|--------------------------------------------------------------------------
|
| Admin related logic
|
*/

class AdminController extends \BaseController {

    /**
     * Show purchases overview
     */
    public function getPurchases()
    {
        $users = \User::all();

        return \View::make('app.admin.purchases', array(
            'users' => $users
        ));
    }

    /**
     * Show invoice modal for admin
     */
    public function getInvoiceModal()
	{
        $sl = \Request::input('sl', NULL);
  
        if($sl != NULL)
        {
            $qs = \App\Core\Secure::string2array($sl);

			$sqlite = storage_path() . '/userdata/subscription_orders.sqlite';
			R::setup('sqlite:' . $sqlite);

			$order = R::findOne('orders', 'id = ' . $qs['invoice_id']);

			R::close();

			return \View::make('app.admin.modal.invoice', array(
				'sl' => $sl,
				'invoice_date' => $order->invoice_date,
				'payment_method' => $order->payment_method,
				'cost' => $order->cost,
				'cost_str' => $order->cost_str,
				'plan_id' => $order->plan_id,
				'plan_name' => $order->plan_name,
				'expires' => $order->new_date,
				'period' => $order->period,
				'expires' => $order->expires,
				'user_name' => $order->user_name,
				'status' => $order->status
			));
        }
    }

    /**
     * Update invoice status
     */
    public function postUpdateInvoiceStatus()
    {
		$sl = \Request::input('sl', '');
		$status = \Request::input('status', '');

		if ($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);

			$sqlite = storage_path() . '/userdata/subscription_orders.sqlite';
			R::setup('sqlite:' . $sqlite);

			$order = R::findOne('orders', 'id = ' . $qs['invoice_id']);
			$order->status = $status;

			R::store($order);

			R::close();
		}

		return \Response::json(array(
			'result' => 'success'
		));
    }

    /**
     * Delete invoice
     */
    public function postDeleteInvoice()
    {
		$sl = \Request::input('sl', '');
		$status = \Request::input('status', '');

        if($sl != '')
        {
            $qs = \App\Core\Secure::string2array($sl);

			$sqlite = storage_path() . '/userdata/subscription_orders.sqlite';
			R::setup('sqlite:' . $sqlite);

			$order = R::findOne('orders', 'id = ' . $qs['invoice_id']);

			R::trash($order);

			R::close();
        }

		return \Response::json(array(
			'result' => 'success'
		));
    }

    /**
     * Get purchase data
     */
    public function getPurchaseData()
    {
		$order_by = \Input::get('order.0.column', 0);
		$order = \Input::get('order.0.dir', 'asc');
		$search = \Input::get('search.regex', '');
		$q = \Input::get('search.value', '');
		$start = \Input::get('start', 0);
		$draw = \Input::get('draw', 1);
		$length = \Input::get('length', 10);
		$data = array();

		$aColumn = array('invoice', 'user_mail', 'user_name', 'plan_name', 'expires', 'payment_method', 'cost_str', 'invoice_date', 'status');

		// Open orders database
		$sqlite = storage_path() . '/userdata/subscription_orders.sqlite';
		R::setup('sqlite:' . $sqlite);

		if($q != '')
		{
			$count = R::count('orders', 
				' 	invoice LIKE ? 
					OR user_mail LIKE ? 
					OR user_name LIKE ? 
					OR plan_name LIKE ? 
					OR expires LIKE ? 
					OR payment_method LIKE ? 
					OR cost_str LIKE ? 
					OR invoice_date LIKE ? 
					OR status LIKE ? 
				', [ 
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%'
			]);

			$oData = R::find('orders', 
				' 	invoice LIKE ? 
					OR user_mail LIKE ? 
					OR user_name LIKE ? 
					OR plan_name LIKE ? 
					OR expires LIKE ? 
					OR payment_method LIKE ? 
					OR cost_str LIKE ? 
					OR invoice_date LIKE ? 
					OR status LIKE ? 
					LIMIT :start, :length 
				', [ 
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				'%' . $q . '%',
				':start' => $start,
				':length' => $length
			]);
		}
		else
		{
			$count = R::count('orders');
			$oData = R::findAll('orders', ' ORDER BY ' . $aColumn[$order_by] . ' ' . $order . ' LIMIT :start, :length', [':start' => $start, ':length' => $length]);
		}

		R::close();

		if($length == -1) $length = $count;

		$recordsTotal = $count;
		$recordsFiltered = $count;

		foreach($oData as $row)
		{
			$data[] = array(
				'DT_RowId' => 'row_' . $row->invoice,
				'invoice' => $row->invoice,
				'user_mail' => $row->user_mail,
				'user_name' => $row->user_name,
				'plan_name' => $row->plan_name,
				'expires' => $row->expires,
				'payment_method' => $row->payment_method,
				'cost_str' => $row->cost_str,
				'invoice_date' => \Carbon::parse($row->invoice_datetime)->timezone(\Auth::user()->timezone)->format('Y-m-d H:i:s'),
				'status' => $row->status,
				'sl' => \App\Core\Secure::array2string(array('invoice_id' => $row->id))
			);
		}

		$response = array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data
		);

		echo json_encode($response);
    }

    /**
     * Website settings modal
     */
    public function getWebsiteSettingsModal()
    {
		$favicon = \App\Core\Settings::get('favicon', '/favicon.ico');
		$page_title = \App\Core\Settings::get('page_title', trans('global.app_title'));
		$page_description = \App\Core\Settings::get('page_description', trans('global.app_title_slogan'));

        return \View::make('app.admin.modal.website-settings', array(
				'favicon' => $favicon,
				'page_title' => $page_title,
				'page_description' => $page_description
			));
    }

    /**
     * Website template
     */
    public function getWebsite()
    {
		$sl = \Request::input('sl', '');
		$templates = \App\Controller\WebsiteController::loadAllTemplateConfig();
		$active_template = \App\Core\Settings::get('website_template', 'default');

		if ($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
			$template = \App\Controller\WebsiteController::loadTemplateConfig($qs['template_dir']);
			$template = $template[key($template)];

			\Lang::addNamespace('website', public_path() . '/website/' . $qs['template_dir'] . '/lang');
			\Lang::addNamespace('custom', storage_path() . '/userdata/templates/' . $qs['template_dir'] . '/lang');
			\View::addNamespace('website', public_path() . '/website/' . $qs['template_dir'] . '/views');
			\Config::addNamespace('website', public_path() . '/website/' . $qs['template_dir'] . '/config');

			return \View::make('app.admin.website-edit', array(
				'sl' => $sl,
				'template' => $template,
				'active_template' => $active_template
			));
		}
		else
		{
			return \View::make('app.admin.website', array(
				'templates' => $templates,
				'active_template' => $active_template
			));
		}
    }

    /**
     * Set active template
     */
    public function getActivateTemplate()
    {
		$data = \Request::input('data', '');

		if ($data != '')
		{
			$qs = \App\Core\Secure::string2array($data);
			\App\Core\Settings::set('website_template', $qs['template_dir']);

			$response = array(
				'result' => 'success', 
				'template' => $qs['template_dir']
			);

			return \Response::json($response);
		}
    }

    /**
     * Update general website settings
     */
    public function postWebsiteUpdate()
    {
		\App\Core\Settings::set('favicon', \Request::input('favicon'));
		\App\Core\Settings::set('page_title', \Request::input('page_title'));
		\App\Core\Settings::set('page_description', \Request::input('page_description'));

		return \Response::json(array(
			'result' => 'success'
		));
    }

    /**
     * Update template settings
     */
    public function postTemplateUpdate()
    {
		$sl = \Request::input('sl', '');
		$lang = \Input::except(array('sl', '_token'));

		if ($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
			$template_lang_storage = storage_path() . '/userdata/templates/' . $qs['template_dir'] . '/lang/en';

			if (! \File::isDirectory($template_lang_storage))
			{
				\File::makeDirectory($template_lang_storage, 0777, true);
			}

			$lang_string = implode(', ', array_map(function ($v, $k) { return '"' . $k . '" => "' . str_replace(chr(13), '<br>', str_replace('"', '&quot;', $v)) . '"'; }, $lang, array_keys($lang)));
			$lang_string = rtrim($lang_string, ',');

			$lang_file = '<?php

return array(
	' . $lang_string . '
);

';

			$template_file = $template_lang_storage . '/global.php';

			\File::put($template_file, $lang_file);
		}

		return \Response::json(array(
			'result' => 'success'
		));
    }

    /**
     * Show plans overview
     */
    public function getPlans()
    {
        $plans = \App\Model\Plan::orderBy('sort')->get();

        return \View::make('app.admin.plans', array(
            'plans' => $plans
        ));
    }

    /**
     * New or edit plan
     */
    public function getPlan()
    {
		$sl = \Request::input('sl', '');
		$widgets = \Mobile\Controller\WidgetController::loadAllWidgetConfig();

		if($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
       		$plan = \App\Model\Plan::find($qs['plan_id']);
       		$settings = json_decode($plan->settings);

			return \View::make('app.admin.plan-edit', array(
				'sl' => $sl,
				'plan' => $plan,
				'widgets' => $widgets,
				'settings' => $settings
			));
		}
		else
		{
			return \View::make('app.admin.plan-new', array(
				'widgets' => $widgets
			));
		}
    }

    /**
     * Save new plan
     */
    public function postPlanNew()
    {
		$input = array(
			'name' => \Input::get('name'),
			'max_apps' => \Input::get('max_apps'),
			'support' => \Input::get('support'),
			'domain' => \Input::get('domain'),
			'download' => \Input::get('download'),
			'monthly' => \Input::get('monthly'),
			'annual' => \Input::get('annual'),
			'currency' => \Input::get('currency'),
			'featured' => \Input::get('featured')
		);

		$rules = array(
			'name' => 'required',
			'max_apps' => 'required'
		);

        $validator = \Validator::make($input, $rules);

        if ($validator->fails())
        {
			$response = array(
				'result' => 'error', 
				'result_msg' => $validator->messages()->first()
			);
        }
        else
        {
            $plan = new \App\Model\Plan;

            $plan->name = $input['name'];
            $plan->sort = \DB::table('plans')->max('sort') + 10;
            $plan->settings = \App\Core\Settings::json(array(
				'max_apps' => $input['max_apps'],
				'support' => $input['support'],
				'domain' => $input['domain'],
				'download' => $input['download'],
				'widgets' => \Request::input('widget'),
				'monthly' => $input['monthly'],
				'annual' => $input['annual'],
				'currency' => $input['currency'],
				'featured' => $input['featured']
			));

            if ($plan->save())
            {
                $response = array(
                    'result' => 'success', 
                    'result_msg' => trans('admin.new_plan_created')
                );
            }
            else
            {
                $response = array(
                    'result' => 'error', 
                    'result_msg' => $plan->errors()->first()
                );
            }
        }
		return \Response::json($response);
    }

    /**
     * Update existing plan
     */
    public function postPlanUpdate()
    {
		$sl = \Input::get('sl');
		$qs = \App\Core\Secure::string2array($sl);

        if(! is_numeric($qs['plan_id'])) return 'Encryption Error.';

		$input = array(
			'name' => \Input::get('name'),
			'max_apps' => \Input::get('max_apps'),
			'support' => \Input::get('support'),
			'domain' => \Input::get('domain'),
			'download' => \Input::get('download'),
			'monthly' => \Input::get('monthly'),
			'annual' => \Input::get('annual'),
			'currency' => \Input::get('currency'),
			'featured' => \Input::get('featured')
		);

		$rules = array(
			'name' => 'required',
			'max_apps' => 'required'
		);

        $validator = \Validator::make($input, $rules);

        if($validator->fails())
        {
			$response = array(
				'result' => 'error', 
				'result_msg' => $validator->messages()->first()
			);
        }
        else
        {
            $plan = \App\Model\Plan::find($qs['plan_id']);

            $plan->name = $input['name'];
			$plan->settings = \App\Core\Settings::json(array(
				'max_apps' => $input['max_apps'],
				'support' => $input['support'],
				'domain' => $input['domain'],
				'download' => $input['download'],
				'widgets' => \Request::input('widget'),
				'monthly' => $input['monthly'],
				'annual' => $input['annual'],
				'currency' => $input['currency'],
				'featured' => $input['featured']
			), $plan->settings);

            if($plan->save())
            {
                $response = array(
                    'result' => 'success', 
                    'result_msg' => trans('global.changes_saved')
                );

           }
            else
            {
                $response = array(
                    'result' => 'error', 
                    'result_msg' => $plan->errors()->first()
                );
            }
        }
		return \Response::json($response);
    }

    /**
     * Delete plan
     */
    public function getDeletePlan()
    {
		$sl = \Request::input('data', '');

        if($sl != '')
        {
            $qs = \App\Core\Secure::string2array($sl);
            $response = array('result' => 'success');

			if($qs['plan_id'] > 1)
			{
				// Check if there are user with this plan
				$user = \User::where('plan_id', '=', $qs['plan_id'])->first();
				if (empty($user))
				{
	            	$plan = \App\Model\Plan::where('id', '=',  $qs['plan_id'])->where('id', '<>',  1)->forceDelete();
				}
				else
				{
					$response = array('result' => 'error', 'msg' => trans('admin.delete_plan_restricted'));
				}
			}
        }
		return \Response::json($response);
    }

    /**
     * Sort plans
     */
    public function postPlanSort()
    {
		// Get nodes
		$node = \Input::get('node', '');
		$node_prev = \Input::get('node_prev', '');
		$node_next = \Input::get('node_next', '');

		$node = \App\Model\Plan::where('id', '=', $node)->first();

		if (! empty($node))
		{
			// Reorder
			if(is_numeric($node_prev))
			{
				$node_prev = \App\Model\Plan::where('id', '=', $node_prev)->first();
				$new_sort = $node_prev->sort + 10;

				// Increment
				\App\Model\Plan::where('sort', '>=', $new_sort)->increment('sort', 10);
			}
			elseif(is_numeric($node_next))
			{
				$node_next = \App\Model\Plan::where('id', '=', $node_next)->first();
				$new_sort = $node_next->sort;

				// Increment
				\App\Model\Plan::where('sort', '>=', $new_sort)->increment('sort', 10);
			}

			$node->sort = $new_sort;
			$node->save();
		}

		return \Response::json(array('status' => 'success'));
	}

    /**
     * Show user overview
     */
    public function getUsers()
    {
        $users = \User::all();

        return \View::make('app.admin.users', array(
            'users' => $users
        ));
    }

    /**
     * Show user partial
     */
    public function getUser()
    {
		$sl = \Request::input('sl', '');

		if($sl != '')
		{
			$qs = \App\Core\Secure::string2array($sl);
       		$user = \User::find($qs['user_id']);

			return \View::make('app.admin.user-edit', array(
				'sl' => $sl,
				'user' => $user
			));
		}
		else
		{
			return \View::make('app.admin.user-new');
		}
    }

    /**
     * Login as user
     */
    public function getLoginAs($sl)
    {
		if($sl != '')
		{
            // Set session to redirect to in case of logout
            $logout = \App\Core\Secure::array2string(['user_id' => \Auth::user()->id]);
            \Session::put('logout', $logout);

			$qs = \App\Core\Secure::string2array($sl);
			\Auth::loginUsingId($qs['user_id']);
			return \Redirect::to('/platform');
		}
    }

    /**
     * Delete user
     */
    public function postUserDelete()
    {
		$sl = \Request::input('sl', '');

        if($sl != '')
        {
            $qs = \App\Core\Secure::string2array($sl);
            $response = array('result' => 'success');

			if($qs['user_id'] > 1)
			{
	            $user = \User::where('id', '=',  $qs['user_id'])->where('id', '<>',  1)->forceDelete();
			}
			else
			{
                $response = array('result' => 'error', 'msg' => trans('global.cant_delete_owner'));
			}
        }
		return \Response::json($response);
    }

    /**
     * Get user data
     */
    public function getUserData()
    {
		$order_by = \Input::get('order.0.column', 0);
		$order = \Input::get('order.0.dir', 'asc');
		$search = \Input::get('search.regex', '');
		$q = \Input::get('search.value', '');
		$start = \Input::get('start', 0);
		$draw = \Input::get('draw', 1);
		$length = \Input::get('length', 10);
		$data = array();

		$aColumn = array('id', 'email', 'username', 'role', 'plan_id', 'expires', 'logins', 'last_login', 'created_at');

		if($q != '')
		{
			$count = \User::orderBy($aColumn[$order_by], $order)
				->where('parent_id', '=', NULL)
				->where(function ($query) use($q) {
					$query->orWhere('email', 'like', '%' . $q . '%')
					->orWhere('username', 'like', '%' . $q . '%')
					->orWhere('id', '=', $q)
					->orWhere('remote_id', '=', $q);
				})
				->count();

			$oData = \User::orderBy($aColumn[$order_by], $order)
				->where('parent_id', '=', NULL)
				->where(function ($query) use($q) {
					$query->orWhere('email', 'like', '%' . $q . '%')
					->orWhere('username', 'like', '%' . $q . '%')
					->orWhere('id', '=', $q)
					->orWhere('remote_id', '=', $q);
				})
				->take($length)->skip($start)->get();
		}
		else
		{
			$count = \User::orderBy($aColumn[$order_by], $order)->where('parent_id', '=', NULL)->count();
			$oData = \User::orderBy($aColumn[$order_by], $order)->where('parent_id', '=', NULL)->take($length)->skip($start)->get();
		}

		if($length == -1) $length = $count;

		$recordsTotal = $count;
		$recordsFiltered = $count;

		foreach($oData as $row)
		{
			$expires = ($row->expires == NULL) ? '-' : $row->expires->format('Y-m-d');
			$last_login = ($row->last_login == NULL) ? '' : $row->last_login->timezone(\Auth::user()->timezone)->format('Y-m-d H:i:s');
			$id = ($row->remote_id == NULL) ? $row->id : $row->remote_id;
			$undeletable = ($row->id == 1) ? 1 : 0;
            $plan = (isset($row->plan->name)) ? $row->plan->name : '';

			$data[] = array(
				'DT_RowId' => 'row_' . $row->id,
				'remote_id' => $id,
				'username' => $row->username,
				'email' => $row->email,
				'roles' => $row->getRolesString(),
				'plan' => $plan,
				'expires' => $expires,
				'logins' => $row->logins,
				'confirmed' => $row->confirmed,
				'last_login' => $last_login,
				'created_at' => $row->created_at->timezone(\Auth::user()->timezone)->format('Y-m-d H:i:s'),
				'sl' => \App\Core\Secure::array2string(array('user_id' => $row->id)),
				'undeletable' => $undeletable
			);
		}

		$response = array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data
		);

		echo json_encode($response);
    }

    /**
     * Save new user
     */
    public function postUserNew()
    {
		$input = array(
			'plan_id' => \Input::get('plan'),
			'expires' => \Input::get('expires', NULL),
			'role_id' => \Input::get('role', 2),
			'username' => \Input::get('username'),
			'email' => \Input::get('email'),
			'password' => \Input::get('password'),
			'language' => \Input::get('language'),
			'timezone' => \Input::get('timezone'),
			'first_name' => \Input::get('first_name'),
			'last_name' => \Input::get('last_name'),
			'confirmed' => \Input::get('confirmed', 0),
			'send_mail' => \Input::get('send_mail', 0)
		);

		$rules = array(
			'username' => 'alpha_dash|required|between:4,20|unique:users,username',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|between:5,20',
			'timezone' => 'required'
		);

        $validator = \Validator::make($input, $rules);

        if($validator->fails())
        {
			$response = array(
				'result' => 'error', 
				'result_msg' => $validator->messages()->first()
			);
        }
        else
        {
            $user = new \User;

            $user->plan_id = $input['plan_id'];
            $user->expires = ($input['expires'] == '') ? NULL : $input['expires'];
            $user->username = $input['username'];
            $user->email = $input['email'];
            $user->password = $input['password'];
            $user->password_confirmation = $input['password'];
            $user->confirmed = $input['confirmed'];
            $user->language = $input['language'];
            $user->timezone = $input['timezone'];
            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];

            if($user->save())
            {
                // Set role
                $user->attachRole($input['role_id']);

                // Send mail with login information
                $name = ($user->first_name != '' || $user->last_name != '') ? $user->first_name . ' ' . $user->last_name : $user->username;

                if($input['send_mail'] == 1)
                {
                    $data = array(
                        'username' => $input['username'],
                        'name' => $name,
                        'email' => $input['email'],
                        'password' => $input['password']
                    );

                    // Change language to user's language for mail
                    $language = \App::getLocale();
                    \App::setLocale($input['language']);

                    \Mail::send('emails.auth.accountcreated', $data, function($message) use($data)
                    {
                        $message->to($data['email'], $data['name'])->subject(trans('confide.email.account_created.subject'));
                    });

                    // ... And change language back
                    \App::setLocale($language);
                }

                $username = $name . ' [' . $user->email . ']';

				// Log
				// \App\Controller\LogController::Log(\Auth::user(), 'Owner', 'created new account - ' . $username . '');

                $response = array(
                    'result' => 'success', 
                    'result_msg' => trans('global.new_user_created')
                );
            }
            else
            {
                $response = array(
                    'result' => 'error', 
                    'result_msg' => $user->errors()->first()
                );
            }
        }
		return \Response::json($response);
    }

    /**
     * Update existing user
     */
    public function postUserUpdate()
    {
		$sl = \Input::get('sl');
		$qs = \App\Core\Secure::string2array($sl);

        if(! is_numeric($qs['user_id'])) return 'Encryption Error.';

		$input = array(
			'plan_id' => \Input::get('plan'),
			'expires' => \Input::get('expires', NULL),
			'role_id' => \Input::get('role', 3),
			'username' => \Input::get('username'),
			'email' => \Input::get('email'),
			'password' => \Input::get('password'),
			'language' => \Input::get('language'),
			'timezone' => \Input::get('timezone'),
			'first_name' => \Input::get('first_name'),
			'last_name' => \Input::get('last_name'),
			'confirmed' => \Input::get('confirmed', 1),
			'send_mail' => \Input::get('send_mail', 0)
		);

		$rules = array(
			'email' => 'required|email|unique:users,email,' . $qs['user_id'],
			'password' => 'between:5,20',
			'timezone' => 'required',
			'username' => 'alpha_dash|required|between:3,20|unique:users,username,' . $qs['user_id'],
		);

        $validator = \Validator::make($input, $rules);

        if($validator->fails())
        {
			$response = array(
				'result' => 'error', 
				'result_msg' => $validator->messages()->first()
			);
        }
        else
        {
            $user = \User::find($qs['user_id']);

            $user->plan_id = $input['plan_id'];
            $user->expires = ($input['expires'] == '') ? NULL : $input['expires'];
            $user->username = $input['username'];
            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];
            $user->email = $input['email'];
            $user->timezone = $input['timezone'];
            $user->language = $input['language'];
            if($qs['user_id'] > 1) $user->confirmed = $input['confirmed'];

            if($input['password'] != '')
            {
                $user->password_confirmation = $input['password'];
                $user->password = $input['password'];
            }

			// Update role (if not superadmin), first detach existing
            if($qs['user_id'] > 1)
            {
                $user->roles()->detach();
                $user->attachRole($input['role_id']);
            }

            if($user->save())
            {
                $response = array(
                    'result' => 'success', 
                    'result_msg' => trans('global.changes_saved')
                );

                // Send mail with login information
                $name = ($user->first_name != '' || $user->last_name != '') ? $user->first_name . ' ' . $user->last_name : $user->username;

                if($input['send_mail'] == 1)
                {
                    $data = array(
                        'username' => $input['username'],
                        'name' => $name,
                        'email' => $input['email'],
                        'password' => $input['password']
                    );

                    // Change language to user's language for mail
                    $language = \App::getLocale();
                    \App::setLocale($input['language']);

                    \Mail::send('emails.auth.accountcreated', $data, function($message) use($data)
                    {
                        $message->to($data['email'], $data['name'])->subject(trans('confide.email.account_created.subject'));
                    });

                    // ... And change language back
                    \App::setLocale($language);
                }

                //$username = ($user->first_name != '' || $user->last_name != '') ? $user->first_name . ' ' . $user->last_name : $user->username;
                //$username = $username . ' [' . $user->email . ']';

				// Log
				// \App\Controller\LogController::Log(Auth::user(), 'Owner', 'updated account ' . $username);
            }
            else
            {
                $response = array(
                    'result' => 'error', 
                    'result_msg' => $user->errors()->first()
                );
            }
        }
		return \Response::json($response);
    }
}