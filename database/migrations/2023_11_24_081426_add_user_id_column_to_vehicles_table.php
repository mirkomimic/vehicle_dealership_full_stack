<?php

use App\Models\User;
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
    Schema::table('vehicles', function (Blueprint $table) {
      $table->foreignIdFor(User::class);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('vehicles', function (Blueprint $table) {
      $table->dropColumn('user_id');
    });
  }
};
