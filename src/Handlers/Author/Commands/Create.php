<?php

namespace App\Handlers\Author\Commands;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Create
{
    public function __construct(
        private readonly AuthorRepository   $authorRepository,
        private readonly ValidatorInterface $validator,
    )
    {
    }

    public function handle(AuthorDto $dto)
    {
        $author = new Author();
        $author->setFirstName($dto->firstName);
        $author->setSecondName($dto->secondName);
        $author->setMiddleName($dto->middleName);
        $author->setCreatedAt(date_create_immutable());
        $author->setUpdatedAt(date_create_immutable());

        $errors = $this->validator->validate($author);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages);
        }

        $this->authorRepository->save($author, true);

        return new Response('', 201);
    }
}