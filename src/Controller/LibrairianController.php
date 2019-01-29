<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Form\BookType;

class LibrairianController extends AbstractController
{
    /**
     * @Route("/librairian", name="librairian")
     */
    public function index()
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findBooksAndCategory();
        return $this->render('librairian/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/librairian/book", name="librairian_book")
     */
    public function singleBook()
    {
        return $this->render('librairian/index.html.twig', [
            'controller_name' => 'LibrairianController',
        ]);
    }

    /**
     * @Route("/librairian/users", name="librairian_users")
     */
    public function users()
    {
        return $this->render('librairian/index.html.twig', [
            'controller_name' => 'LibrairianController',
        ]);
    }

    /**
     * @Route("/librairian/new/book", name="librairian_new_book")
     */
    public function newBook(Request $request)
    {
      $book = new Book();
      $form = $this->createForm(BookType::class, $book);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $book = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();
      }
        return $this->render('librairian/newBook.html.twig', [
          "form" => $form->createView()
        ]);
    }
}
