<?php

namespace App\Handlers\Book\Commands;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Create
{
    public function __construct(
        private readonly BookRepository     $bookRepository,
        private readonly AuthorRepository   $authorRepository,
        private readonly ValidatorInterface $validator,
    )
    {
    }

    public function handle(BookDto $dto): JsonResponse|Response
    {
        $book = new Book();
        $book->setTitle($dto->title);
        $book->setPublicationYear($dto->publicationYear);
        $book->setIsbn($dto->isbn);
        $book->setPageCount($dto->pageCount);
        $book->setCreatedAt(date_create_immutable());
        $book->setUpdatedAt(date_create_immutable());

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages);
        }

        switch (gettype($dto->authorId)) {
            case 'integer':
                $author = $this->authorRepository->find($dto->authorId);

                if (empty($author)) {
                    return new Response('Author with id ' . $dto->authorId . ' not found', 404);
                }

                $book->addAuthor($author);
                break;
            case 'array':
                foreach ($dto->authorId as $authorId) {
                    $author = $this->authorRepository->find($authorId);
                    $book->addAuthor($author);
                }
                break;
        }

        $this->bookRepository->save($book, true);

        return new Response('', 201);
    }
}