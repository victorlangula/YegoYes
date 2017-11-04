<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('campaigns', function($table)
        {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
     		$table->string('name', 32)->nullable();
			$table->dateTime('date_start')->nullable();
			$table->dateTime('date_end')->nullable();
			$table->string('language', 5)->nullable();
			$table->string('timezone', 32)->nullable();
			$table->boolean('active')->default(true);
			$table->text('settings')->nullable();
            $table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('campaigns', function(Blueprint $table) {
            $table->dropForeign('campaigns_user_id_foreign');
        });
    	Schema::drop('campaigns');
	}

}
