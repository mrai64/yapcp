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
        Schema::create('works', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36)->index();
            $table->string('work_file')->default('')->comment('path n file');
            $table->string('extension', 6)->comment('lowercase');
            $table->char('reference_year', 4)->comment('default maybe YEAR(CURDATE())');
            $table->string('title_en')->comment('english title');
            $table->string('title_local')->comment('lang title');
            $table->unsignedInteger('long_side')->comment('pixel');
            $table->unsignedInteger('short_side')->comment('pixel');
            $table->char('monochromatic', 1)->default('N')->comment('Y/N as true/false');
            $table->dateTime('created_at')->useCurrent()->comment('reserved');
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('reserved');
            $table->dateTime('deleted_at')->nullable()->index()->comment('reserved');

            $table->index(['user_id', 'id'], 'fifth_idx');
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
