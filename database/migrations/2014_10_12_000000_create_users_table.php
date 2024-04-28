<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birthday');
            $table->string('passport');
            $table->string('photo');
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('parents_passport');
            $table->string('parents_number1');
            $table->string('parents_number2');
            $table->integer('region_id');
            $table->integer('district_id');
            $table->integer('quarter_id');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
