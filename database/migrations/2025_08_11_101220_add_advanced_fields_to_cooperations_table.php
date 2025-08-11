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
        Schema::table('cooperations', function (Blueprint $table) {
            $table->string('partner_name')->nullable()->after('url');
            $table->enum('cooperation_type', ['academic', 'research', 'industry', 'government', 'international', 'ngo'])->nullable()->after('partner_name');
            $table->enum('status', ['active', 'pending', 'expired', 'suspended'])->default('active')->after('cooperation_type');
            $table->date('start_date')->nullable()->after('status');
            $table->date('end_date')->nullable()->after('start_date');
            $table->text('description')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cooperations', function (Blueprint $table) {
            $table->dropColumn([
                'partner_name',
                'cooperation_type',
                'status',
                'start_date',
                'end_date',
                'description'
            ]);
        });
    }
};
