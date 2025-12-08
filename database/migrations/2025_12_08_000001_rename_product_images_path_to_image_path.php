<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * We'll avoid requiring the DBAL by using raw SQL: add new column, copy data, drop old column.
     *
     * @return void
     */
    public function up()
    {
        // Add new column
        DB::statement("ALTER TABLE product_images ADD COLUMN image_path VARCHAR(255) NULL AFTER path");

        // Copy values from path to image_path
        DB::statement('UPDATE product_images SET image_path = path');

        // Drop the old column
        DB::statement('ALTER TABLE product_images DROP COLUMN path');
    }

    /**
     * Reverse the migrations.
     * Recreate `path`, copy back, drop `image_path`.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE product_images ADD COLUMN path VARCHAR(255) NULL AFTER image_path");
        DB::statement('UPDATE product_images SET path = image_path');
        DB::statement('ALTER TABLE product_images DROP COLUMN image_path');
    }
};
