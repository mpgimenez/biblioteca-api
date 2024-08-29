<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cria a tabela books
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->year('publication_year');
            $table->timestamps();
        });

        // Cria a tabela pivot author_book
        Schema::create('author_book', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                  ->constrained('authors')
                  ->onDelete('cascade');
            $table->foreignId('book_id')
                  ->constrained('books')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Remove a tabela pivot author_book primeiro
        Schema::dropIfExists('author_book');

        // Remove a tabela books
        Schema::dropIfExists('books');
    }
};
