<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SunoApiService
{
    protected $client;
    protected $baseUrl = 'https://api.sunoapi.org'; // Adjust to actual Suno API endpoint
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.suno.api_key');
        $this->client = new Client();
    }

    /**
     * Generate music based on prompt
     */
    public function generateMusic(
        string $prompt,
        string $style,
        string $title,
        ?string $personaId = null,
        ?string $gender = 'm'
    ) {
        try {
            $response = $this->client->post('https://api.sunoapi.org/api/v1/generate', [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'customMode' => false,
                    'instrumental' => false,
                    'model' => 'V4_5ALL',
                    'callBackUrl' => 'https://ovatify.edmsolutions.org/api/creator/suno/callback',

                    'prompt' => $prompt,
                    'style' => $style,
                    'title' => $title,
                    'personaId' => $personaId ?? 'persona_123',
                    'negativeTags' => 'Heavy Metal, Upbeat Drums',
                    'vocalGender' => $gender ?? 'm',

                    'styleWeight' => 0.65,
                    'weirdnessConstraint' => 0.65,
                    'audioWeight' => 0.65,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (GuzzleException $e) {
            throw new \Exception('Failed to generate music: ' . $e->getMessage());
        }
    }

    /**
     * Get generation status
     */
    public function getGenerationStatus($requestId)
    {
        try {
            $response = $this->client->get("https://api.sunoapi.org/api/v1/generate/record-info?taskId={$requestId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to fetch generation status: ' . $e->getMessage());
        }
    }

}