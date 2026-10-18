<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 120);
            $table->string('customer_phone', 30);
            $table->string('motorcycle', 120);
            $table->string('license_plate', 20);
            $table->text('complaint');
            $table->text('service_action')->nullable();
            $table->string('mechanic', 120)->nullable();
            $table->unsignedInteger('cost')->default(0);
            $table->string('status', 20)->default('Menunggu');
            $table->date('received_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
