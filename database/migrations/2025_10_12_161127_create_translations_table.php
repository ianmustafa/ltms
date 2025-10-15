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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('key', 191);
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['locale', 'key']);
            $table->index('key');
            $table->fullText(['value', 'key']);

            $table->foreign('locale')->references('code')->on('locales')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
