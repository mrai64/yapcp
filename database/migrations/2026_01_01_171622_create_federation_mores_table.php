<?php

/**
 * lookup table for dynamic form
 */

use App\Models\Federation;
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
        Schema::create('federation_mores', function (Blueprint $table) {
            $table->id(); // ok standard id
            $table->string('federation_id', 10)
                ->comment('fk federations'); // FK to federation table
            $table->string('field_name', 20)
                ->comment('lowercase');
            $table->string('field_label')
                ->comment('label for the field');
            // we assume all are type string 255 for now
            $table->string('field_validation_rules')
                ->default('string|max:255')
                ->comment('string or function(), validation rules for the field, nullable if none');
            $table->string('field_default_value')
                ->default('')
                ->comment('empty string as default default value');
            // for incremental backup and softdelete
            $table->dateTime('created_at')->useCurrent(); // no timestamps
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable(); // softDelete
            // idx
            $table->index('updated_at', 'backup_idx');
            $table->index('deleted_at', 'soft_delete_idx');
            $table->unique(['federation_id', 'field_name'], 'alt_primary_idx')
                ->comment('real primary');
            // relations
            // N:1 to federations
            $table->foreign('federation_id')->references('id')->on(Federation::table_name);
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
