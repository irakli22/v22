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
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->decimal('screen_size', 5, 2)->nullable();
            $table->integer('storage_capacity')->nullable();
            $table->string('camera_resolution')->nullable();
            $table->integer('battery_capacity')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('processor')->nullable(); // Processor type and model
            $table->integer('ram')->nullable(); // RAM capacity in GB
            $table->string('display_type')->nullable(); // Type of display (LCD, OLED, etc.)
            $table->integer('refresh_rate')->nullable(); // Screen refresh rate
            $table->string('body_material')->nullable(); // Material of the phone body
            $table->boolean('water_resistant')->nullable(); // Water resistance
            $table->boolean('wireless_charging')->nullable(); // Support for wireless charging
            $table->boolean('fast_charging')->nullable(); // Support for fast charging
            $table->string('front_camera_resolution')->nullable(); // Front camera resolution
            $table->string('connectivity')->nullable(); // Connectivity options (e.g., 5G, LTE, Wi-Fi)
            $table->string('sim_type')->nullable(); // Type of SIM supported
            $table->boolean('fingerprint_sensor')->nullable(); // Fingerprint sensor availability
            $table->boolean('face_recognition')->nullable(); // Face recognition feature
            $table->decimal('weight', 5, 2)->nullable(); // Weight in grams
            $table->string('dimensions')->nullable(); // Dimensions of the phone
            $table->string('audio_jack')->nullable(); // Audio jack type
            $table->string('bluetooth_version')->nullable(); // Bluetooth version
            $table->string('nfc')->nullable(); // NFC support
            $table->string('gps')->nullable(); // GPS support
            $table->string('usb_type')->nullable(); // USB type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
