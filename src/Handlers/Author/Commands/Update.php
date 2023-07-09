<?php

namespace App\Handlers\Author\Commands;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Update
{
    public function __construct(
        private readonly AuthorRepository   $authorRepository,
        private readonly ValidatorInterface $validator,
    )
    {
    }

    public function handle(AuthorDto $dto, int $id)
    {
        $author = $this->authorRepository->findOneBy(['id' => $id]);

        if (empty($author)) {
            return new Response('Author not found', Response::HTTP_NOT_FOUND);
        }

        $author->setFirstName($dto->firstName);
        $author->setSecondName($dto->secondName);
        $author->setMiddleName($dto->middleName);
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

        return new Response('', 200);
    }
}