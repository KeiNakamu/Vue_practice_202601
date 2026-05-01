<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => data_get($this->resource, 'message', 'ログイン成功'),
            'token' => data_get($this->resource, 'token'),
            'token_type' => 'Bearer',
            'user' => new UserResource(data_get($this->resource, 'user')),
        ];
    }
}
