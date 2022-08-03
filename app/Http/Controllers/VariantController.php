<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetVariantRequest;
use App\Http\Resources\VariantResource;
use App\Models\Variant;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use Illuminate\Http\JsonResponse;

class VariantController extends Controller {

    public array $availableRelations = [
        'article',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param GetVariantRequest $request
     * @return JsonResponse
     */
    public function index(GetVariantRequest $request): JsonResponse {
        $options = $request->validated();
        $relations = $this->verifyRelations($options);
        return $this->success(VariantResource::collection(Variant::with($relations)->paginate($options['per_page'] ?? 10, ['*'], 'page', $options['page'] ?? 1)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVariantRequest $request
     * @return JsonResponse
     */
    public function store(StoreVariantRequest $request): JsonResponse {
        $variant = Variant::create($request->validated());
        return $this->resourceCreated(new VariantResource($variant), 'Variant created');
    }

    /**
     * Display the specified resource.
     *
     * @param GetVariantRequest $request
     * @param Variant $variant
     * @return JsonResponse
     */
    public function show(GetVariantRequest $request, Variant $variant): JsonResponse {
        $relations = $this->verifyRelations($request->validated());
        return $this->success(new VariantResource($variant->load($relations)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVariantRequest $request
     * @param Variant $variant
     * @return JsonResponse
     */
    public function update(UpdateVariantRequest $request, Variant $variant): JsonResponse {
        $variant->update($request->validated());
        return $this->resourceUpdated(new VariantResource($variant), 'Variant updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Variant $variant
     * @return JsonResponse
     */
    public function destroy(Variant $variant): JsonResponse {
        $variant->delete();
        return $this->resourceDeleted();
    }
}
