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
        Schema::table('contest_works', function (Blueprint $table) {
            $table->boolean('is_admit')->default(false)->comment("0 = not admit, admit otherwise")->change();
            // idx 
            $table->index(['section_id', 'is_admit', 'work_id'], 'admit_idx');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contest_works', function (Blueprint $table) {
            $table->dropIndex('admit_idx');
        });
    }
};
