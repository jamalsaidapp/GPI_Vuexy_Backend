<?php


namespace App\Http\Services;


use App\Http\Resources\RetoursPcResource;
use App\Libs\UtilsFunctions;
use App\Models\Laptop;
use App\Models\Salary;

class RetourPcService
{
    protected $UF;
    public function __construct(UtilsFunctions $utilsFunctions)
    {
        $this->UF = $utilsFunctions;
    }

    public function getRetour()
    {
        return RetoursPcResource::collection(Salary::whereHas('returned_laptops')->with('returned_laptops')->withCount('returned_laptops')->get());
    }

    public function CreateRetourPC($data)
    {
        $laptop_id = $data['laptop_id'];
        $salary = Salary::findOrFail($data['salary_id']);
        $salary->affected_laptops()->detach($laptop_id);
        $salary->returned_laptops()->attach($laptop_id, ['affected_at' => $this->UF->dateFormString($data['affected_at']),
            'rendu_at' => $this->UF->dateFormString(now()), 'projet_id' => $data['projet_id'], 'raison' => $data['raison'] ?? 'Dimission' ]);
        $this->ChangePCAffecterState($laptop_id, 'Non');
        return ['msg' => 'Element Ajouter !' ];
    }

    public function UpdateRetourPc($data, $salary_id)
    {
        $laptop_id = $data['laptop_id'];
        $old_laptop_id = $data['old_laptop_id'];
        $salary = Salary::findOrFail($salary_id);

        if ($laptop_id !== $old_laptop_id) {
            $salary->affected_laptops()->detach([$old_laptop_id]);

            $this->ChangePCAffecterState($old_laptop_id, 'Non');

            $salary->returned_laptops()->attach($laptop_id, [
                'affected_at' => $this->UF->TimeFromString($data['affected_at']),
                'rendu_at' => $this->UF->TimeFromString(now()),
                'remarque' => $data['remarque'] ?? null]);

            $this->ChangePCAffecterState($laptop_id, 'Oui');

        } else {
            $salary->returned_laptops()->syncWithoutDetaching([
                $laptop_id => [
                    'affected_at' => $this->UF->TimeFromString($data['affected_at']),
                    'rendu_at' => $this->UF->TimeFromString(now()),
                    'remarque' => $data['remarque'] ?? null]
            ]);
        }
        return ['msg' => 'Element Modifier !'];
    }

    public function DeleteRetourPc($data, $laptop_id)
    {
        $salary = Salary::findOrFail($data['salary_id']);
        if ($salary->returned_laptops()->detach($laptop_id))
            return ['msg' => 'Element Supprimer !'];
    }

    private function ChangePCAffecterState($id, $state)
    {
        $laptops = Laptop::findOrFail($id);
        $laptops->update(['affecter' => $state]);
    }
}
