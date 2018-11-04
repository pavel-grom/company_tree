<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeController extends BaseController
{
    /**
     * @var EmployeeService
     */
    private $employeeService;

    /**
     * EmployeeController constructor.
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Get root employees
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function root()
    {
        $root = Employee::with('position')
            ->whereIsRoot('parent_id')
            ->get();

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

        return $this->jsonResponse($employee->children->map(function($child){
            $child->isLeaf = $child->isLeaf();
            return $child;
        }));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = $this->employeeService->create($request);

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
        $employee->isLeaf = $employee->isLeaf();

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
        $employee = $this->employeeService->update($employee_id, $request);

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
