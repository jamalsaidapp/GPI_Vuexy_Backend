<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\Salarie;
use Illuminate\Http\Request;

class SalarieController extends Controller
{
    public function index()
    {
        $salaries = Salarie::with(['ordinateurs', 'user', 'phone'])->withCount('ordinateurs')->withTrashed()->get();

        return collect($salaries)->map(function ($item) {
            return [
                'id' => $item->id,
                'full_name' => $item->full_name,
                'cin' => $item->cin,
                'ordinateurs_count' => $item->ordinateurs_count,
                'phone_fix' => $item->phone->phonenumber ?? '***',
                'phone_primary' => $item->phone->primary ?? '',
                'is_user' => $item->is_user,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
                'deleted_at' => $item->deleted_at,
                'deleted_by' => $item->deleted_by,
            ];
        });
    }

    public function store(Request $request)
    {
       $data = $request->validate([
            'full_name' => 'required|unique:salaries,full_name',
            'cin' => 'required|unique:salaries,cin',
           'user_id' => 'sometimes',
           'is_user' => 'sometimes',
           'phone_id' => 'sometimes',
       ]);

         Salarie::create($data);
        return ['msg' => 'Salarie Ajouter !'];

    }

    public function update(Request $request,Salarie $salary)
    {
        $data = $request->validate([
            'full_name' => 'required|unique:salaries,full_name,'.$salary->id,
            'cin' => 'required|unique:salaries,cin,'.$salary->id,
            'user_id' => 'sometimes',
            'is_user' => 'sometimes',
            'phone_id' => 'sometimes',
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
