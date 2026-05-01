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
        Schema::create('federation_distinctions', function (Blueprint $table) {
            $table->id()->comment('real pk is federation_id + code');
            $table->char('federation_id', 10)->charset('ascii')
                ->collation('ascii_general_ci')->index();
            $table->char('code', 10)->charset('ascii')->collation('ascii_general_ci')->index();
            $table->string('name_en')->index()->comment('official name in english');
            $table->tinyInteger('sequence', 2)->default(0)->comment('to graduate from less to more');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->unique(['federation_id', 'code'], 'unique_code_idx');
            $table->unique(['federation_id', 'sequence'], 'unique_sequence_idx');
            // fk
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federation_distinctions');
    }
};
