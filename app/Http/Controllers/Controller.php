<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponser;

    public array $availableRelations = [];

    protected function verifyRelations(array $options): array {
        $relations = [];
        foreach ($options as $relation => $value) {
            if ($value && in_array($relation, $this->availableRelations, true) ) {
                $relations[] = $relation;
            }
        }
        return $relations;
    }

    protected function uploadImage(Request $request, string $name): string {
        $file = $request->file('image');
        $extension = $file->extension();
        $res = 'photoA.jpg';
        if ($_ENV['APP_ENV'] === 'production') {
            $res = $_ENV['AWS_BUCKET_URL'] . '/' . $file->storePubliclyAs('', $name . '.' . $extension, 's3');
        }
        return $res;
    }
}
