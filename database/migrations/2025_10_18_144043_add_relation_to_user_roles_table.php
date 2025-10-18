<?php
/**
 * refactor 
 * user_roles first build
 * user_role_role_sets now build and filled (must be builded n filled before user_roles)
 * create relation 1:1 between user_roles.role 
 *                 and user_role_role_sets.role
 * (usually 1:1 n 1:N between child.father_id w/ father.id)
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
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('role')->references('role')->on('user_role_role_sets');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            //
            $table->dropForeign('role');
        });
    }
};
