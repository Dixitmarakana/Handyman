<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPostJobRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_job_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('date')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            
            $table->unsignedBigInteger('state_id')->after('country_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            
            $table->unsignedBigInteger('city_id')->after('state_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');


            $table->unsignedBigInteger('category_id')->after('city_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('subcategory_id')->after('category_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_job_requests', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            $table->dropForeign(['subcategory_id']);
            $table->dropColumn('subcategory_id');
        });
    }
}
