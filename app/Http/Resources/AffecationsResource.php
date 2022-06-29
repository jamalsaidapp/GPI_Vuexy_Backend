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
            'affected_laptops_count' => $this->affected_laptops_count,
            'sn' => $this->sn($this->affected_laptops),
            'affected_laptops' => $this->affected_laptops,
            'projets' => $this->projets($this->affected_projets),
            'affected_projets' => $this->affected_projets,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
        ];
    }

    public function sn($laptops): string
    {
        $series = [];
        $count = count($laptops);
        for ($i = 0; $i < $count; $i++) {
            $series[] = $laptops[$i]->sn;
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
