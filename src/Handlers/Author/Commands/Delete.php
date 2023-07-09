<?php

namespace App\Handlers\Author\Commands;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;

class Delete
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
    )
    {
    }

    public function handle(int $id)
    {
        $author = $this->authorRepository->findOneBy(['id' => $id]);

        if (empty($author)) {
            return new Response('Author not found', Response::HTTP_NOT_FOUND);
        }

        $this->authorRepository->remove($author, true);

        return new Response('', 200);
    }
}