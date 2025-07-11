<?php

namespace Alexstericris\AlecrisAiApis\Services;

use Alexstericris\AlecrisAiApis\QueueClient;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    public Response $response;

    public function __construct(#[Config('alecris-ai-apis.gemini.key')] protected string $apiKey,
                                private string                                           $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models',
                                private string                                           $model = 'gemini-2.0-flash',
                                public array                                             $systemPrompts = [])
    {

    }

    public function requestUrl(string $action)
    {
        return $this->baseUrl . '/' . $this->model . ':' . $action;
    }

    /**
     * @param array{contents:array<array{parts:array<array{text:string}>}>} $prompt
     * @return \GuzzleHttp\Promise\PromiseInterface|Response
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function prompt(array $prompt)
    {
        $this->response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $this->apiKey
        ])->post($this->requestUrl('generateContent'), array_merge_recursive($this->systemPrompts, $prompt));
        if ($this->response->status() >= 400) {
            throw new \Exception("Error {$this->response->status()}: " . $this->response->body());
        }
        return $this->response;
    }
}
