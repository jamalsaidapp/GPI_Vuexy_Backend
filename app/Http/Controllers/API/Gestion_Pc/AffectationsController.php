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

    public function show($salary_id)
    {
        return $this->affectationPcService->ShowAffectation($salary_id);
    }

    public function store(AffectationRequest $request)
    {
        return $this->affectationPcService->CreateAffectation($request->validated());
    }

    public function update(AffectationRequest $request, $salary_id)
    {
        return $this->affectationPcService->UpdateAffectation($request->validated(),$salary_id);
    }

    public function destroy(Request $request, $laptop_id)
    {
        return $this->affectationPcService->DeleteAffectation($request->only('salary_id'),$laptop_id);
    }

    public function restore(AffectationRequest $request)
    {
        return $this->affectationPcService->RestoreAffectation($request->validated());
    }

    public function get_SN_Salaries(): array
    {
        return $this->affectationPcService->get_SN_Salaries();
    }
}
