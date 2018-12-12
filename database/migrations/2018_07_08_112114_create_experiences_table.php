<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('job_title', 40);
            $table->integer('joblevel_id')->unsigned();
            $table->foreign('joblevel_id')->references('id')->on('job_levels')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('company', 100);
            $table->integer('jobfunction_id')->unsigned();
            $table->foreign('jobfunction_id')->references('id')->on('job_functions')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('industry_id')->unsigned();
            $table->foreign('industry_id')->references('id')->on('industries')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('salary_id')->unsigned()->nullable();
            $table->foreign('salary_id')->references('id')->on('salaries')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('jobtype_id')->unsigned()->nullable();
            $table->foreign('jobtype_id')->references('id')->on('job_types')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('report_to', 100)->nullable();
            $table->text('job_desc')->nullable();
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
        Schema::dropIfExists('experiences');
    }
}
