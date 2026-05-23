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
        Schema::create('purchase_intents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_header_id')->constrained('bom_headers')->onDelete('cascade');
            $table->string('bom_reference');
            $table->string('item_code');
            $table->string('description');
            $table->string('specification')->nullable();
            $table->integer('required_qty');
            $table->integer('available_qty');
            $table->integer('shortfall_qty');
            $table->string('priority')->default('medium'); // from project / config
            $table->timestamp('date_raised');
            $table->string('status')->default('pending'); // pending, acknowledged, po_raised
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_intents');
    }
};
