<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with(['affected_laptops', 'user', 'phone'])->withCount('affected_laptops')->withTrashed()->get();

        return collect($salaries)->map(function ($item) {
            return [
                'id' => $item->id,
                'full_name' => $item->full_name,
                'cin' => $item->cin,
                'affected_laptops_count' => $item->affected_laptops_count,
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

         Salary::create($data);
        return ['msg' => 'Salary Ajouter !'];

    }

    public function update(Request $request,Salary $salary)
    {
        $data = $request->validate([
            'full_name' => 'required|unique:salaries,full_name,'.$salary->id,
            'cin' => 'required|unique:salaries,cin,'.$salary->id,
            'user_id' => 'sometimes',
            'is_user' => 'sometimes',
            'phone_id' => 'sometimes',
        ]);
        $salary->update($data);
        return ['msg' => 'Salary Modifier !'];
    }

    public function destroy(Request $request, Salary $salary)
    {
        if($request->user()->hasPerm('Delete Salaries')){
            return $salary->secureDelete('affected_laptops', 'ce salarie il a un PC Affecter');
           }else{
            return response(['msg' => 'Unautorized Action !'], 403);
        }
    }

    public function restore($id)
    {
        Salary::onlyTrashed()->where('id', $id)->restore();
        return ['msg' => 'Salary Restaurer !'];
    }
}
