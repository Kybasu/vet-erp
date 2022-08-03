<?php

namespace App\Http\Controllers;

use App\Http\Resources\VariantResource;
use App\Models\Variant;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use Illuminate\Http\JsonResponse;

class VariantController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        return $this->success(VariantResource::collection(Variant::all()));
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
     * @param Variant $variant
     * @return JsonResponse
     */
    public function show(Variant $variant): JsonResponse {
        return $this->success(new VariantResource($variant));
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
