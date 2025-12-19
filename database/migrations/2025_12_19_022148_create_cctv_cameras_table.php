<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cctv_cameras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('residence_id');
            $table->string('camera_name', 255);
            $table->string('location_name', 255);
            $table->string('location_group', 100);
            $table->text('stream_url');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('residence_id');
            $table->index('location_group');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cctv_cameras');
    }
};
