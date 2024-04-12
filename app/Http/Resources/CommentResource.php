<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentUserResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
           return [
              'id' => $this->id,
              'content' => $this->content,
              'comment_date' => $this->updated_at,
              'user' => new CommentUserResource($this->whenLoaded('user'))
           ];
        
    }
}
