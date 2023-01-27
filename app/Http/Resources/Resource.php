<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource
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

        ];
    }

    /**
     * Связи с другими ресурсами
     *
     * @param  Request  $request
     * @return array
     */
    public function toRelationships(Request $request): array
    {
        return [

        ];
    }

    /**
     * Дополнительные данные
     *
     * @param  Request  $request
     * @return array
     */
    public function toAppends(Request $request): array
    {
        return [

        ];
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->getTable(),
            'attributes' => $this->toAttributes($request),
            'relationships' => $this->toRelationships($request),
            'appends' => $this->toAppends($request),
        ];
    }
}
