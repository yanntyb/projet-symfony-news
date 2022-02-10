<?php

namespace App\Controller;

use App\Service\NewsAgregatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/", "news_")]
class NewsController extends AbstractController
{
    #[Route("/", "liste")]
    public function home(NewsAgregatorService $agregatorService){
        $fetched = $agregatorService->getArticles(10);
        return $this->render("news/all.html.twig", [
            "fetched" => $fetched,
        ]);
    }
}