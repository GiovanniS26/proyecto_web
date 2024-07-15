<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Proyecto al que pertenece la tarea
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario asignado a la tarea
            $table->string('title');
            $table->text('description');
            $table->string('status');
            $table->date('due_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
