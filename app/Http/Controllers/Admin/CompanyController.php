<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\CompanyService;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService
    ) {}

    public function index()
    {
        $companies = Company::with('reviewPage')
            ->withCount(['reviews', 'positiveReviews', 'negativeReviews'])
            ->latest()
            ->paginate(15);

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->companyService->create($request->validated());

        return redirect()
            ->route('admin.companies.show', $company)
            ->with('success', 'Empresa criada com sucesso! Página de avaliação gerada.');
    }

    public function show(Company $company)
    {
        $company->load(['reviewPage', 'reviews' => function ($query) {
            $query->latest()->limit(10);
        }]);

        $statistics = $this->companyService->getStatistics($company);

        return view('admin.companies.show', compact('company', 'statistics'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->companyService->update($company, $request->validated());

        return redirect()
            ->route('admin.companies.show', $company)
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Company $company)
    {
        $this->companyService->delete($company);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Empresa excluída com sucesso!');
    }
}





