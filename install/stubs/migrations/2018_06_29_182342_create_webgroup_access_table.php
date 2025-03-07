<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webgroup_access', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('webgroup')->default(0);
			$table->integer('documentgroup')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('webgroup_access');
	}

};
