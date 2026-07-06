<?php

/**
 * Lookup table for: federation_mores.referenced
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
        Schema::create('federation_mores_referenced_sets', function (Blueprint $table) {
            $table->char('id', 40)
                ->charset('ascii')->collation('ascii_general_ci')
                ->primary()->comment('table');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->comment('lookup table for: federation_mores.referenced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_mores_referenced_sets');
    }
};
