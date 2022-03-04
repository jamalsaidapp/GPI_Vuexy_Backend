<?php

namespace App\Http\Controllers\API\Gestion_Pc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ordinateur\CreateOrdinateur;
use App\Http\Requests\Ordinateur\UpdateOrdinateur;
use App\Models\Ordinateur;

class OrdinateurController extends Controller
{
    public function index()
    {
        return Ordinateur::with('salaries')->withTrashed()->get();
    }

    public function store(CreateOrdinateur $request)
    {
       Ordinateur::create($request->validated());
        return ['msg' => 'Ordinateur Ajouter !'];
    }

    public function update(UpdateOrdinateur $request, Ordinateur $ordinateur)
    {
       $ordinateur->update($request->validated());
        return ['msg' => 'Ordinateur Modifier !'];
    }

    public function destroy( Ordinateur $ordinateur)
    {
       $ordinateur->delete();
        return ['msg' => 'Ordinateur Supprimer !'];
    }

    public function restore($id)
    {
        Ordinateur::onlyTrashed()->findOrFail($id)->restore();
        return ['msg' => 'Ordinateur Restaurer !'];
    }
}
