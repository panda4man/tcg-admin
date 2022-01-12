<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'cards_count' => $this->cards_count,
            'set_number'  => $this->set_number,
            'game'        => GameResource::make($this->whenLoaded('game')),
        ];
    }
}
