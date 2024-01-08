<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionMaterialRequestsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('production_material_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('production_material_id');
      $table->unsignedMediumInteger('production_material_quantity')->comment('quantity in piece');
      $table->unsignedBigInteger('requested_by');
      $table->unsignedBigInteger('cancelled_by')->nullable();
      $table->timestamps();

      $table->foreign('production_material_id')->references('id')->on('production_materials')->onDelete('cascade');
      $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('production_material_requests');
  }
}
