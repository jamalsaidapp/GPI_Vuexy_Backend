<?php


namespace App\Http\Services;


use App\Http\Resources\RetoursPcResource;
use App\Libs\UtilsFunctions;
use App\Models\Ordinateur;
use App\Models\Salarie;

class RetourPcService
{
    protected $UF;
    public function __construct(UtilsFunctions $utilsFunctions)
    {
        $this->UF = $utilsFunctions;
    }

    public function getRetour()
    {
        return RetoursPcResource::collection(Salarie::whereHas('ordinateurs_rendus')->with('ordinateurs_rendus')->withCount('ordinateurs_rendus')->get());
    }

    public function CreateRetourPC($data)
    {
        $ordinateur_id = $data['ordinateur_id'];
        $salarie = Salarie::findOrFail($data['salarie_id']);
        if ($salarie->ordinateurs()->detach($ordinateur_id))
        $salarie->ordinateurs_rendus()->attach($ordinateur_id, ['affected_at' => $this->UF->TimeFromString($data['affected_at']),
            'rendu_at' => $this->UF->TimeFromString(now())]);
        $this->ChangePCAffecterState($ordinateur_id, 'Non');
        return ['msg' => 'Element Ajouter !'];
    }

    public function UpdateRetourPc($data, $salarie_id)
    {
        $ordinateur_id = $data['ordinateur_id'];
        $old_ordinateur_id = $data['old_ordinateur_id'];
        $salarie = Salarie::findOrFail($salarie_id);

        if ($ordinateur_id !== $old_ordinateur_id) {
            $salarie->ordinateurs()->detach([$old_ordinateur_id]);

            $this->ChangePCAffecterState($old_ordinateur_id, 'Non');

            $salarie->ordinateurs_rendus()->attach($ordinateur_id, [
                'affected_at' => $this->UF->TimeFromString($data['affected_at']),
                'rendu_at' => $this->UF->TimeFromString(now()),
                'remarque' => $data['remarque'] ?? null]);

            $this->ChangePCAffecterState($ordinateur_id, 'Oui');

        } else {
            $salarie->ordinateurs_rendus()->syncWithoutDetaching([
                $ordinateur_id => [
                    'affected_at' => $this->UF->TimeFromString($data['affected_at']),
                    'rendu_at' => $this->UF->TimeFromString(now()),
                    'remarque' => $data['remarque'] ?? null]
            ]);
        }
        return ['msg' => 'Element Modifier !'];
    }

    public function DeleteRetourPc($data, $salarie_id)
    {
        $salarie = Salarie::findOrFail($salarie_id);
        if ($salarie->ordinateurs_rendus()->detach($data['ordinateur_id']))
            return ['msg' => 'Element Supprimer !'];
    }

    private function ChangePCAffecterState($id, $state)
    {
        $ordinateur = Ordinateur::findOrFail($id);
        $ordinateur->update(['affecter' => $state]);
    }
}
