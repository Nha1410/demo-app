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
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('image_type', 'imageable_type');
            $table->renameColumn('image_link_id', 'imageable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('image_link_type', 'image_type');
            $table->renameColumn('imageable_id', 'image_link_id');
        });
    }
};
