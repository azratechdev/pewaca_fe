<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('provider')->default('qris_mock');
            $table->string('event_id')->unique();
            $table->json('payload');
            $table->timestamp('received_at');
            $table->timestamp('processed_at')->nullable();
            $table->enum('status', ['OK', 'ERROR', 'PENDING'])->default('PENDING');
            $table->text('error_message')->nullable();
            
            $table->index(['provider', 'received_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_events');
    }
};
