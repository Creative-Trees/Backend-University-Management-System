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
        Schema::create('footers', function (Blueprint $table) {
        $table->id();

        // Logo image URL or file path for footer branding (optional)
        $table->string('logo_image')->nullable()->comment('URL or path to footer logo image');

        // Social media profile URLs (optional)
        $table->string('instagram_url')->nullable()->comment('Official Instagram profile URL');
        $table->string('youtube_url')->nullable()->comment('Official YouTube channel URL');
        $table->string('linkedin_url')->nullable()->comment('Official LinkedIn page URL');
        $table->string('facebook_url')->nullable()->comment('Official Facebook page URL');

        // Contact information (optional)
        $table->string('address')->nullable()->comment('Physical address of the company or organization');
        $table->string('contact_email')->nullable()->comment('Contact email for customer support or inquiries');
        $table->string('whatsapp_number')->nullable()->comment('WhatsApp contact number with country code, digits only');

        // Location map URL (optional)
        $table->string('google_maps_url')->nullable()->comment('Google Maps link for location');

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
