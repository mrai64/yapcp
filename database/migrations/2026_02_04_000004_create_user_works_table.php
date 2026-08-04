<?php

/**
 * user author works
 * version 2026-08-04
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
            $table->uuid('id')
                ->charset('ascii')->collation('ascii_general_ci')
                ->primary()
                ->comments('author works depot id');
            // owner
            $table->char('user_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comments('fk. user_contacts.id');

            $table->string('title_en')
                ->default('')
                ->comment('english title');
            $table->string('title_local')
                ->default('')
                ->comment('user_contacts.local_lang title');
            // file infos
            $table->string('file_path')
                ->default('')->unique()
                ->comment('path n complete filename, complete');

            $table->char('file_format', 6)
                ->charset('ascii')->collation('ascii_general_ci')    
                ->default('')->index()
                ->comment('file extension lowercase');

            $table->unsignedInteger('file_size')
                ->default(0)
                ->comment('Bytes');

            $table->unsignedInteger('long_size')
                ->default(0)
                ->comment('pixels');
            $table->unsignedInteger('short_size')
                ->default(0)
                ->comment('pixels');
            // other infos
            $table->boolean('is_monochromatic')
                ->default(false)->index()
                ->comment('declared BW / monochromatic');

            $table->boolean('has_raw_file')
                ->default(false)
                ->comment('author has raw file, of work');
            //
            // first year of admission in contest has been transferred to user_work_mores
            //

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            // idx
            $table->index(['user_id', 'file_path'], 'generic1_idx');
            $table->index(['user_id', 'title_en'], 'generic2_idx');
            $table->index(['user_id', 'updated_at'], 'generic3_idx');
            $table->index(['user_id', 'is_monochromatic', 'title_en'], 'generic4_idx');
            // fk
            $table->foreign(['user_id'])->references(['id'])->on('users')
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
