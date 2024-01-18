<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seo_metas', function (Blueprint $table) {
            $table
                ->foreign('seo_setting_id')
                ->references('id')
                ->on('seo_settings')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_metas', function (Blueprint $table) {
            $table->dropForeign(['seo_setting_id']);
        });
    }
};
