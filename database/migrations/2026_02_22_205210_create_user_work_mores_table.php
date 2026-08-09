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
        Schema::create('user_work_mores', function (Blueprint $table) {
            $table->id(); // standard id, not uuid
            $table->char('user_work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk: user_works.id');

            $table->string('federation_id', 10)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk: federation_mores.federation_id');
            $table->string('field_name', 20)->charset('ascii')->collation('ascii_general_ci')
                ->comment('fk: federation_mores.field_name');
            $table->string('field_value')->default('')->comment('following rules when updated');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index('user_work_id', 'user_work_idx');
            $table->index('federation_id', 'federation_idx');
            $table->index('field_value', 'federation_fields_idx');
            $table->unique(['user_work_id', 'federation_id', 'field_name'], 'alt_primary_idx')
                ->comment('real pk');
            // fk
            $table->foreign('user_work_id', 'fk_uwm_uw')
                ->references('id')->on('user_works')
                ->onUpdate('cascade')->onDelete('cascade');
            //
            $table->foreign(['federation_id', 'field_name'], 'fk_uwm_fed_more')
                ->references(['federation_id', 'field_name'])
                ->on('federation_mores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // comm
            $table->comment('one more field required from federations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_work_mores');
    }
};
