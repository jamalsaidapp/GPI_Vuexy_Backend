<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projet;
use App\Http\Requests\Projet\CreateRequest;
use App\Http\Requests\Projet\UpdateRequest;


class ProjetController extends Controller
{
    public function index()
    {
        return Projet::all();
    }

    public function store(CreateRequest $request)
    {
        Projet::create($request->validated());
        return ['msg' => 'Projet Ajouter !'];
    }

    public function update(UpdateRequest $request, Projet $projet)
    {
        $projet->update($request->validated());
        return ['msg' => 'Projet Modifier !'];
    }

    public function destroy( Projet $projet)
    {
        $projet->delete();
        return ['msg' => 'Projet Supprimer !'];
    }

    public function restore($id)
    {
        Projet::onlyTrashed()->findOrFail($id)->restore();
        return ['msg' => 'Projet Restaurer !'];
    }
}
