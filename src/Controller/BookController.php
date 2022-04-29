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
    public function createBook(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

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
    ): Response
    {   
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
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->render('book/one_book.html.twig', [
            'book' => $book
        ]);
    }

    /**
    * @Route("/book/delete/{id}", name="book_delete_by_id")
    */
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book');
    }

    /**
    * @Route("/book/update/{id}", name="book_update")
        */
    public function updateBook(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->render('book/one_book.html.twig', [
            'book' => $book
        ]);
    }

        /**
        * @Route(
        *       "/book/update/{id}/{title}/{author}/{isbn}/{image}", 
        *       name="book_update_process",
        *       methods={"POST"}
        * )
        */
        public function updateBookProcess(
            ManagerRegistry $doctrine,
            int $id,
            string $title,
            string $author,
            string $image
        ): Response {
            //$entityManager = $doctrine->getManager();
            //$book = $entityManager->getRepository(Book::class)->find($id);
    
            //if (!$book) {
            //    throw $this->createNotFoundException(
            //        'No book found for id '.$id
            //    );
            //}
    
            //$book->setValue($value);
            //$entityManager->flush();
    
            //return $this->redirectToRoute('book_show_all');
        }
}
