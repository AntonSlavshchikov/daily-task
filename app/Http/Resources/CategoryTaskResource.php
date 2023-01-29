<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTaskResource extends Resource
{
    /**
     * Оригинальные значения
     *
     * @param Request $request
     * @return array
     */
    public function toAttributes(Request $request): array
    {
        return [
            'title' => $this->resource->title,
        ];
    }
}
