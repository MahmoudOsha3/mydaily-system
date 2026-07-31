<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 12, 2);
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->index(['date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
