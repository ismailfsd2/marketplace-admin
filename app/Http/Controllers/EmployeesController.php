<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employees;

class EmployeesController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Employees";

        return view('employees.list', $this->data);
    }

    /**
     * Display a listi Data of the resource.
     */
    public function data(Request $request)
    {
        $draw 				= 		$request->get('draw'); // Internal use
        $start 				= 		$request->get("start"); // where to start next records for pagination
        $rowPerPage 		= 		$request->get("length"); // How many recods needed per page for pagination
        $orderArray 	   = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns'); // It will give us columns array
        $searchArray 		= 		$request->get('search');
        $columnIndex 		= 		$orderArray[0]['column'];  // This will let us know,
        $columnName 		= 		$columnNameArray[$columnIndex]['data']; // Here we will get column name, 
        $columnSortOrder 	= 		$orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue 		= 		$searchArray['value']; // This is search value 

        $employeesquery = Employees::select(Employees::raw('id'));
        if (!empty($searchValue)) {
            $employeesquery->where('first_name','like','%'.$searchValue.'%');
            $employeesquery->where('last_name','like','%'.$searchValue.'%');
            $employeesquery->where('email','like','%'.$searchValue.'%');
            $employeesquery->where('phone_number','like','%'.$searchValue.'%');
        }
        $totalcount = $employeesquery->count();
        $employeesquery->select(Employees::raw('id, first_name, last_name, email, phone_number, designation_id, department_id, created_by, created_at, updated_at, status'));
        $employeesquery->with(['department','designation','country','state','city']);
        $employeesquery->skip($start)->take($rowPerPage);
        $employeesquery->orderBy($columnName, $columnSortOrder);
        $rows = $employeesquery->get();


        $employees = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->first_name.' '.$row->last_name;
            $temp['email'] = $row->email;
            $temp['phone_number'] = $row->phone_number;
            $temp['designation'] = $row->designation->name;
            $temp['department'] = $row->department->name;
            $temp['created_at'] = $row->created_at->format('d-M-Y H:i');
            $temp['updated_at'] = $row->updated_at->format('d-M-Y H:i');
            if($row->status){
                $temp['status'] = '<span class="badge text-bg-success">Active</span>';
            }
            else{
                $temp['status'] = '<span class="badge text-bg-danger">Deactive</span>';
            }
            $temp['actions'] = '<div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item edit-item-btn employee-edit" href="'.route('employees.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn employee-delete" href="'.route('employees.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $employees[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $employees,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['page_title'] = "Register Employee";

        return view('employees.add', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valiate_option['first_name'] = "required|max:255";
        $valiate_option['last_name'] = "required|max:255";
        $valiate_option['phone_number'] = "required|max:255";
        $valiate_option['email'] = "required|email|unique:users|max:255";
        $valiate_option['designation'] = "required|max:255";
        $valiate_option['department'] = "required|max:255";
        $valiate_option['country'] = "required|max:255";
        $valiate_option['state'] = "required|max:255";
        $valiate_option['city'] = "required|max:255";
        $valiate_option['postal_code'] = "required|max:255";
        $valiate_option['address'] = "required|max:255";
        if($request->create_login_detail){
            $valiate_option['password'] = "min:6|required_with:confirm_password|same:confirm_password";
            $valiate_option['confirm_password'] = "min:6";
        }
        $validated = $request->validate($valiate_option);

        $employee = new Employees;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->designation_id = $request->designation;
        $employee->department_id = $request->department;
        $employee->phone_number = $request->phone_number;
        $employee->email = $request->email;
        $employee->country_id = $request->country;
        $employee->state_id = $request->state;
        $employee->city_id = $request->city;
        $employee->postal_code = $request->postal_code;
        $employee->address = $request->address;
        $employee->created_by  = $this->data['auth']->id;
        $employee->status = 1;
        $employee->save();

        if($employee){
            $user = new User;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->type = 'employee';
            $user->employee_id = $employee->id;
            $user->created_by  = $this->data['auth']->id;
            if($request->own_data_visible == 1){
                $user->own_data_visible = 1;
            }
            else{
                $user->own_data_visible = 0;
            }
            if($request->create_login_detail == 1){
                $user->password = Hash::make($request->password);
                $user->status = 1;
            }
            else{
                $user->password = Hash::make('000000');
                $user->status = 0;
            }
    
            $user->save();
    
            $response['status'] = true;
            $response['redirect'] = route('employees.list');
            $response['message'] = "New employee added";
        }
        else{
            $response['status'] = false;
            $response['message'] = "New employee add failed";
        }
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['page_title'] = "Edit Employee";
        $response['status'] = false;
        $employee = Employees::with(['department','designation','country','state','city','user'])->find($id);
        if($employee){
            $this->data['employee'] = $employee;
            return view('employees.edit', $this->data);
        }
        else{
            return redirect()->route('employees.list');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $employee_id, string $user_id)
    {
        $valiate_option['first_name'] = "required|max:255";
        $valiate_option['last_name'] = "required|max:255";
        $valiate_option['phone_number'] = "required|max:255";
        $valiate_option['email'] = "required|email|unique:users,email,".$user_id."|max:255";
        $valiate_option['designation'] = "required|max:255";
        $valiate_option['department'] = "required|max:255";
        $valiate_option['country'] = "required|max:255";
        $valiate_option['state'] = "required|max:255";
        $valiate_option['city'] = "required|max:255";
        $valiate_option['postal_code'] = "required|max:255";
        $valiate_option['address'] = "required|max:255";
        $validated = $request->validate($valiate_option);

        $employee = Employees::find($employee_id);
        if($employee){
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->designation_id = $request->designation;
            $employee->department_id = $request->department;
            $employee->phone_number = $request->phone_number;
            $employee->email = $request->email;
            $employee->country_id = $request->country;
            $employee->state_id = $request->state;
            $employee->city_id = $request->city;
            $employee->postal_code = $request->postal_code;
            $employee->address = $request->address;
            $employee->created_by  = $this->data['auth']->id;
            $employee->status = 1;
            $employee->save();
    
            $user = User::find($user_id);
            $user->name = $request->first_name.' '.$request->last_name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->save();
    
            $response['status'] = true;
            $response['redirect'] = route('employees.list');
            $response['message'] = "Employees updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Invalid Employee";
        }
        return response()->json($response);

    }

    public function login_detail_update(Request $request, string $user_id){
        $user = User::find($user_id);
        if($user){
            if($request->new_password != ""){
                $valiate_option['current_password'] = "required";
                $valiate_option['new_password'] = "min:6|required_with:new_password_confirm|same:new_password_confirm";
                $valiate_option['new_password_confirm'] = "min:6";
                $validated = $request->validate($valiate_option);
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = Hash::make($request->new_password);
                }
                else{
                    $response['status'] = false;
                    $response['message'] = "Enter wrong current password";
                    return response()->json($response);
                }
            }
            if($request->own_data_visible == 1){
                $user->own_data_visible = 1;
            }
            else{
                $user->own_data_visible = 0;
            }
            if($request->status == 1){
                $user->status = 1;
            }
            else{
                $user->status = 0;
            }
            $user->save();
            $response['status'] = true;
            $response['message'] = "Login Detail Update";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Invalid User";
        }
        return response()->json($response);
    }

    public function change_profile(Request $request, $employee_id){
        $response['status'] = false;
        $response['message'] = 'Something Wrong!';
        $employee = Employees::find($employee_id);
        if($employee){
            if ($request->hasFile('profile_image')) {
                $timestamp = time();
                $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
                $saveDir = "public/uploads/".$db_path;
                $fileName = $timestamp.".jpg";
                $savePath = $saveDir . $fileName;
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0755, true);
                }
                $file = $request->file('profile_image');
                $file->move($saveDir, $fileName);
    
                $employee->picture = "uploads/".$db_path . $fileName;
                $employee->save();
    
                $response['status'] = true;
                $response['message'] = 'Employee Profile Update';
                $response['profile_url'] = asset("uploads/".$db_path . $fileName);
            }
        }
        else{
            $response['message'] = 'Invalid Employee';
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employees::find($id);
        if($employee){
            $user = User::where('employee_id',$employee->id)->delete();
            $employee->delete();
            $response['status'] = true;
            $response['message'] = "Employees deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Employees not found";
        }
        return response()->json($response);


    }
}
