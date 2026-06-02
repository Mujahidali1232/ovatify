<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\OpenAiService;

try {
    $openAiService = new OpenAiService();
    echo "Testing OpenAI Text Generation...\n";
    $result = $openAiService->generateText("Hello, can you hear me? Respond with 'Yes, OpenAI is working!' if you can.");
    echo "Result: " . $result . "\n";
    
    echo "\nTesting OpenAI Image Generation (DALL-E 3)...\n";
    // Using a very simple prompt to minimize cost/time
    $imageUrl = $openAiService->generateImage("A simple red circle on a white background.");
    echo "Image URL: " . $imageUrl . "\n";
    
    echo "\nSuccess! OpenAI API is working correctly.\n";
} catch (\Exception $e) {
    echo "\nError: " . $e->getMessage() . "\n";
}
