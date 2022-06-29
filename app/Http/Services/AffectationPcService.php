<?php


namespace App\Http\Services;


use App\Http\Resources\AffecationsResource;
use App\Models\Laptop;
use App\Models\Salary;

class AffectationPcService
{
    public function getAffectations()
    {
        return AffecationsResource::collection(Salary::whereHas('affected_laptops')->with('affected_laptops')->with('affected_projets')->withCount('affected_laptops')->get());
    }

    public function ShowAffectation($salary_id)
    {

        $salary = Salary::findOrFail($salary_id);
        $full_name = $salary->full_name;
        $laptops = $salary->affected_laptops()->get();
        $affected_by = auth()->user()->getUserFullName();

         return compact('full_name', 'affected_laptops','affected_by');
    }

    public function CreateAffectation($data)
    {
        $laptop_id = $data['laptop_id'];
        $salary = Salary::findOrFail($data['salary_id']);
        $salary->affected_laptops()->attach($laptop_id, ['projet_id' => $data['projet_id'],
            'affected_at' => date('Y-m-d', strtotime($data['affected_at'])), 'remarque' => $data['remarque'] ?? null]);
        $this->ChangePCAffecterState($laptop_id, 'Oui');
        return ['msg' => 'Affectation Ajouter !'];

    }

    public function UpdateAffectation($data, $salary_id): array
    {
        $laptop_id = $data['laptop_id'];
//        $old_laptop_id = $data['old_laptop_id'];
        $salary = Salary::findOrFail($salary_id);

        /*if ($laptop_id !== $old_laptop_id) {
           $salary->affected_laptops()->detach([$old_laptop_id]);

            $this->ChangePCAffecterState($old_laptop_id, 'Non');

                $salary->affected_laptops()->attach($laptop_id, [
                    'affected_at' => date('Y-m-d', strtotime($data['affected_at'])),
                    'remarque' => $data['remarque'] ?? null]);

            $this->ChangePCAffecterState($laptop_id, 'Oui');

        } else {
            $salary->affected_laptops()->syncWithoutDetaching([
                $laptop_id => [
                    'affected_at' => date('Y-m-d', strtotime($data['affected_at'])),
                    'remarque' => $data['remarque'] ?? null]
            ]);
        }*/
       $salary->affected_laptops()->syncWithoutDetaching([
            $laptop_id => [
                'affected_at' => date('Y-m-d', strtotime($data['affected_at'])),
                'remarque' => $data['remarque'] ?? null
            ]
        ]);

        return ['msg' => 'Affectation Modifier !'];
    }

    public function DeleteAffectation($data, $laptop_id)
    {

        $salary = Salary::findOrFail($data['salary_id']);
        if ($salary->affected_laptops()->detach($laptop_id))
            $this->ChangePCAffecterState($laptop_id, 'Non');
        return ['msg' => 'Affectation Supprimer !'];
    }

    public function get_SN_Salaries(): array
    {
        $salaries = Salary::withoutTrashed()->get();
        $laptops = Laptop::withoutTrashed()->orderBy('affecter', 'ASC')->get();
        return compact('salaries', 'laptops');
    }

    public function RestoreAffectation($data)
    {
        $this->CreateAffectation($data);
        $salary = Salary::findOrFail($data['salary_id']);
        $salary->returned_laptops()->detach($data['laptop_id']);
        return ['msg' => 'Affectation Restaurer !'];
    }


    private function ChangePCAffecterState($id, $state)
    {
        $laptops = Laptop::findOrFail($id);
        $laptops->update(['affecter' => $state]);
    }

}
