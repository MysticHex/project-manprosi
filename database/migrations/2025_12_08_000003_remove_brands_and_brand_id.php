<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop FK and column from products, then drop brands table
        try {
            DB::statement('ALTER TABLE products DROP FOREIGN KEY products_brand_id_foreign');
        } catch (\Throwable $e) {
            // ignore if FK doesn't exist
        }

        try {
            DB::statement('ALTER TABLE products DROP COLUMN brand_id');
        } catch (\Throwable $e) {
            // ignore if column doesn't exist
        }

        try {
            DB::statement('DROP TABLE IF EXISTS brands');
        } catch (\Throwable $e) {
            // ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // recreate brands table and brand_id column
        DB::statement('CREATE TABLE IF NOT EXISTS brands (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at TIMESTAMP NULL DEFAULT NULL, updated_at TIMESTAMP NULL DEFAULT NULL) ENGINE=InnoDB');

        try {
            DB::statement('ALTER TABLE products ADD COLUMN brand_id BIGINT UNSIGNED NULL AFTER category_id');
            DB::statement('ALTER TABLE products ADD CONSTRAINT products_brand_id_foreign FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL');
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
