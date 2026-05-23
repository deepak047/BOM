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
        Schema::create('material_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('bom_reference');
            $table->string('item_code');
            $table->string('description');
            $table->integer('allocated_qty');
            $table->string('allocated_to');      // Dept / Role / Person
            $table->string('allocated_by')->default('system:auto');
            $table->foreignId('bom_header_id')->nullable()->constrained('bom_headers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_allocations');
    }
};
