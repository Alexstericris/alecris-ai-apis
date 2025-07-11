<?php

namespace Alexstericris\AlecrisAiApis\Services;

use DOMDocument;
use DOMXPath;
use Parsedown;

class ApiResponseParser
{
    public Parsedown $parsedown;

    public function __construct()
    {
        $this->parsedown = app(Parsedown::class);
    }

    public function parseTailwindClass(string $text)
    {
        $parsed = $this->parsedown->text($text);
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($parsed);
        libxml_clear_errors();

        $xpath = new DOMXPath($doc);
        $codeNodes = $xpath->query('//code');
        $codeDom = new DOMDocument;
        libxml_use_internal_errors(true);
        $codeDom->loadHTML($codeNodes->item(0)->textContent);
        $codeXpath = new DOMXPath($codeDom);
        $classElems = $codeXpath->query('//*[@class]');

        return $classElems->item(0)->getAttribute('class');
    }
}
