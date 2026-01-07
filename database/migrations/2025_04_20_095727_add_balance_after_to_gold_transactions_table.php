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
        Schema::table('gold_transactions', function (Blueprint $table) {
            $table->integer('balance_after')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gold_transactions')) {
            Schema::table('gold_transactions', function (Blueprint $table) {
                $table->dropColumn('balance_after');
            });
        }
    }
};
