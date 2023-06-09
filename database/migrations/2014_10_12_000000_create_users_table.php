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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nickname')
                ->unique();

            $table->string('email')
                ->unique();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->foreignId('role_id')->default(2)
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->text('description')
                ->nullable()
                ->fulltext();

            $table->string('photo')->nullable();
            $table->string('banner')->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
