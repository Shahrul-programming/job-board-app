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
        Schema::table('job_applications', function (Blueprint $table) {
            // Add status column for application status tracking
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])
                ->default('pending')
                ->after('willing_to_relocate');

            // Add user_id column (nullable first to handle existing data)
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Update existing records to have a default user_id if any exist
        // We'll use the first admin user as default, or create one if none exists
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (! $adminUser) {
            $adminUser = \App\Models\User::create([
                'name' => 'System Admin',
                'email' => 'system@demo.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Update all existing job applications to have this user_id
        \DB::table('job_applications')->whereNull('user_id')->update(['user_id' => $adminUser->id]);

        // Now make user_id not nullable and add foreign key constraint
        Schema::table('job_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};
