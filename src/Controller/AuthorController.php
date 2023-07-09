<?php

namespace App\Controller;

use App\Handlers\Author\Commands\AuthorDto;
use App\Handlers\Author\Commands\Create;
use App\Handlers\Author\Commands\Delete;
use App\Handlers\Author\Commands\Update;
use App\Handlers\Author\Queries\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_author_')]
class AuthorController extends AbstractController
{
    #[Route('/author', name: 'create_author', methods: 'POST')]
    public function create(#[MapRequestPayload] AuthorDto $authorDto, Create $action): JsonResponse|Response
    {
        return $action->handle($authorDto);
    }

    #[Route('/author/{id}', name: 'update_author', methods: 'POST')]
    public function update(#[MapRequestPayload] AuthorDto $authorDto, int $id, Update $action): JsonResponse|Response
    {
        return $action->handle($authorDto, $id);
    }

    #[Route('/author/{id}', name: 'delete_author', methods: 'DELETE')]
    public function delete(int $id, Delete $action): Response
    {
        return $action->handle($id);
    }

    #[Route('/author/{id}', name: 'get_author', methods: 'GET')]
    public function get(int $id, Query $query): JsonResponse|Response
    {
        return $query->getById($id);
    }

    #[Route('/authors', name: 'get_authors', methods: 'GET')]
    public function list(Query $query): JsonResponse
    {
        return $query->getAll();
    }
}