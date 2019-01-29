<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LibrairianController extends AbstractController
{
    /**
     * @Route("/librairian", name="librairian")
     */
    public function index()
    {
        return $this->render('librairian/index.html.twig', [
            'controller_name' => 'LibrairianController',
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
    public function newBook()
    {
        return $this->render('librairian/newBook.html.twig', [
        ]);
    }
}
