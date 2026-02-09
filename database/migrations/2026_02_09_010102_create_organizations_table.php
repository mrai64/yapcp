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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary();
            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: countries.id - hq country');
            $table->string('name')->index()->comment('english official');

            $table->string('email')->unique();
            $table->string('website')->nullable()->comment('official organization website');
            $table->text('contact')->nullable()->comment('hq postal address');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            // id pk unique
            // country_id
            // name
            // email unique
            // updated_at for backup
            // deleted_at for query
            $table->index(['country_id', 'name'], 'country_name_idx');

            $table->foreign(['country_id'])->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->comment('who organize contests');
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
