<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SuccessStoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
					'data' => $this->collection,
					'meta' => [
					   'topic' => 'pets',
					   'author' => 'anonym'
					]
        ];
    }
}
