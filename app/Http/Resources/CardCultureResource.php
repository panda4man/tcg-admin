<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardCultureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'game'           => GameResource::make($this->whenLoaded('game')),
            'card_alignment' => CardAlignmentResource::make($this->whenLoaded('alignment'))
        ];
    }
}
