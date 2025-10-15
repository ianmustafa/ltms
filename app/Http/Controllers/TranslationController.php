<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Repositories\TranslationRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    /**
     * Inject dependencies on class construction.
     *
     * @param \App\Repositories\TranslationRepository $repo
     */
    public function __construct(protected TranslationRepository $repo)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'tags' => $request->input('tags', []),
        ];

        $translations = $this->repo->getTranslations($filters)->toResourceCollection();

        return new JsonResponse($translations, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $request)
    {
        $data = $request->only('locale', 'key', 'value', 'tags');

        $translation = $this->repo->createTranslation($data);

        return new JsonResponse($translation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $translation = $this->repo->findTranslation($id);

        if (!$translation) {
            return new JsonResponse(['message' => 'Translation not found'], 404);
        }

        return new JsonResponse($translation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $request, int $id)
    {
        $translation = $this->repo->findTranslation($id);

        if (!$translation) {
            return new JsonResponse(['message' => 'Translation not found'], 404);
        }

        $data = array_filter($request->only('key', 'value'));
        if ($request->has('tags')) {
            $data['tags'] = $request->tags;
        }

        $updatedTranslation = $this->repo->updateTranslation($translation, $data);

        return new JsonResponse($updatedTranslation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $translation = $this->repo->findTranslation($id);

        if (!$translation) {
            return new JsonResponse(['message' => 'Translation not found'], 404);
        }

        $this->repo->deleteTranslation($translation);

        return new JsonResponse(['message' => 'Translation deleted successfully']);
    }
    /**
     * Export translations for a specific locale as JSON.
     */
    public function export(string $localeCode)
    {
        $translations = $this->repo->exportTranslations($localeCode);

        return new JsonResponse($translations, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
