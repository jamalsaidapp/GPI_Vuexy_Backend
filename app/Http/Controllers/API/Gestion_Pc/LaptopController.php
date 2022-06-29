<?php

namespace App\Http\Controllers\API\Gestion_Pc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laptop\CreateLaptop;
use App\Http\Requests\Laptop\UpdateLaptop;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        return Laptop::with('salaries')->withTrashed()->get();
    }

    public function store(CreateLaptop $request)
    {
       Laptop::create($request->validated());
        return ['msg' => 'Laptop Ajouter !'];
    }

    public function update(UpdateLaptop $request, Laptop $laptop)
    {
        $laptop->update($request->validated());
        return ['msg' => 'Laptop Modifier !'];
    }

    public function destroy(Request $request, Laptop $laptop){

        if($request->user()->hasPerm('Delete Laptops')){
         return $laptop->secureDelete('salaries', 'PC déja Affecter a un salarie');
        }else{
            return response(['msg' => 'Unautorized Action !'], 403);
        }
    }

    public function restore($id)
    {
        Laptop::onlyTrashed()->findOrFail($id)->restore();
        return ['msg' => 'Laptop Restaurer !'];
    }
}
