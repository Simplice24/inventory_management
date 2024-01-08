<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionMatReqConfirmationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('production_mat_req_confirmations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('prod_mat_req_id');
      $table->unsignedBigInteger('user_id');
      $table->string('status')->default(0)->comment('0=pending, 1=confirmed, 2=cancelled');
      $table->timestamp('confirmed_at')->nullable();

      $table->foreign('prod_mat_req_id')->references('id')->on('production_material_requests')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('production_mat_req_confirmations');
  }
}
