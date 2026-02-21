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
        Schema::create('user_work_validations', function (Blueprint $table) {
            $table->id()->comment('real pk is: user_work_id + federation_section_id'); // no uuid
            $table->char('user_user_work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: user_works.id');
            $table->unsignedBigInteger('federation_section_id')->index()
                ->comment('fk: federation_sections.id ');
            $table->char('validator_user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('contest organization members that validate the work for specific section');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->unique(['user_work_id', 'federation_section_id', 'deleted_at'], 'general_idx');
            //
            $table->foreign(['user_work_id'])->references(['id'])->on('user_works')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['validator_user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_section_id'])->references(['id'])->on('federation_sections')
                ->onUpdate('restrict')->onDelete('restrict');
            //
            $table->comment('human check for user_works on federation_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_work_validations');
    }
};
