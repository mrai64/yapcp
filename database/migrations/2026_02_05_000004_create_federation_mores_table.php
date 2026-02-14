<?php

/**
 * The model UserContacts hold a minimum set
 * of info required by all the contests:
 * name, address, email, telephone.
 * but are not all required from contests sponsored
 * by federations, there is
 * One More Thing
 * that any federation require, and that's the place
 * how we list these fields
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
        Schema::create('federation_mores', function (Blueprint $table) {
            $table->id()->comment('the real pk is federation_id + field_name');

            $table->char('referenced_table', 40)
                ->charset('ascii')->collation('ascii_general_ci')
                ->unique()->comment('real pk - lowercase');

            $table->string('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk federations.id');
            $table->string('field_name', 20)->charset('ascii')->collation('ascii_general_ci')
                ->comment('lowercase');

            $table->string('field_label')->comment('label for the field');
            $table->string('field_validation_rules')->default('string|max:255')->comment('string or function(), validation rules for the field, nullable if none');
            $table->string('field_default_value')->default('')->comment('empty string as default default value');
            $table->string('field_suggest')->default('')->comment('message to explain what insert');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->unique(['federation_id', 'field_name'], 'alt_primary_idx');

            $table->foreign(['referenced_table'], 'reference_fk')
                ->references(['referenced_table'])->on('federation_mores_referenced_tables')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')
                ->onUpdate('restrict')->onDelete('restrict');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_mores');
    }
};
