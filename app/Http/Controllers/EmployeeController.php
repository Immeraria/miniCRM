<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Employees/Index', [
            'employees' => Employee::with([
                'company' => function ($query) {
                    $query->select('id', 'name');
                },
            ])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Employees/Create', [
            'companies' => Company::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($this->service->createEmployee($request->validated())) {
            return response()->json('Сотрудник был успешно добавлен');
        }

        return response()->json('Сотрудник не был добавлен', 500);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        return Inertia::render('Admin/Employees/Edit', [
            'employee'  => Employee::find($id),
            'companies' => Company::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->service->updateEmployee($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        if (Employee::destroy($id)) {
            return response()->json('Сотрудник был успешно удалена');
        }

        return response()->json('Не удалось удалить сотрудника', 500);
    }
}
