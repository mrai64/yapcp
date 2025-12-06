<?php

/**
 * maintain timezones value valid for php and used
 *
 * region id should be related to an auxiliary table
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

        Schema::create('timezones', function (Blueprint $table) {
            // $table->id();
            $table->string('id', 40)->primary()->comment('valid for php_timezones');
            $table->string('region_id', 20)->index()->comment('fk regions.id');
            // timetable
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
            // idxs

            // relations
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timezones');
    }
};
