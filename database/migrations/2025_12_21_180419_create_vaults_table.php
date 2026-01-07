<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vaults', function (Blueprint $table) {
            $table->id();
            $table->string('vault_identifier')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('capacity', 10, 2)->default(100.00); // 100kg default
            $table->string('status')->default('available'); // available, assigned, maintenance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaults');
    }
};
