<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\employee;
use Barryvdh\Debugbar\DataCollector\ViewCollector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class employeeController extends Controller
{
    public function index()
    {
        $departments = department::all();
        return view('employee.index', ['departments' => $departments]);
    }

    public function pdfDownload()
    {
//        ini_set("pcre.backtrack_limit", "50000000");
//        ini_set('max_execution_time', 30000);


//        $employee = employee::query()->limit(10)->get();
////        $mpdf = new Mpdf();
//        $documentFileName = "aaaaa.pdf";
//        $option = [
//            'format' => 'A4', 'margin_header' => '3', 'margin_top' => '20', 'margin_bottom' => '20', 'margin_footer' => '2'
//        ];
//        $header = [
//            'Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
//        ];
//
//        $pdf = new Mpdf($option);
//        $pdf->SetHeader("<h1> kk </h1>");
//        $pdf->SetFooter("<h1> kk </h1>");
//        $pdf->WriteHTML(view('pdf.employee', ["employee" => $employee]));
//        $pdf->Output("aa.pdf", "\Mpdf\Output");
//        return view('pdf.employee',['employee' => $employee]);
//        return response()->stream($pdf, 200);

    }

    public function testRequest()
    {
        return response()->json(['id' => 1]);
    }

    public function test()
    {
//        phpinfo();
        $curl = curl_init();
//        $curl->set
        curl_setopt($curl, CURLOPT_URL, "https://intg-customer-staging.nivodaapi.net/api/diamonds");
//        curl_setopt($curl,)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($curl);
//        dd(1);
        dd($res);


    }


    public function ajaxfetch(Request $request)
    {
        $draw = $request->get('draw'); // Internal use
        $start = $request->get("start"); // where to start next records for pagination
        $rowPerPage = $request->get("length"); // How many recods needed per page for pagination

        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); // It will give us columns array

        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];  // This will let us know,
        // which column index should be sorted
        // 0 = id, 1 = name, 2 = email , 3 = created_at

        $columnName = $columnNameArray[$columnIndex]['data']; // Here we will get column name,
        // Base on the index we get

        $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue = $searchArray['value']; // This is search value

        $data = employee::query();
        $total = $data->count();
        if ($searchValue) {
            $data = $data->where('name', 'like', "%".$searchValue."%");
            $data = $data->orWhere('mobile', 'like', "%".$searchValue."%");
        }
        if ($columnName) {
            $data = $data->orderBy($columnName, $columnSortOrder);
        }

        $filterDataCount = $data->count();
        if ($rowPerPage == -1) {
            $data = $data->get();
        } else {
            $data = $data->skip($start)->take($rowPerPage)->get();
        }


        $response = array(
            "draw" => intval($draw), "recordsTotal" => $total, // Set the total number of records
            "recordsFiltered" => $filterDataCount, "data" => $data,
        );

        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {
        $employee = employee::find($request->id);
        if (file_exists('image / '.$employee->image)) {
            unlink('image / '.$employee->image);
        }
        $employee->delete();
        return back()->withSuccess('User Deleted');
    }

    public function fetchOne(Request $request)
    {
        $employee = employee::find($request->id);
        return ['employee' => $employee];
    }

    public function update(Request $request)
    {
        $employee = employee::find($request->id);
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        if ($request->department == "addNew") {

            $department = new department();
            $department->name = $request->newDepartmentName;
            $department->address = $request->newDepartmentAddress;
            $department->save();
            $department = $department->id;
        } else {
            $department = $request->department;
        }
        $employee->department_id = $department;
        if ($request->image) {
            if ($employee->image or $employee->image != "") {
                if (file_exists('image / '.$employee->image)) {
                    unlink('image / '.$employee->image);
                }
            }
            $imageName = time().".".$request->image->extension();
            $request->image->move(public_path('image'), $imageName);
            $employee->image = $imageName;
        }
        $employee->save();
        return back()->withSuccess('User Updated');
    }

    public function create()
    {
        $departments = department::all();
        return view('employee.create', ['departments' => $departments]);
    }

    public function createStore(Request $request)
    {
        $request->validate([
            'name' => 'required', 'mobile' => 'required', 'department' => 'required', 'image' => 'required | mimes:jpg,jpeg,png,gif | max:1000',
        ]);

        $employee = new employee();
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        $employee->department_id = $request->department;
        $imageName = time().".".$request->image->extension();
        $request->image->move(public_path('image'), $imageName);
        $employee->image = $imageName;
        $employee->save();
        return back()->withSuccess('User Created');
    }

}
