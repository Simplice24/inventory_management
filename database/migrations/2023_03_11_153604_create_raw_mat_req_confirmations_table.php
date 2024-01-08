<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMatReqConfirmationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('raw_mat_req_confirmations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('raw_material_request_id');
      $table->unsignedBigInteger('user_id');
      $table->string('status')->default(0)->comment('0=>pending, 1=>confirmed, 3=cancelled');
      $table->timestamp('confirmed_at')->nullable();

      $table->foreign('raw_material_request_id')->references('id')->on('raw_material_requests')->onDelete('cascade');
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
    Schema::dropIfExists('raw_mat_req_confirmations');
  }
}
