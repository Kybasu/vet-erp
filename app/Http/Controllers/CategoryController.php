<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {

    public array $availableRelations = [
        'articles',
        'variants'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param GetCategoryRequest $request
     * @return JsonResponse
     */
    public function index(GetCategoryRequest $request): JsonResponse {
        $options = $request->validated();
        $relations = $this->verifyRelations($options);
        return $this->success(
            CategoryResource::collection(
                Category::with($relations)
                    ->paginate($options['per_page'] ?? 10, ['*'], 'page', $options['page'] ?? 1)
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse {
        $category = Category::create($request->validated());
        return $this->resourceCreated(new CategoryResource($category), 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param GetCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function show(GetCategoryRequest $request, Category $category): JsonResponse {
        $relations = $this->verifyRelations($request->validated());
        return $this->success(new CategoryResource($category->load($relations)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse {
        $category->update($request->validated());
        return $this->resourceUpdated(new CategoryResource($category), 'Category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse {
        $category->delete();
        return $this->resourceDeleted();
    }
}
