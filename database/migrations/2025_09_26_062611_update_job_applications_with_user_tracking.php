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
        // First, check if columns already exist and add them if they don't
        if (! Schema::hasColumn('job_applications', 'user_id')) {
            Schema::table('job_applications', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('job_applications', 'status')) {
            Schema::table('job_applications', function (Blueprint $table) {
                $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])
                    ->default('pending')
                    ->after('willing_to_relocate');
            });
        }

        // Update existing records to have a valid user_id
        $existingApplications = \DB::table('job_applications')->whereNull('user_id')->count();

        if ($existingApplications > 0) {
            // Get the first admin user (we know one exists)
            $adminUser = \App\Models\User::where('role', 'admin')->first();

            // If no admin, get any user, otherwise create one
            if (! $adminUser) {
                $adminUser = \App\Models\User::first();
            }

            if (! $adminUser) {
                $adminUser = \App\Models\User::create([
                    'name' => 'System Admin',
                    'email' => 'system@demo.com',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                ]);
            }

            // Update all existing job applications to have this user_id
            \DB::table('job_applications')
                ->whereNull('user_id')
                ->update(['user_id' => $adminUser->id]);
        }

        // Verify all records have valid user_id before adding constraint
        $invalidRecords = \DB::table('job_applications')
            ->leftJoin('users', 'job_applications.user_id', '=', 'users.id')
            ->whereNull('users.id')
            ->orWhereNull('job_applications.user_id')
            ->count();

        if ($invalidRecords > 0) {
            // Clean up any invalid records by assigning to first available user
            $firstUser = \App\Models\User::first();
            \DB::table('job_applications')
                ->whereNull('user_id')
                ->orWhereNotIn('user_id', \App\Models\User::pluck('id'))
                ->update(['user_id' => $firstUser->id]);
        }

        // Now make user_id required and add foreign key constraint
        Schema::table('job_applications', function (Blueprint $table) {
            // Check if foreign key doesn't already exist
            try {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            } catch (\Exception $e) {
                // Log the error but don't fail the migration if constraint already exists
                \Log::info('Foreign key constraint may already exist: '.$e->getMessage());
            }
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
