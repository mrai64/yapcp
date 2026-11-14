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
        Schema::table('contest_waitings', function (Blueprint $table) {
            // rename fields
            $table->renameColumn('organization_user_id', 'locked_by_user_id');
            $table->renameIndex('organization_idx', 'locker_user_idx');
            //
            $table->renameColumn('because', 'locked_because');
            // added fields
            // from
            $table->char('resolved_by_user_id', 36)
                ->nullable()
                ->after('locked_because')
                ->charset('ascii')->collation('ascii_general_ci')
                ->index('resolver_user__idx')
                ->comment('fk: user_works.id organization member');
            // waiting because
            $table->text('resolved_because')
                ->nullable()
                ->after('resolved_by_user_id')
                ->comment('why that work is in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_waitings', function (Blueprint $table) {
            // 1. Rimuovi l'indice e le colonne aggiunte
            $table->dropIndex('resolver_user__idx');
            $table->dropColumn(['resolved_by_user_id', 'resolved_because']);

            // 2. Riporta i campi ai nomi originali
            $table->renameColumn('locked_by_user_id', 'organization_user_id');
            $table->renameColumn('locked_because', 'because');

            // 3. Riporta l'indice al nome originale
            $table->renameIndex('locker_user_idx', 'organization_idx');
        });
    }
};
