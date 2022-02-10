<?php

namespace App\Service;

use App\Interface\NewsFetcherInterface;

class NewsAgregatorService
{
    private array $fetchers;

    public function __construct(NewsFetcherInterface ...$fetchers){
        $this->fetchers = $fetchers;
    }

    public function getArticles(int $numberOfArticle): array
    {
        $articles = [];
        foreach($this->fetchers as $fetcher){
            $articles[] = $fetcher->getContent($numberOfArticle);
        }
        return $articles;
    }
}