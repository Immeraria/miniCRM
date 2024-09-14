<?php

namespace App\Services\Company;

use App\Models\Company;

final class CompanyService
{
    public function createCompany(array $data)
    {
        return Company::create($data);
    }

    public function updateCompany(array $data): \Illuminate\Http\JsonResponse
    {
        $company = Company::find($data['id']);

        if (! $company) {
            return response()->json('Компания не найдена', 404);
        }

        if ($company->update($data)) {
            return response()->json('Компания была успешно изменена');
        }

        return response()->json('Компания не была изменена', 500);
    }
}