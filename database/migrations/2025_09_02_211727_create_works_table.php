<?php

/**
 * Works is child table of users
 *
 * use uuid()
 */
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
        Schema::create('works', function (Blueprint $table) {
            $table->uuid('id')->primary()
                ->comment('uuid'); // was $table->id();
            $table->foreignUuid('user_id')->index()
                ->comment('fk: users.id');
            $table->string('work_file')
                ->comment('path n file');
            $table->string('extension', 6)->comment('lowercase');
            //
            $table->char('reference_year', 4)
                ->comment('default maybe YEAR(CURDATE())');
            $table->string('title_en')->comment('english title');
            $table->string('title_local')->comment('lang title');
            // image data
            $table->unsignedInteger('long_side')->comment('pixel / cm');
            $table->unsignedInteger('short_side')->comment('pixel / cm');
            $table->char('monochromatic', 1)->default('N')->comment('not bool but oldstyle uppercase | Y / N');
            //
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();

            // idx rename
            $table->index(['user_id', 'reference_year', 'title_en'], 'general_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
