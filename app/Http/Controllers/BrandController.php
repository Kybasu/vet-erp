<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Article;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller {

    public array $availableRelations = [
        'articles',
        'variants'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param GetBrandRequest $request
     * @return JsonResponse
     */
    public function index(GetBrandRequest $request): JsonResponse {
        $options = $request->validated();
        $relations = $this->verifyRelations($options);
        return $this->success(
            BrandResource::collection(Brand::with($relations)
                ->paginate($options['per_page'] ?? 10, ['*'], 'page', $options['page'] ?? 1)
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return JsonResponse
     */
    public function store(StoreBrandRequest $request): JsonResponse {
        $article = Article::create($request->validated());
        return $this->resourceCreated(new BrandResource($article), 'Brand created');
    }

    /**
     * Display the specified resource.
     *
     * @param GetBrandRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function show(GetBrandRequest $request, Brand $brand): JsonResponse {
        $relations = $this->verifyRelations($request->validated());
        return $this->success(new BrandResource($brand->load($relations)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand): JsonResponse {
        $brand->update($request->validated());
        return $this->resourceUpdated(new BrandResource($brand), 'Brand updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function destroy(Brand $brand): JsonResponse {
        $brand->delete();
        return $this->resourceDeleted();
    }
}
