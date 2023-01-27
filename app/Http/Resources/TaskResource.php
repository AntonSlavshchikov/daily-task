<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends Resource
{
    /**
     * Оригинальные значения
     *
     * @param  Request  $request
     * @return array
     */
    public function toAttributes(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'category' => $this->when($this->resource->category, fn() => CategoryTaskResource::make($this->resource->category), null),
            'isReady' => $this->resource->isReady
        ];
    }
}
