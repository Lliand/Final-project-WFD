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
        Schema::create('grading_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('grader_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->foreignId('card_id')->unique()->constrained('pokemon_cards')->onDelete('cascade');
            
            $table->foreignId('package_id')->constrained('grading_packages')->onDelete('restrict');
            
            $table->text('pickup_address');
            $table->text('return_address');
            $table->bigInteger('total_fee');
            
            $table->integer('centering_score')->nullable();
            $table->integer('corners_score')->nullable();
            $table->integer('edges_score')->nullable();
            $table->integer('surface_score')->nullable();
            $table->integer('final_grade')->nullable();
            
            $table->enum('logistics_status', ['Waiting_For_Pickup', 'Picked_Up_Unconfirmed', 'In_Lab', 'Grading_Done', 'Returned_Unconfirmed', 'Completed'])->default('Waiting_For_Pickup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_requests');
    }
};
