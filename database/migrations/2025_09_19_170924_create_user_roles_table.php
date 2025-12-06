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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id(); // bigint ok
            $table->ForeignUuid('user_id')->index()
                ->comment('fk: users.id');
            $table->string('role');
            //
            $table->foreignUuid('organization_id')->nullable()->index()
                ->comment('fk: organizations.id');
            $table->foreignUuid('contest_id')->nullable()->index()
                ->comment('fk: contests.id');
            $table->foreignUuid('federation_id')->nullable()->index()
                ->comment('fk: federations.id');
            //
            $table->dateTime('role_opening')->useCurrent()->index()
                ->comment('Start of role works - default today');
            $table->dateTime('role_closing')->default('9999-12-31 23:59:59')
                ->comment('End of role works default:future');
            //
            // backup and softdelete - don't need Tz anymore
            $table->dateTime('created_at')->useCurrent()
                ->comment('backup reserved');
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()
                ->comment('backup reserved');
            $table->dateTime('deleted_at')->nullable()
                ->comment('softdelete reserved');
            //
            $table->index(['user_id', 'organization_id', 'contest_id', 'federation_id', 'role_opening', 'id'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
