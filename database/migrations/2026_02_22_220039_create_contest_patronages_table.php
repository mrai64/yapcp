<?php

/**
 * Contest_patronages replace a field in contests
 *   table with a child table, which offer flexibility
 *   to manage a data actually informational only
 * TODO Implement n contest design and contest management
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contest_patronages', function (Blueprint $table) {
            $table->id();
            $table->char('contest_id', 36)
                ->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk for contests id');
            $table->string('federation_id', 10)
                ->charset('ascii')->collation('ascii_general_ci')
                ->index()
                ->comment('fk federations id');
            $table->string('patronage_code', 20)
                ->charset('ascii')->collation('ascii_general_ci')
                ->comment('');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            // contest_idx
            // federation_idx
            $table->unique(['contest_id', 'federation_id'], 'con_fed_idx');
            $table->unique(['federation_id', 'patronage_code'], 'fed_cod_idx');
            // fk
            $table->foreign('contest_id', 'con_pat_con_fk')
                ->references('id')->on('contests')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->foreign('federation_id', 'con_pat_fed_fk')
                ->references('id')->on('federations')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            //
            $table->comment('list of federation sponsor code');
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
