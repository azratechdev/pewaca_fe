<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('IDR');
            $table->enum('status', ['CREATED', 'PENDING', 'PAID', 'EXPIRED', 'FAILED', 'REFUNDED'])->default('CREATED');
            $table->text('qris_payload')->nullable();
            $table->string('provider_trx_id')->nullable()->index();
            $table->string('provider_ref_no')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('callback_url')->nullable();
            $table->json('metadata')->nullable();
            $table->smallInteger('signature_version')->default(1);
            $table->string('idempotency_key')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
