<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends Resource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'email' => $this->resource->email,
        ];
    }
}
