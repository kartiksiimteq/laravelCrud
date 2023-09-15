<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EmployeeApiV1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $employee    = Employee::query();
        $page_number = 0;
        $per_page    = 5;
        if (isset($request->page_number)) {
            $page_number = $request->page_number;
        }
        if (isset($request->per_page)) {
            $per_page = $request->per_page;
            if ($per_page > 100) {
                $per_page = 100;
            }
        }
        $employee = $employee->offset($page_number * $per_page)->limit($per_page)->get();
        if ( ! $employee || count($employee) < 1) {
            $response = ['status' => 422, 'success' => true, 'message' => "User Not Found"];
            $status   = 422;
        } else {
            foreach ($employee as $emp) {
                $employees[] = [
                    "data" => $emp, "link" => self::getLinks($emp)
                ];
            }
            $response = ['status' => 200, 'success' => true, 'message' => "User Found", 'per_page' => $per_page, 'page_number' => $page_number, 'Data' => $employees];
            $status   = 200;
        }

        return response()->json($response, $status);

    }

    public function getLinks(Employee $employee): array
    {
        return [
            'self'   => ['Method' => 'get', 'url' => URL::route('employees.show', ['employee' => $employee->id])],
            'update' => ['Method' => 'put/post', 'url' => URL::route('employees.update', ['employee' => $employee->id])],
            'delete' => ['Method' => 'delete', 'url' => URL::route('employees.destroy', ['employee' => $employee->id])],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if (isset($request->name) && $request->name && isset($request->mobile) && $request->mobile) {
            $data     = Employee::create($request->all());
            $response = ['status' => 200, 'success' => true, 'message' => "User Created", 'data' => $data];
            $status   = 201;
        } else {
            $response = ['status' => 422, 'success' => true, 'message' => "USER NAME AND MOBILE NUMBER ARE REQUIRED"];
            $status   = 422;
        }

        return response()->json($response, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $employee = Employee::query()->find($id);
        if ($employee) {
            $response = [
                'status' => 200, 'success' => true, 'message' => "User Found", 'data' => [
                    "data" => $employee, "link" => self::getLinks($employee)
                ]
            ];
            $status   = 200;

        } else {
            $response = ['status' => 422, 'success' => true, 'message' => "USER NAME AND MOBILE NUMBER ARE REQURED"];
            $status   = 422;

        }

        return response()->json($response, $status);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = Employee::query()->find($id);
        if ( ! $data) {
            $response = ['status' => 422, 'success' => true, 'message' => "User Id Not Exist"];
            $status   = 422;
        } else {
            $request = $request->all();
            $data->fill($request);
            $data->save();
            $response = ['status' => 200, 'success' => true, 'message' => "User Updated", 'data' => [
                "data" => $data, "link" => self::getLinks($data)
            ]];
            $status   = 200;
        }

        return response()->json($response, $status);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $data = Employee::query()->find($id);
        if ($data) {
            $data->delete();
            $response = ['status' => 200, 'success' => true, 'message' => "User Deleted", 'data' => $data];
            $status   = 200;
        } else {
            $response = ['status' => 422, 'success' => true, 'message' => "User Id Not Exist"];
            $status   = 422;
        }

        return response()->json($response, $status);
    }
}
