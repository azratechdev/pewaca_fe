<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('payment_id');
            $table->enum('event', ['CREATED', 'WEBHOOK_SUCCESS', 'RETRY', 'EXPIRE', 'RECONCILE', 'ERROR']);
            $table->json('payload')->nullable();
            $table->timestamp('created_at');
            
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->index(['payment_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_logs');
    }
};
