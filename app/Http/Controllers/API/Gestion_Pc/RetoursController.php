<?php

namespace App\Http\Controllers\API\Gestion_Pc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Retour\RetourRequest;
use App\Http\Services\RetourPcService;
use App\Models\Ordinateur;
use Illuminate\Http\Request;

class RetoursController extends Controller
{
    protected $retourPcService;

    public function __construct(RetourPcService $retourPcService)
    {
        $this->retourPcService = $retourPcService;
    }

    public function index()
    {
        return $this->retourPcService->getRetour();
    }

    public function store(RetourRequest $request)
    {
        return $this->retourPcService->CreateRetourPC($request->validated());
    }

    public function update(RetourRequest $request,$salarie_id)
    {
        return $this->retourPcService->UpdateRetourPc($request->validated(),$salarie_id);

    }

    public function destroy(Request $request, $salarie_id)
    {
        return $this->retourPcService->DeleteRetourPc($request->all(),$salarie_id);
    }

}
