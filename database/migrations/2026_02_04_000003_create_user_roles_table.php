<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id(); // standard
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index('user_idx')->comment('fk: user_contacts.id');

            $table->string('role', 25)->default('member')
                ->index('role_idx')->comment('fk: user_roles_role_sets.role');

            // TODO replace columns organizaton
            // $table->char('context', 10)->charset('ascii')->collation('ascii_general_ci')
            //     ->nullable()->index()->comment('fk: user_roles_context_sets.id');
            // $table->char('context_id', 36)->charset('ascii')->collation('ascii_general_ci')
            //     ->nullable()->index()->comment('fk: (roled_to).id');

            $table->char('organization_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index('organization_idx')->comment('fk: organizations.id');
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index('contest_idx')->comment('fk: contests.id');
            $table->char('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index('federation_idx')->comment('fk: federations.id');

            $table->dateTime('role_opening')->useCurrent()
                ->index('start_idx')->comment('Start of role works - default: today');
            $table->dateTime('role_closing')->default('9999-12-31 23:59:59')
                ->comment('End of role works default:future');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            // primary
            // user_id
            // role
            // organization_id
            // contest_id
            // federation_id
            // role_opening
            $table->index([
                'organization_id',
                'user_id',
                'role',
                'role_opening'
            ], 'org_user_idx');
            $table->index([
                'contest_id',
                'user_id',
                'role',
                'role_opening'
            ], 'con_user_idx');
            $table->index([
                'federation_id',
                'user_id',
                'role',
                'role_opening'
            ], 'fed_user_idx');
            // fk
            $table->foreign(['organization_id'])->references(['id'])->on('organizations')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['contest_id'])->references(['id'])->on('contests')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['role'])->references(['role'])->on('user_roles_role_sets')
                ->onUpdate('cascade')->onDelete('cascade');
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
