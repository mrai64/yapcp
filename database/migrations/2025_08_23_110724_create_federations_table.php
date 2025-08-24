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
        Schema::create('federations', function (Blueprint $table) {
            $table->id();
            // TODO country_code 
            $table->string('code', 6)->index()->comment('all capitals');
            $table->string('name')->index();
            $table->string('website')->comment('Official federation web');
            // TODO 2K38bug change into dateTime
            // $table->timestamps();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            // softDeletes
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federations');
    }
};
