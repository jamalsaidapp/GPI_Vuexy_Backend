<?php

namespace App\Http\Controllers\API\Gestion_Pc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Affectation\AffectationRequest;
use App\Http\Services\AffectationPcService;
use App\Models\Affectation;
use Illuminate\Http\Request;

class AffectationsController extends Controller
{
    protected $affectationPcService;

    public function __construct(AffectationPcService $affectationPcService)
    {
        $this->affectationPcService = $affectationPcService;
    }

    public function index()
    {
        return $this->affectationPcService->getAffectations();
    }

    public function show($Salarie_id)
    {
        return $this->affectationPcService->ShowAffectation($Salarie_id);
    }

    public function store(AffectationRequest $request)
    {
        return $this->affectationPcService->CreateAffectation($request->validated());
    }

    public function update(AffectationRequest $request, $salarie_id)
    {
        return $this->affectationPcService->UpdateAffectation($request->validated(),$salarie_id);
    }

    public function destroy(Request $request, $ord_id)
    {
        return $this->affectationPcService->DeleteAffectation($request->only('salarie_id'),$ord_id);
    }

    public function get_SN_Salaries(): array
    {
        return $this->affectationPcService->get_SN_Salaries();
    }
}
