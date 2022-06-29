<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RetoursPcResource extends JsonResource
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
            'full_name' => $this->full_name,
            'returned_laptops_count' => $this->returned_laptops_count,
            'sn' => $this->sn($this->returned_laptops),
            'returned_laptops' => $this->returned_laptops,
            'projets' => $this->projets($this->returned_projets),
            'returned_projets' => $this->returned_projets,
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
