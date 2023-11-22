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
    Schema::table('vehicle_imgs', function (Blueprint $table) {
      $table->boolean('isThumbnail')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('vehicle_imgs', function (Blueprint $table) {
      $table->dropColumn('isThumbnail');
    });
  }
};
