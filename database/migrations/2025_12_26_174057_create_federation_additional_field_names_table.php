<?php

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
        Schema::create('federation_additional_field_names', function (Blueprint $table) {
            $table->id();
            $table->string('federation_id', 10)->comment('fk federations'); // FK to federation table
            $table->string('federation_field_name',20)->comment('lowercase'); 
            $table->string('federation_field_label')->comment('english label for the field');
            // we assume all are type string 255 for now
            $table->string('federation_field_validation_rules',255)->nullable()->comment('string or function(), validation rules for the field, nullable if none');
            
            //
            // for incremental backup and softdelete
            $table->dateTime('created_at')->useCurrent(); // no timestamps
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable(); // softDelete
            //
            // idx
            $table->unique(['federation_id', 'federation_field_name'], 'second_idx');
            //
            // fk
            $table->foreign('federation_id')->references('id')->on(Federation::table_name)->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_additional_field_names');
    }
};
