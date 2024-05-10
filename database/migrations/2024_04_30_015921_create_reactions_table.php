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
        Schema::create('reactions', function (Blueprint $table)
        {
            $table->id();
            $table->enum('type', ['favor', 'oppose']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reactable_id');
            $table->string('reactable_type');
            $table->timestamps();

            $table->unique(['user_id', 'reactable_id', 'reactable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
