<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\AiTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\OpenAiService;
use App\Services\AudioMasteringService;
use App\Services\AudioAnalysisService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;

class AiToolController extends Controller
{
    protected $openAiService;
    protected $masteringService;
    protected $analysisService;

    public function __construct(
        OpenAiService $openAiService,
        AudioMasteringService $masteringService,
        AudioAnalysisService $analysisService
    ) {
        $this->openAiService = $openAiService;
        $this->masteringService = $masteringService;
        $this->analysisService = $analysisService;
    }

    /**
     * Generate lyrics using GPT-4
     */
    public function generateLyrics(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string',
            'style' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $prompt = $request->prompt;
            if ($request->style) {
                $prompt .= " in the style of {$request->style}";
            }

            $lyrics = $this->openAiService->generateText($prompt, 'You are a professional songwriter. Generate creative lyrics.');

            return response()->json([
                'success' => true,
                'data' => [
                    'lyrics' => $lyrics
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Generate album cover using DALL-E 3
     */
    public function generateAlbumCover(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $imageUrl = $this->openAiService->generateImage($request->prompt);

            return response()->json([
                'success' => true,
                'data' => [
                    'image_url' => $imageUrl
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Start audio mastering job (Dolby.io)
     */
    public function startMastering(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_url' => 'required|url',
            'output_url' => 'required|string',
            'profile' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $jobId = $this->masteringService->startMastering(
                $request->input_url,
                $request->output_url,
                $request->profile ?? 'balanced'
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'job_id' => $jobId
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Analyze audio (Cyanite.ai)
     */
    public function analyzeAudio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $analysis = $this->analysisService->analyzeAudio($request->audio_url);

            return response()->json([
                'success' => true,
                'data' => $analysis
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    //  Creative Workspace AI tools (Figma — home screen 8 tools)
    //
    //  All 6 endpoints below follow the same async pattern:
    //    1) POST creates an `ai_tasks` row in `pending` state, returns task_id.
    //    2) GET /status/{taskId} polls for `completed` + a `result` payload.
    //    3) TODO: a real worker processes pending tasks and fills `result`.
    //       For now they short-circuit to `completed` with a placeholder result
    //       so the Flutter dev can wire UI end-to-end.
    // =========================================================================

    /** Vocal Enhancer — generate or enhance vocals (Figma: Vocal Enhancer). */
    public function vocalEnhancer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'mode' => 'nullable|in:generate_new,enhance_existing',
            'vocal_style' => 'nullable|string|max:500',
            'vocal_type' => 'nullable|in:male,female,duet',
            'genre_style' => 'nullable|string|max:64',
            'vocal_mood' => 'nullable|string|max:64',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'vocal-enhancer', [
            'applied_changes' => "Applied {$request->input('genre_style', 'R&B')} {$request->input('vocal_type', 'Female')} Vocal with {$request->input('vocal_mood', 'Energetic')} Mood.",
        ]);
    }

    /** Melody Generator — generate a melody (Figma: Melody Generator). */
    public function melodyGenerator(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'genre' => 'nullable|string|max:64',
            'melody_style' => 'nullable|string|max:64',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'melody-generator', [
            'message' => 'Melody added to your project successfully.',
        ]);
    }

    /** Hook Generator (Figma: Hook Generator). */
    public function hookGenerator(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'genre' => 'nullable|string|max:64',
            'mood' => 'nullable|string|max:64',
            'optional_ideas' => 'nullable|string|max:1000',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'hook-generator', [
            'message' => 'Hooks added to your project successfully.',
        ]);
    }

    /** Genre Matcher (Figma: Genre Matcher). Returns ranked genre percentages. */
    public function genreMatcher(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'genre-matcher', [
            'matches' => [
                ['genre' => 'POP', 'confidence' => 85],
                ['genre' => 'RnB', 'confidence' => 50],
                ['genre' => 'Lo-Fi', 'confidence' => 10],
            ],
        ]);
    }

    /** Mood Analyzer (Figma: Mood Analyzer). Returns primary + secondary moods. */
    public function moodAnalyzer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'mood-analyzer', [
            'primary_mood' => ['Energetic', 'Uplifting'],
            'secondary_mood' => ['Energetic', 'Uplifting'],
        ]);
    }

    /** AI Mixing Assistant (Figma: AI mixing Assistant). Returns suggestion list. */
    public function mixingAssistant(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'mixing-assistant', [
            'suggestions' => [
                'Increase Volume by +2db',
                'Increase Volume by +2db',
                'Increase Volume by +2db',
                'Increase Volume by +2db',
            ],
        ]);
    }

    /** Mastering Tool (Figma: Mastering Tool). Returns suggestion checkboxes. */
    public function masteringTool(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        return $this->createTask($request, 'mastering-tool', [
            'suggestions' => [
                ['key' => 'increase_loudness', 'label' => 'Increase Overall Loudness'],
                ['key' => 'enhance_clarity', 'label' => 'Enhance Clarity'],
                ['key' => 'balance_low_end', 'label' => 'Balance Low-End'],
                ['key' => 'stereo_enhancement', 'label' => 'Stereo Enhancement'],
            ],
        ]);
    }

    /** Lyric Generator — async-task wrapper around OpenAI (Figma: Lyric Generator). */
    public function lyricGenerator(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'mood' => 'nullable|string|max:64',
            'theme' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:64',
            'optional_ideas' => 'nullable|string|max:1000',
            'creator_session_id' => 'nullable|exists:creator_sessions,id',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $result = ['lyrics' => null];
        try {
            $prompt = 'Write song lyrics';
            if ($request->theme) $prompt .= ' about ' . $request->theme;
            if ($request->mood) $prompt .= ', mood: ' . $request->mood;
            if ($request->genre) $prompt .= ', genre: ' . $request->genre;
            if ($request->optional_ideas) $prompt .= '. Ideas: ' . $request->optional_ideas;
            $result['lyrics'] = $this->openAiService->generateText($prompt, 'You are a professional songwriter. Generate creative lyrics.');
        } catch (Exception $e) {
            // fall through — task lands as failed; client can re-run
            return $this->createTask($request, 'lyric-generator', null, 'failed', $e->getMessage());
        }

        return $this->createTask($request, 'lyric-generator', $result);
    }

    /**
     * Poll any AI task by id.
     */
    public function taskStatus(Request $request, int $taskId): JsonResponse
    {
        $task = AiTask::where('user_id', $request->user()->id)->find($taskId);
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $this->formatTask($task),
        ]);
    }

    /**
     * List the current user's AI tasks. ?tool= filters by a specific tool.
     */
    public function tasksIndex(Request $request): JsonResponse
    {
        $q = AiTask::where('user_id', $request->user()->id)->orderByDesc('created_at');
        if ($request->query('tool')) {
            $q->where('tool', $request->query('tool'));
        }
        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
        $paginator = $q->paginate($perPage);

        return response()->json([
            'success' => true,
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'data' => collect($paginator->items())->map(fn ($t) => $this->formatTask($t)),
        ]);
    }

    // ---- internal helpers ----

    /**
     * Create an AiTask row, optionally storing the uploaded audio.
     *
     * TODO: replace short-circuit (status='completed' with placeholder result)
     * with real provider integration + a queued job that fills `result` async.
     */
    protected function createTask(Request $request, string $tool, ?array $result, string $status = 'completed', ?string $errorMessage = null): JsonResponse
    {
        $sourcePath = null;
        if ($request->hasFile('audio')) {
            $sourcePath = $request->file('audio')->store('ai_inputs', 'public');
        }

        $task = AiTask::create([
            'user_id' => $request->user()->id,
            'tool' => $tool,
            'status' => $status,
            'input' => $request->except(['audio']),
            'result' => $result,
            'source_audio' => $sourcePath,
            'creator_session_id' => $request->input('creator_session_id'),
            'completed_at' => $status === 'completed' ? now() : null,
            'error_message' => $errorMessage,
        ]);

        return response()->json([
            'success' => $status !== 'failed',
            'data' => $this->formatTask($task),
        ], $status === 'failed' ? 500 : 201);
    }

    protected function formatTask(AiTask $task): array
    {
        return [
            'id' => $task->id,
            'tool' => $task->tool,
            'status' => $task->status,
            'input' => $task->input,
            'result' => $task->result,
            'source_audio' => $task->source_audio ? url(Storage::url($task->source_audio)) : null,
            'output_file' => $task->output_file ? url(Storage::url($task->output_file)) : null,
            'error_message' => $task->error_message,
            'creator_session_id' => $task->creator_session_id,
            'completed_at' => $task->completed_at?->toDateTimeString(),
            'created_at' => $task->created_at?->toDateTimeString(),
        ];
    }

    protected function validationError(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $errors,
        ], 422);
    }
}
