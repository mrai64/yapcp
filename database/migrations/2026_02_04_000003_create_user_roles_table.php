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
            $table->id();
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_contacts.id');

            $table->string('role')->default('member')->index('role_idx')->comment('fk: user_roles_role_sets.role');

            // TODO replace columns organizaton
            // $table->char('roled_to', 10)->charset('ascii')->collation('ascii_general_ci')
            //     ->nullable()->index()->comment('fk: user_roles_context_sets.id');
            // $table->char('roled_id', 36)->charset('ascii')->collation('ascii_general_ci')
            //     ->nullable()->index()->comment('fk: (roled_to).id');
            $table->char('organization_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('fk: organizations.id');
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('fk: contests.id');
            $table->char('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()->index()->comment('fk: federations.id');

            $table->dateTime('role_opening')->useCurrent()->index()
                ->comment('Start of role works - default: today');
            $table->dateTime('role_closing')->default('9999-12-31 23:59:59')
                ->comment('End of role works default:future');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->index(
                [
                'user_id',
                'organization_id',
                'contest_id',
                'federation_id',
                'role_opening',
                'id'
                ],
                'general_idx'
            );

            $table->foreign(['organization_id'])->references(['id'])->on('organizations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['contest_id'])->references(['id'])->on('contests')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['role'])->references(['role'])->on('user_roles_role_sets')->onUpdate('restrict')->onDelete('restrict');

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
