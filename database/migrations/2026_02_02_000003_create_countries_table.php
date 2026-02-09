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
        Schema::create('countries', function (Blueprint $table) {
            $table->char('id', 3)->charset('ascii')->collation('ascii_general_ci')->primary()->comment('iso-3166 alpha-3 uppercase');
            $table->string('country')->index()->comment('english official');
            $table->char('flag_code', 20)->nullable()->comment('Unicode chars for country flag emoji');
            $table->char('lang_code', 2)->nullable()->index()->comment('when used in lang=xx_YY');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->comment('based on iso-3166, but hand filled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
