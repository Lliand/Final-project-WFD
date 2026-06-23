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
        Schema::create('pokemon_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('set_id')->constrained('card_sets')->onDelete('restrict');
            $table->string('card_name');
            $table->string('card_type');
            $table->string('element_type')->nullable();
            $table->string('raw_image_url');
            $table->string('graded_image_url')->nullable();
            $table->integer('hall_of_fame_slot')->nullable();
            $table->enum('status', ['Raw_Pending', 'In_Grading', 'Graded_Inventory', 'Rejected'])->default('Raw_Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_cards');
    }
};
