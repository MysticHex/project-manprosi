<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'cancelled' to the enum list for orders.status
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('pending','paid','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('pending','paid','processing','shipped','delivered') NOT NULL DEFAULT 'pending';");
    }
};
