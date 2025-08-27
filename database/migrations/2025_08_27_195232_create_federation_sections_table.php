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
        Schema::create('federation_sections', function (Blueprint $table) {
            $table->id(); // 
            $table->foreignId('federation_id')->comment('fx: federation.id');
            $table->string('code', 5)->comment('as from federations regulation');
            $table->string('name');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idx
            $table->unique(['federation_id', 'code']);
            // relations
            // $table->foreign('federation_id')->references('id')->on('federations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_sections');
    }
};
