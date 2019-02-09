<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Form\BorrowType;
use App\Form\SortBookType;


class LibrairianController extends AbstractController
{
    /**
     * @Route("/librairian/{page}", name="librairian", requirements={"page"="\d+"})
     */
    public function index(Request $request, $page = 1)
    {
        $nextUrl = $this->generateUrl($request->get("_route"), ['page' => $page + 1]);
        $previousUrl = $this->generateUrl($request->get("_route"), ['page' => $page - 1]);
        $max = $page * 10 ;
        $books = $this->getDoctrine()->getRepository(Book::class)->findBooksAndCategory($max);
        $form = $this->createForm(SortBookType::class);
        return $this->render('librairian/index.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
            "nextUrl" => $nextUrl,
            "previousUrl" => $previousUrl
        ]);
    }

    /**
     * @Route("/librairian/sort/{page}", name="librairian_sort", requirements={"page"="\d+"})
     */
    public function bookSort(Request $request, SessionInterface $session, $page = 1)
    {
      $nextUrl = $this->generateUrl($request->get("_route"), ['page' => $page + 1]);
      $previousUrl = $this->generateUrl($request->get("_route"), ['page' => $page - 1]);
      $max = $page * 10 ;
        $form = $this->createForm(SortBookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $category = $form->getData()["category"];
          $session->set('category', $category);
          $books = $this->getDoctrine()->getRepository(Book::class)->findBooksAndCategory($max, $session->get("category"));
        }
        else {
          $books = $this->getDoctrine()->getRepository(Book::class)->findBooksAndCategory($max, $session->get("category"));
        }

        return $this->render('librairian/index.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
            "nextUrl" => $nextUrl,
            "previousUrl" => $previousUrl
        ]);
    }

    /**
     * @Route("/librairian/book/{id}", name="librairian_book")
     */
    public function singleBook($id, Request $request)
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->findBookAndUser($id);
        if(!$book) {
          throw $this->createNotFoundException("Ce livre n'existe pas");
        }
        $form = $this->createForm(BorrowType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $data = $form->getData();
          $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["code" => $data["code"]]);
          if(!$user) {
            $this->addFlash("danger", "Ce code utilisateur n'est pas valide");
          }
          else {
            $book->setBorrower($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash("success", "Le livre a été emprunté");
          }
        }

        return $this->render('librairian/singleBook.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/librairian/book/back/{id}", name="librairian_book_back")
     */
    public function bookBack(Book $book)
    {
      if($book->getAvailability()) {
        $this->addFlash("danger", "Ce livre n'a jamais été emprunté");
      }
      else {
        $book->setBorrower(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        $this->addFlash("success", "Le livre a été rendu");
      }
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
        public function singleUser($id)
        {
          $user = $this->getDoctrine()->getRepository(User::class)->findUserAndBooks($id);
          if(!$user) {
            throw $this->createNotFoundException("Cet utilisateur n'existe pas");
          }
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
