<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('passenger_id');
            $table->uuid('driver_id')->nullable();

            $table->decimal('origin_lat', 10, 7);
            $table->decimal('origin_lng', 11, 7);
            $table->decimal('dest_lat', 10, 7);
            $table->decimal('dest_lng', 11, 7);

            $table->string('status');
            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('passenger_id');
            $table->index('driver_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
