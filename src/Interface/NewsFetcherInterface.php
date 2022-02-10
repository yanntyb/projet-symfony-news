<?php

namespace App\Interface;

interface NewsFetcherInterface
{
    public function setUrl(string $url): self;
    public function getUrl(): string;

    public function setApiKey(string $key): self;
    public function getApiKey(): string;

    public function getContent(int $numberOfArticle): array;

}