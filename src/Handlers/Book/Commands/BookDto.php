<?php

namespace App\Handlers\Book\Commands;

class BookDto
{
    public string $title;
    public int $publicationYear;
    public string $isbn;
    public int $pageCount;
    public int|array $authorId;
}