<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 003 03.08.18
 * Time: 17:41
 */

namespace App\Services;


use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;

class EmployeeService
{
    /**
     * @param CreateEmployeeRequest $request
     * @return Employee
     */
    public function create(CreateEmployeeRequest $request) : Employee
    {
        if ($parentId = $request->get('parent_id')) {
            $parent = Employee::find($parentId);

            return $parent->children()->create($request->all());
        }

        return Employee::create($request->validated());
    }

    /**
     * @param int $employeeId
     * @param UpdateEmployeeRequest $request
     * @return Employee
     */
    public function update(int $employeeId, UpdateEmployeeRequest $request) : Employee
    {
        $employee = Employee::findOrFail($employeeId);
        $employee->update($request->validated());

        return $employee;
    }
}