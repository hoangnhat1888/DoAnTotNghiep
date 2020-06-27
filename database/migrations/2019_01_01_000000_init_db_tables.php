<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitDBTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('genders', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('name', 32);
		});

		Schema::create('positions', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('name', 32);
		});

		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('bts_id', 8)->nullable();
			$table->string('username', 32)->nullable();
			$table->string('password', 64)->nullable();
			$table->rememberToken();
			$table->string('first_name', 32)->nullable();
			$table->string('last_name', 32)->nullable();
			$table->string('image', 128)->nullable();
			$table->string('other_images', 1024)->default('[]');
			$table->string('email', 32)->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('phone_number', 32)->nullable();
			$table->string('address', 128)->nullable();
			$table->unsignedTinyInteger('gender_id')->nullable();
			$table->unsignedTinyInteger('position_id')->nullable();
			$table->timestamp('start_date')->useCurrent();
			$table->timestamp('signing_date')->useCurrent();
			$table->unsignedSmallInteger('signing_term')->nullable();
			$table->timestamp('end_date')->nullable();
			$table->unsignedBigInteger('salary')->default(0);
			$table->text('roles')->default('[]');
			$table->unsignedInteger('created_user_id')->nullable();
			$table->unsignedInteger('updated_user_id')->nullable();
			$table->softDeletes();
			$table->timestamps();

			// $table->foreign('gender_id')->references('id')->on('genders');
			// $table->foreign('position_id')->references('id')->on('positions');
			// $table->foreign('created_user_id')->references('id')->on('users');
			// $table->foreign('updated_user_id')->references('id')->on('users');
		});

		Schema::create('user_banks', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->string('bank_name', 64);
			$table->string('bank_account', 64);
			$table->string('branch', 64);

			// $table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('settings', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('company_name', 32)->nullable();
			$table->string('company_slogan', 64)->nullable();
			$table->string('company_owner', 32)->nullable();
			$table->string('company_website', 32)->nullable();
			$table->string('logo', 128)->nullable();
			$table->string('tax_id', 32)->nullable();
			$table->string('email', 32)->nullable();
			$table->string('phone_number', 32)->nullable();
			$table->string('address', 128)->nullable();
			$table->string('working_hours', 32)->nullable();
			$table->string('location', 32)->nullable();
			$table->unsignedInteger('created_user_id')->nullable();
			$table->unsignedInteger('updated_user_id')->nullable();

			// $table->foreign('created_user_id')->references('id')->on('users');
			// $table->foreign('updated_user_id')->references('id')->on('users');
		});

		Schema::create('time_off_type', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('name', 32);
		});

		Schema::create('approval_type', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('name', 32);
		});

		Schema::create('booking_time_off', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->timestamp('booking_day')->useCurrent();
			$table->unsignedTinyInteger('time_off_type_id')->default(1);
			$table->unsignedTinyInteger('approval_type_id')->nullable();
			$table->unsignedInteger('approved_user_id')->nullable();
			$table->timestamp('approved_time')->nullable();
			$table->string('reason', 50);


			// $table->foreign('time_off_type_id')->references('id')->on('time_off_type');
			// $table->foreign('approval_type_id')->references('id')->on('approval_type');
			// $table->foreign('approved_user_id')->references('id')->on('users');
		});

		Schema::create('templates', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id')->nullable();
			$table->string('name', 32);
			$table->string('link', 128);
			$table->boolean('exported')->default(0);

			// $table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('work_schedules', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->string('kind_of_day', 16);
			$table->string('work_time', 4);

			// $table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('work_statistics', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->string('direction', 4);
			$table->timestamp('interactive_time')->useCurrent();

			// $table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('password_resets', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('username', 32);
			$table->string('reset_token', 64);
			$table->timestamp('created_time')->useCurrent();
		});

		Schema::create('card_mapping', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('card_id');
			$table->unsignedInteger('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('genders');
		Schema::dropIfExists('positions');
		Schema::dropIfExists('users');
		Schema::dropIfExists('user_banks');
		Schema::dropIfExists('settings');
		Schema::dropIfExists('time_off_type');
		Schema::dropIfExists('approval_type');
		Schema::dropIfExists('booking_time_off');
		Schema::dropIfExists('templates');
		Schema::dropIfExists('work_schedules');
		Schema::dropIfExists('work_statistics');
		Schema::dropIfExists('password_resets');
		Schema::dropIfExists('card_mapping');
	}
}