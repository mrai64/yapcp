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
        Schema::create('contest_patronages', function (Blueprint $table) {
            $table->id();
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk for contests id');
            $table->string('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk federations id');
            $table->string('patronage_code', 20)->charset('ascii')->collation('ascii_general_ci')
                ->comment('');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['contest_id', 'federation_id', 'patronage_code'], 'alt_primary_idx');
            //
            $table->comment('additional values for user_contacts based on federation_mores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_patronages');
    }
};
