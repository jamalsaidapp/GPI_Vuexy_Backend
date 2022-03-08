<?php


namespace App\Http\Services;


use App\Http\Resources\AffecationsResource;
use App\Models\Ordinateur;
use App\Models\Salarie;
use App\Models\User;

class AffectationPcService
{
    public function getAffectations(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AffecationsResource::collection(Salarie::whereHas('ordinateurs')->with('ordinateurs')->withCount('ordinateurs')->get());

    }

    public function ShowAffectation($Salarie_id)
    {

        $salarie = Salarie::findOrFail($Salarie_id);
        $full_name = $salarie->full_name;
        $ordinateurs = $salarie->ordinateurs()->get();
        $affected_by = auth()->user()->getUserFullName();

         return compact('full_name', 'ordinateurs','affected_by');
    }

    public function CreateAffectation($data): array
    {
        $ordinateur_id = $data['ordinateur_id'];
        $salarie = Salarie::findOrFail($data['salarie_id']);
        $salarie->ordinateurs()->attach($ordinateur_id, ['affected_at' => date('Y-m-d', strtotime($data['affected_at'])), 'remarque' => $data['remarque'] ?? null]);
        $this->ChangePCAffecterState($ordinateur_id, 'Oui');
        return ['msg' => 'Affectation Ajouter !'];
    }

    public function UpdateAffectation($data, $salarie_id)
    {
        $ordinateur_id = $data['ordinateur_id'];
        $old_ordinateur_id = $data['old_ordinateur_id'];
        $salarie = Salarie::findOrFail($salarie_id);

        if ($ordinateur_id !== $old_ordinateur_id) {
           $salarie->ordinateurs()->detach([$old_ordinateur_id]);

            $this->ChangePCAffecterState($old_ordinateur_id, 'Non');

                $salarie->ordinateurs()->attach($ordinateur_id, [
                    'affected_at' => date('Y-m-d', strtotime($data['affected_at'])),
                    'remarque' => $data['remarque'] ?? null]);

            $this->ChangePCAffecterState($ordinateur_id, 'Oui');

        } else {
            $salarie->ordinateurs()->syncWithoutDetaching([
                $ordinateur_id => [
                    'affected_at' => date('Y-m-d', strtotime($data['affected_at'])),
                    'remarque' => $data['remarque'] ?? null]
            ]);
        }
        return ['msg' => 'Affectation Modifier !'];
    }

    public function DeleteAffectation($data, $ord_id): array
    {
        $salarie = Salarie::findOrFail($data['salarie_id']);
        if ($salarie->ordinateurs()->detach($ord_id))
            $this->ChangePCAffecterState($ord_id, 'Non');

        return ['msg' => 'Affectation Supprimer !'];
    }

    public function get_SN_Salaries(): array
    {
        $salaries = Salarie::withoutTrashed()->get();
        $ordinateurs = Ordinateur::withoutTrashed()->orderBy('affecter', 'ASC')->get();
        return compact('salaries', 'ordinateurs');
    }

    private function ChangePCAffecterState($id, $state)
    {
        $ordinateur = Ordinateur::findOrFail($id);
        $ordinateur->update(['affecter' => $state]);
    }

}
