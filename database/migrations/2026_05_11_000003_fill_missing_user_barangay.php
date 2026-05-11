<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereNull('barangay')
            ->orWhere('barangay', '')
            ->update(['barangay' => User::DEFAULT_BARANGAY]);

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY barangay VARCHAR(255) NOT NULL DEFAULT '" . User::DEFAULT_BARANGAY . "'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN barangay SET DEFAULT '" . User::DEFAULT_BARANGAY . "'");
            DB::statement("ALTER TABLE users ALTER COLUMN barangay SET NOT NULL");
        } elseif ($driver === 'sqlite') {
            // SQLite does not support altering column nullability easily in a migration.
            // Existing rows are fixed above, and application-level validation will enforce non-empty barangay.
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY barangay VARCHAR(255) NULL DEFAULT NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN barangay DROP DEFAULT");
            DB::statement("ALTER TABLE users ALTER COLUMN barangay DROP NOT NULL");
        } elseif ($driver === 'sqlite') {
            // SQLite schema rollback for this change is not supported in this migration.
        }
    }
};
