<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->string('provider_trx_id')->index();
            $table->uuid('payment_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->date('settlement_date');
            $table->string('file_id')->nullable();
            $table->boolean('reconciled')->default(false);
            $table->timestamp('created_at');
            
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->index(['settlement_date', 'reconciled']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};
