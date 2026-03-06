<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->string('id', 40)->charset('ascii')->collation('ascii_general_ci')
                ->primary()->comment('valid for php_timezones');
            $table->char('region_id', 12)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk timezone_region_sets.id');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->foreign(['region_id'])->references(['id'])->on('timezone_region_sets')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->comment('correspond to php_timezone version 2025.3');
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
