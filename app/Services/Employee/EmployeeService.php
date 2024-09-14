<?php

namespace App\Services\Employee;

use App\Models\Employee;

final class EmployeeService
{
    public function createEmployee(array $data)
    {
        return Employee::create($data);
    }

    public function updateEmployee(array $data): \Illuminate\Http\JsonResponse
    {
        $employee = Employee::find($data['id']);

        if (! $employee) {
            return response()->json('Сотрудник не найден', 404);
        }

        if ($employee->update($data)) {
            return response()->json('Сотрудник был успешно изменен');
        }

        return response()->json('Сотрудник не была изменен', 500);
    }
}
