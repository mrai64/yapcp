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
            $table->bigIncrements('id');
            $table->char('user_id', 36)->index();
            $table->string('role')->default('member')->index('pcp_user_roles_role_foreign');
            $table->char('organization_id', 36)->nullable()->index();
            $table->char('contest_id', 36)->nullable()->index();
            $table->char('federation_id', 10)->nullable()->index()->comment('fk to federations.id');
            $table->dateTime('role_opening')->useCurrent()->index()->comment('Start of role works - default today');
            $table->dateTime('role_closing')->default('9999-12-31 23:59:59')->comment('End of role works default:future');
            $table->dateTime('created_at')->useCurrent()->comment('backup reserved');
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('backup reserved');
            $table->dateTime('deleted_at')->nullable()->index()->comment('softdelete reserved');

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
