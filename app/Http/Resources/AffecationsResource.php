<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AffecationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'full_name' => $this->full_name,
            'ordinateurs_count' => $this->ordinateurs_count,
            'sn' => $this->sn($this->ordinateurs),
            'ordinateur' => $this->ordinateurs,
            'projets' => $this->projets($this->projets),
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
        ];
    }

    public function sn($ordinateurs): string
    {
        $series = [];
        $count = count($ordinateurs);
        for ($i = 0; $i < $count; $i++) {
            $series[] = $ordinateurs[$i]->sn;
        }
        return implode(" , ", $series);;
    }

    public function projets($projets): string
    {
        $names = [];
        $count = count($projets);
        for ($i = 0; $i < $count; $i++) {
            $names[] = $projets[$i]->name;
        }
        return implode(" , ", $names);;
    }

}
