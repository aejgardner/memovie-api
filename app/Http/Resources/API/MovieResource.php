<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "movieTitle" => $this->movieTitle,
            "movieDirector" => $this->movieDirector,
            "movieGenre" => $this->movieGenre,
            "movieCast" => $this->movieCast,
            "user_id" => $this->user_id,
        ];
    }
}
