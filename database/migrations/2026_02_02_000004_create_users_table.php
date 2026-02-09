<?php

/**
 * For platform entry only
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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->charset('ascii')->collation('ascii_general_ci')->primary()->comment('lowercase uuid');
            $table->string('name')->index()
                ->comment('surname, name - not used for access');
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent()->index();
            $table->dateTime('deleted_at')->nullable()->index();

            $table->comment('for platform access only - other user info un user_contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
