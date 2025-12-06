<?php

/**
 * - Not int id but string uuid id
 * - Factory yes
 * - SoftDelete yes
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('uuid assigned'); // $table->id();
            $table->string('country_code', 3)->index()->comment('ALL UPPERCASE, one of iso-3166 alpha-3');
            $table->string('name')->index();
            $table->string('email')->unique()->comment('Should became verified');
            $table->string('website')->nullable();
            // backup and softdelete
            $table->dateTime('created_at')->useCurrent(); // no timestamps
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable(); // softDelete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
