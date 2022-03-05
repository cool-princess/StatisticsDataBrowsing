<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('password')->nullable();
            $table->string('company_name')->nullable();
            $table->string('furi_company_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('name');
            $table->string('furi_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('address4')->nullable();
            $table->string('sectors')->nullable();
            $table->string('break');
            $table->integer('login_count')->default(0);
            $table->string('pwd_store');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
