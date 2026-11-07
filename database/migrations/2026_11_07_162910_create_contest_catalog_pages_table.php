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
        Schema::create('contest_catalog_pages', function (Blueprint $table) {
            $table->id(); // Bigint incrementale come PK ordinaria
            $table->char('contest_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contests.id');
            $table->char('contest_section_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()
                ->index()->comment('fk: contest_sections.id');

            // Riferimenti opzionali alle fonti originali (per tracciabilità)
            $table->char('contest_work_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()
                ->index()->comment('fk: contest_works.id');
            $table->char('contest_award_id', 36)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()
                ->index()->comment('fk: contest_awards.id');

            // Controllo sequenza stile PowerPoint
            $table->unsignedInteger('page')->default(0);
            $table->char('layout_type', 16)
                ->charset('ascii')->collation('ascii_general_ci')
                ->index()->comment('fk: contest_catalog_pages_layout_sets.layout_type');
            // es: 'cover', 'jury', 'section_intro', 'work_grid', 'award_full', 'best_author'

            // Dati congelati (Snapshot) per evitare rotture se l'utente cancella l'account
            $table->char('country_id', 3)->charset('ascii')->collation('ascii_general_ci')
                ->nullable()
                ->index()->comment('fk: countries.id ');
            $table->string('author_name')->nullable();    // Autore (da UserContact), from country_flag country_code, city, region
            $table->string('title')->nullable();          // Titolo opera o titolo pagina speciale
            $table->string('subtitle')->nullable();       // Eventuale sottotitolo o categoria premio
            $table->string('image_path')->nullable();     // Immagine associata (opera, foto giuria, badge)
            $table->text('description')->nullable();      // Motivazione giuria (citation) o testo libero
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();
            //
            $table->index(['contest_id', 'contest_section_id', 'country_id', 'author_name', 'title'], 'generate_idx');
            $table->unique(['contest_id', 'page', 'id'], 'sequence_idx');
            //
            $table->foreign(['country_id'])->references(['id'])->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['layout_type'])->references(['layout_type'])->on('contest_catalog_pages_layout_sets')
                ->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_catalog_pages');
    }
};
