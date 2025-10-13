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
            $table->unsignedBigInteger('locale_id');
            $table->string('key', 191);
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['locale_id', 'key']);
            $table->index('key');
            $table->fullText(['value', 'key']);

            $table->foreign('locale_id')->references('id')->on('locales')->cascadeOnDelete();
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
