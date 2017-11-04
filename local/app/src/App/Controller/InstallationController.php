<?php
namespace App\Controller;

/*
|--------------------------------------------------------------------------
| Installation controller
|--------------------------------------------------------------------------
|
| Installation related logic
|
*/

class InstallationController extends \BaseController {

    /**
	 * Construct
     */
    public function __construct()
    {
    }

    /**
     * Check installation
     */
    public static function check()
    {
        /**
         * Database checks
         */

        \App::error(function(\PDOException $exception)
        {
			if($exception->getCode() == 1044 || $exception->getCode() == '3D000')
			{
				$title = 'OOPS!';
				$subtitle = 'Database error';
	            $msg = 'Error connecting to database, please check <code>/local/app/config/' . \App::environment() . '/database.php</code>';
				$msg .= '<br><br>For more information about the installation, visit <a href="http://madewithpepper.com/mobile-site-builder/manual">http://madewithpepper.com/mobile-site-builder/manual</a>';
				$error = $exception->getMessage();

				return \Response::view('app.errors.general', compact('title', 'subtitle', 'msg', 'error'));
			}
            elseif($exception->getCode() == 23000)
            {
                $PDOException = $exception->getCode();
                return $exception->getCode();
            }
			else
			{
				echo $exception->getMessage();
			}
            die();
        });

        if(! \Schema::hasTable('users'))
        {
            // Database exists, no tables found
            InstallationController::migrate();
        }

        /**
         * Directory permissions
         */
        $dirs = array(
            '/app/storage/cache/',
            '/app/storage/logs/',
            '/app/storage/meta/',
            '/app/storage/meta/services.json',
            '/app/storage/sessions/',
            '/app/storage/userdata/',
            '/app/storage/views/',
            '/../uploads/',
            '/../uploads/attachments/',
            '/../uploads/user/',
            '/../uploads/screens/',
            '/../stock/.tmb/',
            '/../stock/.quarantine/',
            '/../static/app-backgrounds/thumbs/'
        );

        $error = '';

        foreach($dirs as $dir)
        {
            $full_dir = base_path() . $dir;
            if(! \File::isWritable($full_dir))
            {
                if(strpos($full_dir, '../') !== false) $full_dir = str_replace('local/../', '', $full_dir);
                $error .= '' . $full_dir . ' is not writeable.<br>';
            }
        }

        if($error != '')
        {
            $title = 'OOPS!';
            $subtitle = 'Need permission';
            $msg = 'The files and / or directories below need write permission.';
            $msg .= '<br><br>For more information about the installation, visit <a href="http://madewithpepper.com/mobile-site-builder/manual">http://madewithpepper.com/mobile-site-builder/manual</a>';

            echo \View::make('app.errors.general', compact('title', 'subtitle', 'msg', 'error'));
            die();
        }
    }

    /**
     * Install database and seed
     */
    public static function migrate()
    {
		//set_time_limit(0);

        \Artisan::call('migrate', ['--path' => "app/database/migrations", '--force' => true]);
        \Artisan::call('db:seed', ['--force' => true]);
    }

    /**
     * Remove all tables
     */
    public static function clean()
    {
        /**
         * Empty all user directories
         */
		$gitignore = '*
!.gitignore';

        $dirs = array(
            '/app/storage/cache/',
            '/app/storage/logs/',
            '/app/storage/sessions/',
            '/app/storage/userdata/',
            '/app/storage/views/',
            '/../uploads/attachments/',
            '/../uploads/user/',
            '/../uploads/screens/'
        );

        foreach($dirs as $dir)
        {
            $full_dir = base_path() . $dir;
			$success = \File::deleteDirectory($full_dir, true);
			if($success)
			{
				// Deploy .gitignore
				\File::put($full_dir . '.gitignore', $gitignore);
			}
		}

        /**
         * Clear cache
         */
		\Artisan::call('cache:clear');

        /**
         * Drop all tables in database
         */
		$tables = [];
 
		\DB::statement('SET FOREIGN_KEY_CHECKS=0');
 
		foreach(\DB::select('SHOW TABLES') as $k => $v)
		{
			$tables[] = array_values((array)$v)[0];
		}
 
		foreach($tables as $table)
		{
			\Schema::drop($table);
		}
	}

	public function reset($key)
	{
		if($key == \Config::get('app.key'))
		{
			$demo_path = base_path() . '/../../demo';
			if(\File::isDirectory($demo_path))
			{
				// Clean cache, database and files
				\App\Controller\InstallationController::clean();

				// Database tables
				\App\Controller\InstallationController::migrate();

				// Uploads
				$user_files_src = $demo_path . '/user/R4/';
				$user_files_tgt = base_path() . '/../uploads/user/' . \App\Core\Secure::staticHash(1) . '/';

				\File::copyDirectory($user_files_src, $user_files_tgt);

				// Template
				$user_files_src = $demo_path . '/templates/';
				$user_files_tgt = base_path() . '/../local/app/storage/userdata/';

				\File::copyDirectory($user_files_src, $user_files_tgt);

				// Seed demo data
				$seed_sql = $demo_path . '/demo-seeds.sql';
				\DB::unprepared(\File::get($seed_sql));
			}
		}
	}
}