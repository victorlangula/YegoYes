<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConfideSetupUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
		// Plans
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sort')->default(0);
			$table->string('name', 100);
			$table->boolean('hidden')->default(false);
			$table->text('settings')->nullable();
		});

        // Creates the users table
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
			$table->bigInteger('remote_id')->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('plan_id')->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->string('username', 32);
            $table->string('email', 64);
            $table->string('password', 64);
            $table->string('confirmation_code', 128);
            $table->string('remember_token', 128)->nullable();
            $table->boolean('confirmed')->default(false);

            $table->string('first_name', 32)->nullable();
            $table->string('last_name', 32)->nullable();
            $table->string('website')->nullable();
            $table->string('twitter', 128)->nullable();
            $table->string('facebook', 128)->nullable();

			$table->string('provider', 128)->nullable();
			$table->string('theme', 16)->nullable();
			$table->string('language', 5)->default('en');
			$table->string('timezone', 32)->default('UTC');
			$table->integer('logins')->default(0)->unsigned();
			$table->dateTime('last_login')->nullable();
			$table->text('settings')->nullable();
			$table->dateTime('expires')->nullable();
			$table->smallInteger('expire_notifications')->default(0)->unsigned();

			$table->string('avatar_file_name')->nullable();
			$table->integer('avatar_file_size')->nullable();
			$table->string('avatar_content_type')->nullable();
			$table->timestamp('avatar_updated_at')->nullable();

            $table->timestamps();
			$table->softDeletes();
        });

        // Creates password reminders table
        Schema::create('password_reminders', function(Blueprint  $table)
        {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::drop('users');
		Schema::drop('plans');
    }

}
