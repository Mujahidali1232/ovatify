<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class OpenAiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Generate text using GPT-4
     */
    public function generateText(string $prompt, string $systemPrompt = 'You are a creative music assistant.')
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if ($response->failed()) {
                throw new Exception('OpenAI Text Generation Error: ' . $response->body());
            }

            return $response->json()['choices'][0]['message']['content'];
        } catch (Exception $e) {
            throw new Exception('Failed to generate text: ' . $e->getMessage());
        }
    }

    /**
     * Generate image using DALL-E 3
     */
    public function generateImage(string $prompt, string $size = '1024x1024')
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->post("{$this->baseUrl}/images/generations", [
                    'model' => 'dall-e-3',
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => $size,
                ]);

            if ($response->failed()) {
                throw new Exception('OpenAI Image Generation Error: ' . $response->body());
            }

            return $response->json()['data'][0]['url'];
        } catch (Exception $e) {
            throw new Exception('Failed to generate image: ' . $e->getMessage());
        }
    }
}
