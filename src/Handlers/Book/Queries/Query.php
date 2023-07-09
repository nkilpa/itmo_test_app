<?php

namespace App\Handlers\Book\Queries;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Query
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    )
    {
    }

    public function getAll(): JsonResponse
    {
        $books = $this->bookRepository->findAll();

        $result = [];
        foreach ($books as $book) {
            $result[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'publicationYear' => $book->getPublicationYear(),
                'isbn' => $book->getIsbn(),
                'pageCount' => $book->getPageCount(),
                'createdAt' => $book->getCreatedAt(),
                'updatedAt' => $book->getUpdatedAt(),
            ];
        }

        return new JsonResponse($result);
    }

    public function getById(int $id): JsonResponse|Response
    {
        $book = $this->bookRepository->findOneBy(['id' => $id]);

        if (empty($book)) {
            return new Response('Book not found', Response::HTTP_NOT_FOUND);
        }

        $result = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'publicationYear' => $book->getPublicationYear(),
            'isbn' => $book->getIsbn(),
            'pageCount' => $book->getPageCount(),
            'createdAt' => $book->getCreatedAt(),
            'updatedAt' => $book->getUpdatedAt(),
        ];

        return new JsonResponse($result);
    }
}