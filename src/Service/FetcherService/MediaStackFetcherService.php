<?php

namespace App\Service\FetcherService;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class MediaStackFetcherService extends AbstractFetcherService
{
    const NAME = "mediastack";
    const JSON_KEY_DATA = ["data"];
    const JSON_KEY_TITLE = ["title"];
    const JSON_KEY_CONTENT = ["description"];
    const JSON_KEY_AUTHOR = ["author"];
    const JSON_KEY_IMAGE = ["image"];

    public function __construct(ContainerBagInterface $container){
        parent::__construct($container,
            self::NAME,
            self::JSON_KEY_DATA,
            self::JSON_KEY_CONTENT,
            self::JSON_KEY_AUTHOR,
            self::JSON_KEY_TITLE,
            self::JSON_KEY_IMAGE
        );
        $this->setUrl($this->getUrl() . "?access_key=" . $this->getApiKey());
    }
}