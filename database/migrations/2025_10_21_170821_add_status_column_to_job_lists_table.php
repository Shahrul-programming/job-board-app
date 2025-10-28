<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_lists', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'inactive', 'expired'])->default('pending')->after('description');
            $table->string('payment_intent_id')->nullable()->after('status');
            $table->timestamp('activated_at')->nullable()->after('payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_lists', function (Blueprint $table) {
            $table->dropColumn(['status', 'payment_intent_id', 'activated_at']);
        });
    }
};
