<?php

namespace App\Handlers\Book\Commands;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;

class Delete
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    )
    {
    }

    public function handle(int $id): Response
    {
        $book = $this->bookRepository->findOneBy(['id' => $id]);

        if (empty($book)) {
            return new Response('Book not found', Response::HTTP_NOT_FOUND);
        }

        $this->bookRepository->remove($book, true);

        return new Response('', 200);
    }
}