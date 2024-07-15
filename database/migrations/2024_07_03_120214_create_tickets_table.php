<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Usuario que crea el ticket
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Usuario asignado al ticket
            $table->string('subject');
            $table->string('description');
            $table->string('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
