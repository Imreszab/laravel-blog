<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
                'comment' => $this->comment,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'id'=> $this->user_id,
                    'name'=> $this->user->name
                ],
                'post' => [
                    'id'=> $this->post_id,
                    'title'=> $this->post->title
                ]
            ]
        ];
    }
}
