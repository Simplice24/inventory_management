<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('raw_materials', function (Blueprint $table) {
      $table->id();
      $table->string('material_name');
      $table->string('material_type');
      $table->unsignedDecimal('material_quantity', 10, 2);
      $table->string('quantity_unit');
      $table->string('req_handler_role');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('raw_materials');
  }
}
