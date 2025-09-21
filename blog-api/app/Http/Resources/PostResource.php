<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> (string) $this->id,
            'attributes' => [
                'title' => $this->title,
                'content' => $this->content,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'id' => $this->user_id,
                    'user_name' => $this->user->name
                ],
                'comments' => CommentResource::collection($this->comments)
            ]
        ];
    }
}
