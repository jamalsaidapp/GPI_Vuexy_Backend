<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalarieHasRetour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retour_salarie', function (Blueprint $table) {
            $table->foreignId('ordinateur_id')->constrained();
            $table->foreignId('salarie_id')->constrained();
            $table->dateTime('affected_at');
            $table->dateTime('rendu_at');
            $table->string('remarque');
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
        Schema::drop('retour_salarie');
    }
}