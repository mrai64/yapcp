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
        Schema::create('user_roles_role_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role', 25)->index('pcp_user_roles_role_sets_status_index');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['role', 'deleted_at'], 'pcp_user_roles_role_sets_status_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles_role_sets');
    }
};
