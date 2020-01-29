<?php

namespace App\Service;

use App\Repository\BookRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;


class Pagination
{
    private $repository;
    private $urlGenerator;
    private $security;
    private $nextUrl;
    private $previousUrl;
    private $min;
    private $max;
    private $pages;
    private $result;

    const NUMBER_RESULTS = 10;

    public function setPages($category = null) {
      $numberEntities = $this->repository->createQueryBuilder('b');
      if($category) {
        $numberEntities = $numberEntities->addSelect("c")
        ->leftJoin("b.category", "c")
        ->andWhere('c.id = :id')
        ->setParameter('id', $category->getId());
      }
            $numberEntities = $numberEntities->select('count(b.id)')
            ->getQuery()
            ->getSingleScalarResult();
      $this->pages = ceil($numberEntities/self::NUMBER_RESULTS);
    }

    public function makeUrls($route, $page) {
      if($page + 1 > $this->pages) {
        $this->nextUrl = $this->urlGenerator->generate($route, ['page' => $page]);
      }
      else {
        $this->nextUrl = $this->urlGenerator->generate($route, ['page' => $page + 1]);
      }
      if(($page - 1) > 0) {
        $this->previousUrl = $this->urlGenerator->generate($route, ['page' => $page - 1]);
      }
      else {
        $this->previousUrl = $this->urlGenerator->generate($route, ['page' => $page]);
      }
    }

    public function makeRange($page) {
      $this->max = $page * self::NUMBER_RESULTS ;
      $this->min = $this->max - self::NUMBER_RESULTS;
    }

    public function makePage($route, $page, $category = null) {
      $this->setPages($category);
      $this->makeUrls($route, $page);
      $this->makeRange($page);
      $user = $this->security->getUser();
      $this->result = $this->repository->findBooksAndCategory($this->min, $this->max, $user, $category);
    }

    public function getResult() {
      return $this->result;
    }

    public function getNextUrl() {
      return $this->nextUrl;
    }

    public function getPreviousUrl() {
      return $this->previousUrl;
    }

    public function __construct(BookRepository $repository, UrlGeneratorInterface $urlGenerator, Security $security) {
      $this->repository = $repository;
      $this->urlGenerator = $urlGenerator;
      $this->security = $security;
    }
}
