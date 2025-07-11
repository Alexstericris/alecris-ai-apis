<?php

namespace Alexstericris\AlecrisAiApis\Tests;

use Alexstericris\AlecrisAiApis\Services\GeminiService;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Cache;
use Parsedown;

class GeminiTest extends TestCase
{
    public GeminiService $geminiService;
    public Parsedown $parsedown;

    public function setUp(): void
    {
        parent::setUp();
        $this->geminiService = app(GeminiService::class);
        $this->parsedown = app(Parsedown::class);
    }

    public function testGemini()
    {
        $candidates = Cache::get('testGemini');
        if (!$candidates) {
            $response = $this->geminiService->prompt([
                'contents' => [
                    [
                        "role" => "user",
                        'parts' => [
                            ['text' => 'Give me the tailwind classes for a well designed blue button']
                        ]
                    ]
                ]
            ]);
            $candidates = $response->json('candidates');
            Cache::put('testGemini', $candidates);
        }
        foreach ($candidates as $candidate) {
            foreach ($candidate['content']['parts'] as $part) {
                $parsed = $this->parsedown->text($part['text']);
                $doc = new DOMDocument();
                libxml_use_internal_errors(true);
                $doc->loadHTML($parsed);
                libxml_clear_errors();

                $xpath = new DOMXPath($doc);
                $codeNodes = $xpath->query('//code');
                self::assertTrue($codeNodes->length > 0);
                $codeDom = new DOMDocument();
                libxml_use_internal_errors(true);
                $codeDom->loadHTML($codeNodes->item(0)->textContent);
                $codeXpath = new DOMXPath($codeDom);
                $classElems = $codeXpath->query('//*[@class]');
                self::assertTrue(str_contains($classElems->item(0)->getAttribute('class'), 'bg-blue'));
            }
        }
    }
}
