<?php

namespace App\Http\Controllers\Api\Invoke;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetTemplateResource;
use App\Models\Entry;

class GetTemplate extends Controller
{
    public function __invoke()
    {
        $entries = Entry::query()
            ->select(['id', 'is_template', 'template_name'])
            ->where('is_template', true)
            ->get();

        return GetTemplateResource::collection($entries);
    }
}
