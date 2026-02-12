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
            $table->char('id', 3)->charset('ascii')->collation('ascii_general_ci')->primary()
                ->comment('iso-3166 alpha-3 uppercase');
            $table->string('country')->index()->comment('english official');
            $table->char('flag_code', 20)->nullable()->comment('Unicode chars for country flag emoji');
            $table->char('lang_code', 5)->charset('ascii')->collation('ascii_general_ci')->nullable()
                ->index()->comment('lang=xx_YY');
            $table->char('locale', 5)->charset('ascii')->collation('ascii_general_ci')->nullable()
                ->index()->comment('lang=xx');
            $table->char('calling_code', 10)->charset('ascii')->collation('ascii_general_ci')->nullable()
                ->index()->comment('[+nn] - [+nnn] - [+1 nnn]');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->comment('Based on iso-3166, and mledoze/countries');
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
