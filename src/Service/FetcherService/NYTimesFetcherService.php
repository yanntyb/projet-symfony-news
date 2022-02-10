<?php

namespace App\Service\FetcherService;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class NYTimesFetcherService extends AbstractFetcherService
{
    const NAME = "ny";
    const JSON_KEY_DATA = ["response", "docs"];
    const JSON_KEY_TITLE = ["abstract"];
    const JSON_KEY_CONTENT = ["lead_paragraph"];
    const JSON_KEY_AUTHOR = ["byline", "person", 0, "lastname"];
    const JSON_KEY_IMAGE = ["multimedia", 0, "url"];

    public function __construct(ContainerBagInterface $container){
        parent::__construct($container,
            self::NAME,
            self::JSON_KEY_DATA,
            self::JSON_KEY_CONTENT,
            self::JSON_KEY_AUTHOR,
            self::JSON_KEY_TITLE,
            self::JSON_KEY_IMAGE
        );
        $this->setUrl($this->getUrl() . ".json?api-key=" . $this->getApiKey());
    }

}