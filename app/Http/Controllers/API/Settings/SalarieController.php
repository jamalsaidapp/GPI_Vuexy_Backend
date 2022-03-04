<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\Salarie;
use Illuminate\Http\Request;

class SalarieController extends Controller
{
    public function index()
    {
        return Salarie::with('ordinateurs')->withCount('ordinateurs')->withTrashed()->get();
    }

    public function store(Request $request)
    {
       $data = $request->validate([
            'full_name' => 'required|unique:salaries,full_name',
        ]);

         Salarie::create($data);
        return ['msg' => 'Salarie Ajouter !'];
    }

    public function update(Request $request,Salarie $salary)
    {
        $data = $request->validate([
            'full_name' => 'required|unique:salaries,full_name,'.$salary->id,
        ]);
        $salary->update($data);
        return ['msg' => 'Salarie Modifier !'];
    }

    public function destroy(Salarie $salary)
    {
        $salary->delete();

        return ['msg' => 'Salarie Supprimer !'];
    }

    public function restore($id)
    {
        Salarie::onlyTrashed()->where('id', $id)->restore();
        return ['msg' => 'Salarie Restaurer !'];
    }
}
