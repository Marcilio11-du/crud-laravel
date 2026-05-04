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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->dateTime('publishing_date');
            $table->string('cover_path')->nullable(); // Armazena o caminho da imagem

            // Relacionamento 1:N (Categorias)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Auditoria e SoftDelete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_user');
    }
};
