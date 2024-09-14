<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Summary of index
     * @return mixed
     */
    public function index()
    {
        return Inertia::render('Admin/Companies/Index', [
            'companies' => Company::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        if (Company::create($request->validated())) {
            return response()->json('Компания была успешно добавлена');
        }

        return response()->json('Компания была не была добавлена', 500);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/Companies/Edit', Company::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        if (Company::destroy($id)) {
            return response()->json('Компания была успешно удалена');
        }

        return response()->json('Не удалось удалить компанию', 500);
    }
}
