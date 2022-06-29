<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaptopSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptop_salary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laptop_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('salary_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('projet_id')->constrained();
            $table->date('affected_at');
            $table->string('remarque')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::drop('laptop_salary');
    }
}
