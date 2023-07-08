<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('finished')->default(false);
            $table->unsignedBigInteger('children_id');
            $table->timestamps();
            $table->foreign('children_id')->references('id')->on('childrens')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children_courses');
    }
};
