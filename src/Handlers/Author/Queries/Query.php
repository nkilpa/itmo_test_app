<?php

namespace App\Handlers\Author\Queries;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Query
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
    )
    {
    }

    public function getAll()
    {
        $authors = $this->authorRepository->findAll();

        $result = [];
        foreach ($authors as $author) {
            $result[] = [
                'id' => $author->getId(),
                'firstName' => $author->getFirstName(),
                'secondName' => $author->getSecondName(),
                'middleName' => $author->getMiddleName(),
                'createdAt' => $author->getCreatedAt(),
                'updatedAt' => $author->getUpdatedAt(),
            ];
        }

        return new JsonResponse($result);
    }

    public function getById(int $id)
    {
        $author = $this->authorRepository->findOneBy(['id' => $id]);

        if (empty($author)) {
            return new Response('Author not found', Response::HTTP_NOT_FOUND);
        }

        $result = [
            'id' => $author->getId(),
            'firstName' => $author->getFirstName(),
            'secondName' => $author->getSecondName(),
            'middleName' => $author->getMiddleName(),
            'createdAt' => $author->getCreatedAt(),
            'updatedAt' => $author->getUpdatedAt(),
        ];

        return new JsonResponse($result);
    }
}