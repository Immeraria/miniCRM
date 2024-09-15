<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Services\Company\CompanyService;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly CompanyService $service
    )
    {
    }

    /**
     * Summary of index
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Companies/Index', [
            'companies' => Company::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($this->service->createCompany($request->validated())) {
            return response()->json('Компания была успешно добавлена');
        }

        return response()->json('Компания не была добавлена', 500);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        return Inertia::render('Admin/Companies/Edit', [
            'company' => Company::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->service->updateCompany($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        if (Company::destroy($id)) {
            return response()->json('Компания была успешно удалена');
        }

        return response()->json('Не удалось удалить компанию', 500);
    }
}
