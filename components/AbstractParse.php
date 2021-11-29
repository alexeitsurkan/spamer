<?php namespace app\components;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;

/**
 * Class AbstractParse
 * @package app\modules\citaty\components\parsers
 */
abstract class AbstractParse
{
    abstract public function execute(): void;

    /**
     * @param $url
     * @return DOMXPath
     */
    protected function getXpath($url): DomXPath
    {
        $client = new Client();
        $result = $client->get($url);
        $html   = $result->getBody()->getContents();

        $dom = new DomDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        /* Create a new XPath object */
        return new DomXPath($dom);
    }
}