<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends Resource
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
            'isReady' => $this->resource->isReady,
            'user_id' => $this->resource->user_id,
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'category' => $this->when(
                $this->resource->category,
                fn() => CategoryTaskResource::make($this->resource->category),
                null
            ),
        ];
    }

    public function toAppends(Request $request): array
    {
        return [
            'date' => $this->resource->created_at->format('d.m.Y'),
        ];
    }
}
