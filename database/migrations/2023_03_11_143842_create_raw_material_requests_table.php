<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_material_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raw_material_id');
            $table->unsignedBigInteger('raw_material_quantity');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamps();

            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
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
        Schema::dropIfExists('raw_material_requests');
    }
}
