<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            "id"            => $this->id,
            "title"         => $this->title,
            "subtitle"      => $this->subtitle,
            "card_number"   => $this->card_number,
            "twilight_cost" => $this->twilight_cost,
            "type"          => $this->type,
            "subtype"       => $this->subtype,
            "game_text"     => $this->game_text,
            "lore"          => $this->lore,
            "series"        => SeriesResource::make($this->whenLoaded('series')),
            "rarity"        => CardRarityResource::make($this->whenLoaded('rarity')),
            "culture"       => CardCultureResource::make($this->whenLoaded('culture'))
        ];
    }
}
