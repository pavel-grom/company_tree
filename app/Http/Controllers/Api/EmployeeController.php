<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

    }

    /**
     * Get root employee
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function root()
    {
        $root = Employee::with('children.position', 'position')->whereNull('parent_id')->first();

        return $this->jsonResponse($root);
    }

    /**
     * Get employee's children
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function children(int $id)
    {
        $employee = Employee::with('children.position')->findOrFail($id);

        return $this->jsonResponse($employee->children);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = Employee::create($request->except(['_lft', '_rgt', 'parent_id']));
        $employee->parent()->associate($request->get('parent_id'))->save();

        return $this->jsonResponse($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $employee_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $employee_id)
    {
        $withChildren = $request->get('with_children', false);

        $employee = Employee::query();

        if ($withChildren) {
            $employee->with('children');
        }

        $employee = $employee->findOrFail($employee_id);

        return $this->jsonResponse($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEmployeeRequest  $request
     * @param  int  $employee_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, $employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee = $employee->update($request->except(['_lft', '_rgt', 'parent_id']));

        if ($parent_id = $request->get('parent_id')) {
            $employee->parent()->associate($parent_id)->save();
        }

        return $this->jsonResponse($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $employee_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->delete();

        return $this->jsonResponse($employee);
    }
}
