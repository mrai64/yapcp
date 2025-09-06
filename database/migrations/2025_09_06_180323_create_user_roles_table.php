<?php
/**
 * User Roles table
 * memorize if a user had a role in organization and/or Federation
 * and which is the role
 * 
 * TODO Factory yes but
 * TODO Seeder 
 * TODO role list
 * - organization/member
 *   Qualified to manage contest
 * - federation/member
 *   Qualified to check contests under her/him federation patronage
 * - Backup n Softdelete yes but also 
 * - begin and closing dateTime for role
 *   warning should be more than a record for same triplet
 *   (user, role, federation) but interval intersection must be void
 * 
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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id(); // bigint ok 
            $table->string('user_id',36)->index()
                ->comment('fk: users.id');
            $table->string('organization_id',36)->index()
                ->comment('fk: organizations.id');
            $table->string('role');
            $table->dateTime('role_opening')->useCurrent()
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
