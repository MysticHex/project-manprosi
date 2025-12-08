<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing foreign key, make column nullable, then recreate FK with ON DELETE SET NULL
        // Raw SQL used to avoid requiring doctrine/dbal for column modification.
        $tableName = 'products';
        $fkName = 'products_user_id_foreign';

        // Drop foreign key if exists
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        try {
            DB::statement("ALTER TABLE `{$tableName}` DROP FOREIGN KEY `{$fkName}`;");
        } catch (\Throwable $e) {
            // ignore if constraint doesn't exist
        }

        // Modify column to be nullable
        DB::statement("ALTER TABLE `{$tableName}` MODIFY `user_id` BIGINT UNSIGNED NULL;");

        // Recreate foreign key with ON DELETE SET NULL
        DB::statement("ALTER TABLE `{$tableName}` ADD CONSTRAINT `{$fkName}` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;");
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'products';
        $fkName = 'products_user_id_foreign';

        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        try {
            DB::statement("ALTER TABLE `{$tableName}` DROP FOREIGN KEY `{$fkName}`;");
        } catch (\Throwable $e) {
            // ignore
        }

        // Make column NOT NULL again (default to 1 - may fail if nulls exist)
        DB::statement("ALTER TABLE `{$tableName}` MODIFY `user_id` BIGINT UNSIGNED NOT NULL;");

        // Recreate FK with ON DELETE CASCADE (original behavior)
        DB::statement("ALTER TABLE `{$tableName}` ADD CONSTRAINT `{$fkName}` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE;");
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }
};
