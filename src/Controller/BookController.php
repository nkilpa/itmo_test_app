<?php

namespace App\Controller;

use App\Handlers\Book\Commands\BookDto;
use App\Handlers\Book\Commands\Create;
use App\Handlers\Book\Commands\Delete;
use App\Handlers\Book\Commands\Update;
use App\Handlers\Book\Queries\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_book_')]
class BookController extends AbstractController
{
    #[Route('/book', name: 'create_book', methods: 'POST')]
    public function create(#[MapRequestPayload] BookDto $bookDto, Create $action): JsonResponse|Response
    {
        return $action->handle($bookDto);
    }

    #[Route('/book/{id}', name: 'update_book', methods: 'POST')]
    public function update(#[MapRequestPayload] BookDto $bookDto, int $id, Update $action): Response
    {
        return $action->handle($bookDto, $id);
    }

    #[Route('/book/{id}', name: 'delete_book', methods: 'DELETE')]
    public function delete(int $id, Delete $action): Response
    {
        return $action->handle($id);
    }

    #[Route('/book/{id}', name: 'get_book', methods: 'GET')]
    public function get(int $id, Query $query): JsonResponse|Response
    {
        return $query->getById($id);
    }

    #[Route('/books', name: 'get_books', methods: 'GET')]
    public function list(Query $query): JsonResponse
    {
        return $query->getAll();
    }
}