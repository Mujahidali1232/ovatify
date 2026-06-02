<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AudioAnalysisService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.cyanite.ai/graphql';

    public function __construct()
    {
        $this->apiKey = config('services.cyanite.api_key');
    }

    /**
     * Analyze audio using Cyanite.ai GraphQL API
     */
    public function analyzeAudio(string $audioUrl)
    {
        $query = '
            mutation {
                libraryTrackCreate(input: {
                    url: "' . $audioUrl . '"
                }) {
                    __typename
                    ... on LibraryTrackCreateSuccess {
                        track {
                            id
                            audioAnalysis {
                                ... on AudioAnalysisV6 {
                                    mood { label val }
                                    genre { label val }
                                    energy { val }
                                }
                            }
                        }
                    }
                    ... on LibraryTrackCreateError {
                        message
                    }
                }
            }
        ';

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'query' => $query,
            ]);

            if ($response->failed()) {
                throw new Exception('Cyanite.ai Analysis Error: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            throw new Exception('Failed to analyze audio: ' . $e->getMessage());
        }
    }
}
