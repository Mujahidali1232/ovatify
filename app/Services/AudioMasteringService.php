<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AudioMasteringService
{
    protected $apiKey;
    protected $appSecret;
    protected $baseUrl = 'https://api.dolby.com';

    public function __construct()
    {
        $this->apiKey = config('services.dolby.api_key');
        $this->appSecret = config('services.dolby.app_secret');
    }

    /**
     * Start an audio mastering job
     */
    public function startMastering(string $inputUrl, string $outputUrl, string $profile = 'balanced')
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->post("{$this->baseUrl}/media/enhance", [
                    'input' => $inputUrl,
                    'output' => $outputUrl,
                    'content' => [
                        'type' => 'music',
                    ],
                    'action' => [
                        'profile' => $profile,
                    ],
                ]);

            if ($response->failed()) {
                throw new Exception('Dolby.io Mastering Error: ' . $response->body());
            }

            return $response->json()['job_id'];
        } catch (Exception $e) {
            throw new Exception('Failed to start mastering: ' . $e->getMessage());
        }
    }

    /**
     * Check mastering job status
     */
    public function getJobStatus(string $jobId)
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->get("{$this->baseUrl}/media/enhance", [
                    'job_id' => $jobId,
                ]);

            if ($response->failed()) {
                throw new Exception('Dolby.io Status Error: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch job status: ' . $e->getMessage());
        }
    }
}
