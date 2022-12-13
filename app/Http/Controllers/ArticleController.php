<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller {

    public array $availableRelations = [
        'brand',
        'categories',
        'variants',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param GetArticleRequest $request
     * @return JsonResponse
     */
    public function index(GetArticleRequest $request): JsonResponse {
        $options = $request->validated();
        $relations = $this->verifyRelations($options);
        return $this->collectionPaginate(
            ArticleResource::collection(
                Article::with($relations)
                    ->paginate($options['per_page'] ?? 10, ['*'], 'page', $options['page'] ?? 1)
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return JsonResponse
     */
    public function store(StoreArticleRequest $request): JsonResponse {
        $data = $request->validated();
        $data['image'] = $this->uploadImage($request, $data['name']);
        $article = Article::create($data);
        if (isset($data['variants'])) {
            $article->variants()->createMany($data['variants']);
        }
        if (isset($data['categories'])) {
            $article->categories()->attach($data['categories']);
        }
        return $this->resourceCreated(
            new ArticleResource($article->load($this->availableRelations)),
            'Article created'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(GetArticleRequest $request, Article $article): JsonResponse {
        $options = $request->validated();
        $relations = $this->verifyRelations($options);
        return $this->success(new ArticleResource($article->load($relations)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article): JsonResponse {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($request, $data['name']);
        }
        $article->update($data);
        if (isset($data['categories'])) {
            $article->categories()->sync($data['categories']);
        }
        return $this->resourceUpdated(
            new ArticleResource($article->load($this->availableRelations)),
            'Article updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse {
        $article->delete();
        return $this->resourceDeleted();
    }
}
