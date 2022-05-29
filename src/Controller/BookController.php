<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

class BookController extends AbstractController
{
    /**
    * @Route("/book", name="book")
    */
    public function showAllBooks(
        bookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->render('book/all_books.html.twig', [
            'title' => 'Bibliotek',
            'books' => $books,
            'link_to_create_book' => $this->generateUrl('add_book')
        ]);
    }

    /**
    * @Route(
    *       "/book/create",
    *       name="add_book",
    *       methods={"GET","HEAD"}
    * )
    */
    public function createBook(): Response
    {
        return $this->render('book/add_book.html.twig', [
            'title' => 'Lägg till bok'
        ]);
    }

    /**
    * @Route(
    *      "/book/create",
    *      name="add_book_process",
    *      methods={"POST"}
    * )
    */
    public function createBookProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $author  = $request->request->get('author');
        $isbn  = $request->request->get('ISBN');
        $image  = $request->request->get('Image');

        $book = new Book();
        $book->setTitle($title);
        $book->setISBN($isbn);
        $book->setAuthor($author);
        $book->setImage($image);

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->redirectToRoute('book');
    }

    /**
    * @Route("/book/show/{id}", name="book_by_id")
    */
    public function showBookById(
        bookRepository $bookRepository,
        int $userId
    ): Response {
        $book = $bookRepository
            ->find($userId);

        return $this->render('book/one_book.html.twig', [
            'book' => $book
        ]);
    }

    /**
    * @Route("/book/delete/{id}", name="book_delete_by_id")
    */
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $userId
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($userId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $userId
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book');
    }

    /**
    * @Route(
    *   "/book/update/{id}",
    *    name="book_update",
    *    methods={"GET","HEAD"}
    * )
        */
    public function updateBook(
        bookRepository $bookRepository,
        int $userId
    ): Response {
        $book = $bookRepository
            ->find($userId);

        return $this->render('book/update_book.html.twig', [
            'title' => 'Uppdatera bok',
            'book' => $book
        ]);
    }

    /**
    * @Route(
    *       "/book/update/{id}",
    *       name="book_update_process",
    *       methods={"POST"}
    * )
    */
    public function updateBookProcess(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $userId = $request->request->get('id');
        $title = $request->request->get('title');
        $author  = $request->request->get('author');
        $isbn  = $request->request->get('ISBN');
        $image  = $request->request->get('Image');

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($userId);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $userId
            );
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setISBN($isbn);
        $book->setImage($image);
        $entityManager->flush();

        return $this->redirectToRoute('book');
    }
}
