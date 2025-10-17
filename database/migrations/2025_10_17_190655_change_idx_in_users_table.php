<?php
/**
 * 
 * 2025-10-17 
 * Mysql don't regard about softDeletes record, so
 * when i need delete and reinsert a user_id, 
 * should pick a "duplicate" even if no record was show
 * (but exists, deleted_at not NULL)
 * 
 */

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']); // drop index pcp_users_email_unique
            $table->unique(['email', 'deleted_at']); // pcp_users_email_deleted_at_unique
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
