<?php

/**
 * 2025-10-18 Build index unique on email but mysql don't know/look at softdelete.
 * So, even for backup purpose, instead of reopen closed record
 * enlarge unique index to deleted_at col.
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
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->unique(['email', 'deleted_at']);
            //
            $table->dropIndex(['name']);
            $table->index(['country_id', 'name', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            //
        });
    }
};
