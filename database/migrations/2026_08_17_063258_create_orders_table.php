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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            //User yang memesan jasa
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            //Jasa yang dipesan
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            // Kebutuhan dari pembeli
            $table->text('requirements');

            //deadline pengerjaan
            $table->date('deadline');

            //catatan tambahan
            $table->text('notes')->nullable();

            //status order
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'in_progress',
                'complete',
                'cancelled',
            ])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
