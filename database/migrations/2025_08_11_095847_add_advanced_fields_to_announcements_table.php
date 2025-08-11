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
        Schema::table('announcements', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->after('slug');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('published_at');
            $table->string('category')->nullable()->after('priority');
            $table->boolean('is_featured')->default(false)->after('category');
            $table->boolean('send_notification')->default(true)->after('is_featured');
            $table->json('tags')->nullable()->after('send_notification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'published_at',
                'priority',
                'category',
                'is_featured',
                'send_notification',
                'tags'
            ]);
        });
    }
};
