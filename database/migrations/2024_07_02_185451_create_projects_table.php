<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Usuario que crea el proyecto
            $table->string('title');
            $table->string('description');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
