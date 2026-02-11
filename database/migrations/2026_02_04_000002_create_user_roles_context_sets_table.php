<?php

/**
 * when a user had a role in
 * - organizations
 * - contests
 * - federations
 * - other
 * HERE is the list of context
 * - contests
 * - organizations
 * - federations
 *
 * only three but expandable
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles_context_sets', function (Blueprint $table) {
            $table->id();

            $table->char('context_type', 10)->charset('ascii')->collation('ascii_general_ci')
                ->unique()->comment('the real pk');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->comment('lookup table for: user_roles.context_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles_context_sets');
    }
};
