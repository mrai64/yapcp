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
        Schema::dropIfExists('user_roles_role_contexts');
        Schema::create('user_roles_role_contexts', function (Blueprint $table) {

            $table->string('role', 25)
                ->index('role_idx')->comment('fk user_roles_role_sets.id');

            $table->char('context', 16)->charset('ascii')->collation('ascii_general_ci')
                ->index('context_idx')->comment('fk user_roles_context_set.id');

            // green as green light
            $table->boolean('green')->default(false)->comment('true green flag, false red flag');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->comment('pivot table');
            // fk
            $table->foreign(['role'])->references(['role'])->on('user_roles_role_sets')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['context'])->references(['context_type'])->on('user_roles_context_sets')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles_role_contexts');
    }
};
