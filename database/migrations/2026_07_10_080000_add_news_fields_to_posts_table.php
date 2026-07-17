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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('content');
            $table->string('publisher')->nullable()->after('image_url');
            $table->date('event_date')->nullable()->after('publisher');
            $table->string('source_url')->nullable()->after('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'publisher', 'event_date', 'source_url']);
        });
    }
};
