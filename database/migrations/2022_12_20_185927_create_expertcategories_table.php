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
        Schema::create('expertcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id')->constrained('categories');
            $table->foreignId('experts_id')->constrained('experts');
            $table->string('experiance');
            $table->string('experiance_details');
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
        Schema::dropIfExists('expertcategories');
    }
};
