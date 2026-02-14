<?php

/**
 * Lookup table for: federation_mores.referenced_table
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
        Schema::create('federation_mores_referenced_tables', function (Blueprint $table) {
            $table->id();
            $table->char('referenced_table', 40)
                ->charset('ascii')->collation('ascii_general_ci')
                ->unique()->comment('real pk - lowercase');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_mores_referenced_tables');
    }
};
