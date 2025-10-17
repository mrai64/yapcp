<?php
/**
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
        Schema::table('user_contacts', function (Blueprint $table) {
            $table->dropUnique(['user_id']); // drop index pcp_user_contacts_user_id_unique
            $table->unique(['user_id', 'deleted_at'], 'user_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contacts', function (Blueprint $table) {
            //
        });
    }
};
