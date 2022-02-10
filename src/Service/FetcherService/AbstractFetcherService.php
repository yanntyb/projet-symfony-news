<?php

namespace App\Service\FetcherService;

use App\Interface\NewsFetcherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AbstractFetcherService implements NewsFetcherInterface
{
    private string $name;

    private string $url;
    private string $apiKey;

    private array $jsonKey_data;
    private array $data_content_keys;
    private array $data_author_keys;
    private array $data_title_keys;
    private array $data_image_keys;

    public function __construct(ParameterBagInterface $container, string $name, array $data_keys, array $data_content_keys, array $data_author_keys, array $data_title_keys, array $data_image_keys){
        $this->name = $name;
        $this->setUrl($container->get("api")[$this->name]["url"]);
        $this->setApiKey($container->get("api")[$this->name]["key"]);
        $this->setJsonKeyData($data_keys);
        $this->setDataAuthorKeys($data_author_keys);
        $this->setDataContentKeys($data_content_keys);
        $this->setDataTitleKeys($data_title_keys);
        $this->setDataImageKeys($data_image_keys);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self{
        $this->url = $url;
        return $this;
    }
    /**
     * @return string
     */
    final public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $key
     * @return $this
     */
    final public function setApiKey(string $key): AbstractFetcherService
    {
        $this->apiKey = $key;
        return $this;
    }
    /**
     * @return string
     */
    final public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param array $keys
     * @return void
     */
    final public function setJsonKeyData(array $keys){
        $this->jsonKey_data = $keys;
    }
    /**
     * @return array
     */
    final public function getJsonKeyData() : array{
        return $this->jsonKey_data;
    }

    /**
     * @return array
     */
    public function getDataContentKeys(): array
    {
        return $this->data_content_keys;
    }
    /**
     * @param array $data_content_keys
     * @return self
     */
    public function setDataContentKeys(array $data_content_keys): self
    {
        $this->data_content_keys = $data_content_keys;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataAuthorKeys(): array
    {
        return $this->data_author_keys;
    }
    /**
     * @param array $data_author_keys
     * @return self
     */
    public function setDataAuthorKeys(array $data_author_keys): self
    {
        $this->data_author_keys = $data_author_keys;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataTitleKeys(): array
    {
        return $this->data_title_keys;
    }
    /**
     * @param array $data_title_keys
     * @return self
     */
    public function setDataTitleKeys(array $data_title_keys): self
    {
        $this->data_title_keys = $data_title_keys;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataImageKeys(): array
    {
        return $this->data_image_keys;
    }
    /**
     * @param array $data_image_keys
     * @return self
     */
    public function setDataImageKeys(array $data_image_keys): self
    {
        $this->data_image_keys = $data_image_keys;
        return $this;
    }

    /**
     * Return articles data array
     * @param int $numberOfArticle
     * @return array
     */
    public function getContent(int $numberOfArticle): array
    {
        //Get articles
        $datas = $this->parseJsonBasedOnKeys(json_decode(file_get_contents($this->getUrl())), $this->getJsonKeyData());
        $datas = array_splice($datas, 0, $numberOfArticle);

        $news = [];
        foreach ($datas as $data){
            $title = $this->parseJsonBasedOnKeys($data, $this->getDataTitleKeys());
            $content = $this->parseJsonBasedOnKeys($data, $this->getDataContentKeys());
            $author = $this->parseJsonBasedOnKeys($data, $this->getDataAuthorKeys());
            $image = $this->parseJsonBasedOnKeys($data, $this->getDataImageKeys());
            if (!filter_var($image, FILTER_VALIDATE_URL)) {
                $image = null;
            }

            $news[] = [
                "title" => $title,
                "content" => $content,
                "author" => $author,
                "image" => $image
            ];
        }
        return $news;
    }

    /**
     * Parse json to extract data
     * @param mixed $data
     * @param array $keys
     * @return mixed|null
     */
    final public function parseJsonBasedOnKeys(mixed $data, array $keys): mixed
    {
        foreach($keys as $index){
            if(is_int($index)){
                if(isset($data[$index])){
                    $data = $data[$index];
                }
                else{
                    $data = null;
                }
            }
            else{
                if(isset($data->$index)){
                    $data = $data->$index;
                }
                else{
                    $data = null;
                }
            }
        }
        return $data;
    }
}