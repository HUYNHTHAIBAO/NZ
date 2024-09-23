<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertCategoryTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_category_tag_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('expert_category_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            $table->foreign('expert_category_id')->references('id')->on('lck_expert_category')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('lck_expert_category_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expert_category_tag_pivot');
    }
}
