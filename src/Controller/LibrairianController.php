<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Form\BorrowType;

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
     * @Route("/librairian/book/{id}", name="librairian_book")
     */
    public function singleBook(Book $book, Request $request)
    {
        $form = $this->createForm(BorrowType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $data = $form->getData();
          $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["code" => $data["code"]]);
          if(!$user) {
            throw $this->createNotFoundException("Ce code utilisateur n'existe pas");
          }
          $book->setBorrower($user);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($book);
          $entityManager->flush();
          $this->addFlash("success", "Le livre a été emprunté");
        }

        return $this->render('librairian/singleBook.html.twig', [
            'book' => $book,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/librairian/book/back/{id}", name="librairian_book_back")
     */
    public function bookBack(Book $book)
    {
      if($book->getAvailability()) {
        throw $this->createNotFoundException("Ce livre n'a jamais été emprunté");
      }
      $book->setBorrower(null);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($book);
      $entityManager->flush();
      $this->addFlash("success", "Le livre a été rendu");
      return $this->redirectToRoute('librairian_book', ["id" => $book->getId()]);
    }


    /**
     * @Route("/librairian/users", name="librairian_users")
     */
    public function users()
    {
      $users = $this->getDoctrine()->getRepository(User::class)->findAll();
      return $this->render('librairian/users.html.twig', [
          'users' => $users,
      ]);
    }


        /**
         * @Route("/librairian/user/{id}", name="librairian_user")
         */
        public function singleUser(User $user)
        {
            return $this->render('librairian/singleUser.html.twig', [
                'user' => $user,
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
