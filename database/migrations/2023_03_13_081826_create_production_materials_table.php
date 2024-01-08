<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionMaterialsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('production_materials', function (Blueprint $table) {
      $table->id();
      $table->string('material_name');
      $table->unsignedBigInteger('raw_material_id');
      $table->unsignedTinyInteger('pac_size')->comment('1 => 1 ltr, 2 => 2 ltr, 5 => 5 ltr, etc.');
      $table->unsignedMediumInteger('material_quantity')->default(0)->comment('quantity in piece');
      $table->string('req_handler_role');
      $table->timestamps();

      $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('production_materials');
  }
}
