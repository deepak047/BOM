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
        Schema::create('bom_line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_header_id')->constrained('bom_headers')->onDelete('cascade');
            $table->string('item_code');
            $table->string('description')->nullable();
            $table->string('uom')->default('EA');
            $table->integer('required_qty');
            $table->string('specification')->nullable();
            $table->string('allocated_to')->nullable(); // Dept / Role
            $table->enum('status', ['in_stock', 'partial_stock', 'out_of_stock'])->default('out_of_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_line_items');
    }
};
