<?php

/**
 * user author works
 *
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
        Schema::create('user_works', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')
                ->primary()->comments('author works depot id');
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comments('fk. user_contacts.id');

            $table->string('work_file')->default('')->unique()
                ->comment('path n filename internal');
            $table->char('extension', 6)->charset('ascii')->collation('ascii_general_ci')
                ->default('')->index()->comment('');

            $table->string('title_en')->comment('english title');
            $table->string('title_local')->comment('lang title');

            $table->unsignedInteger('long_side')->comment('pixel');
            $table->unsignedInteger('short_side')->comment('pixel');
            $table->boolean('monochromatic')->default(false)
                ->comment('declared BW monochromatic');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->foreign(['user_id'])->references(['id'])->on('user_contacts')
                ->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_works');
    }
};
