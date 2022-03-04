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
            'ordinateurs_count' => $this->ordinateurs_rendus_count,
            'sn' => $this->sn($this->ordinateurs_rendus),
            'ordinateur' => $this->ordinateurs_rendus,

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
}
