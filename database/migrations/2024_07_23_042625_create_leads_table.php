<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('status_id')->constrained('lead_statuses')->onDelete('cascade');
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->string('country');
            $table->string('city');
            $table->string('phone');
        });
    }
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
