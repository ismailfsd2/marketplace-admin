<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Suppliers;
use App\Models\User;

class SuppliersController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Suppliers";

        return view('suppliers.list', $this->data);
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

        $query = Suppliers::select(Suppliers::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
            $query->where('email','like','%'.$searchValue.'%');
            $query->where('phone_number','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Suppliers::raw('id, name, logo, phone_number, email, country_id, state_id, city_id, postal_code, tax_register_status, tax_number, created_by, created_at, updated_at, status'));
        $query->with(['country','state','city','created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();

        $suppliers = [];
        foreach($rows as $row){
            if($row->logo == ""){
                $temp['logo'] = '<img src="'.asset('assets/images/no-image.png').'" width="100" >';
            }
            else{
                $temp['logo'] = '<img src="'.asset($row->logo).'" width="100" >';
            }
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['phone_number'] = $row->phone_number;
            $temp['email'] = $row->email;
            $temp['postal_code'] = $row->postal_code;
            $temp['tax_register_status'] = $row->tax_register_status;
            $temp['tax_number'] = $row->tax_number;
            $temp['country'] = $row->country->name;
            $temp['state'] = $row->state->name;
            $temp['city'] = $row->city->name;
            $temp['created_by'] = $row->created_user->name;
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
                                        <li><a class="dropdown-item edit-item-btn supplier-edit" href="'.route('point_of_contacts.list',$row->id).'"><i class="ri-list-unordered align-bottom me-2 text-muted"></i> List POC</a></li>
                                        <li><a class="dropdown-item edit-item-btn supplier-edit" href="'.route('suppliers.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn supplier-delete" href="'.route('suppliers.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $suppliers[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $suppliers,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['page_title'] = "Register Supplier";

        return view('suppliers.add', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valiate_option['name'] = "required|max:255";
        $valiate_option['phone_number'] = "required|max:255";
        $valiate_option['country'] = "required|max:255";
        $valiate_option['state'] = "required|max:255";
        $valiate_option['city'] = "required|max:255";
        $valiate_option['postal_code'] = "required|max:255";
        $valiate_option['address'] = "required|max:255";

        if($request->register_status){
            $valiate_option['register_number'] = "required|max:255";
        }

        if($request->create_login_detail){
            $valiate_option['email'] = "required|email|unique:users|max:255";
            $valiate_option['password'] = "min:6|required_with:confirm_password|same:confirm_password";
            $valiate_option['confirm_password'] = "min:6";
        }

        $validated = $request->validate($valiate_option);

        $supplier = new Suppliers;
        $supplier->name = $request->name;
        $supplier->phone_number = $request->phone_number;
        $supplier->email = $request->email;
        $supplier->country_id = $request->country;
        $supplier->state_id = $request->state;
        $supplier->city_id = $request->city;
        $supplier->postal_code = $request->postal_code;
        $supplier->address = $request->address;
        if($request->register_status){
            $supplier->tax_register_status = 'yes';
        }
        else{
            $supplier->tax_register_status = 'no';
        }
        $supplier->tax_number = $request->tax_number;
        $supplier->detail = $request->detail;
        $supplier->created_by  = $this->data['auth']->id;
        $supplier->status = 1;
        $supplier->save();

        if($supplier){
            if($request->email != ""){
                $user = new User;
                $user->name = $request->name;
                $user->phone_number = $request->phone_number;
                $user->email = $request->email;
                $user->type = 'supplier';
                $user->supplier_id = $supplier->id;
                $user->created_by  = $this->data['auth']->id;
                $user->own_data_visible = 1;
                if($request->create_login_detail == 1){
                    $user->password = Hash::make($request->password);
                    $user->status = 1;
                }
                else{
                    $user->password = Hash::make('000000');
                    $user->status = 0;
                }
                $user->save();
            }
    
            $response['status'] = true;
            $response['redirect'] = route('suppliers.list');
            $response['message'] = "New suppliers added";
        }
        else{
            $response['status'] = false;
            $response['message'] = "New supplier add failed";
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
        $this->data['page_title'] = "Edit Supplier";
        $response['status'] = false;
        $supplier = Suppliers::with(['country','state','city','user'])->find($id);
        if($supplier){
            $this->data['supplier'] = $supplier;
            return view('suppliers.edit', $this->data);
        }
        else{
            return redirect()->route('suppliers.list');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $supplier_id, string $user_id)
    {
        $valiate_option['name'] = "required|max:255";
        $valiate_option['phone_number'] = "required|max:255";
        $valiate_option['country'] = "required|max:255";
        $valiate_option['state'] = "required|max:255";
        $valiate_option['city'] = "required|max:255";
        $valiate_option['postal_code'] = "required|max:255";
        $valiate_option['address'] = "required|max:255";
        if($request->register_status){
            $valiate_option['register_number'] = "required|max:255";
        }
        $validated = $request->validate($valiate_option);

        $supplier = Suppliers::find($supplier_id);
        if($supplier){
            if($supplier->email != "" && $request->email == ""){
                if($user_id == 0){
                    $valiate_option['email'] = "required|email|unique:users|max:255";
                }
                else{
                    $valiate_option['email'] = "required|email|unique:users,email,".$user_id."|max:255";
                }
                $validated = $request->validate($valiate_option);
            }
            else if($request->email != ""){
                $valiate_option['email'] = "required|email|unique:users,email,".$user_id."|max:255";
                $validated = $request->validate($valiate_option);
            }
            $supplier->name = $request->name;
            $supplier->phone_number = $request->phone_number;
            $supplier->email = $request->email;
            $supplier->country_id = $request->country;
            $supplier->state_id = $request->state;
            $supplier->city_id = $request->city;
            $supplier->postal_code = $request->postal_code;
            $supplier->address = $request->address;
            if($request->register_status){
                $supplier->tax_register_status = 'yes';
            }
            else{
                $supplier->tax_register_status = 'no';
            }
            $supplier->tax_number = $request->register_number;
            $supplier->detail = $request->detail;
            $supplier->save();

            if($request->email != ""){
                if($user_id == 0){
                    $user = new User;
                    $user->name = $request->name;
                    $user->phone_number = $request->phone_number;
                    $user->type = 'supplier';
                    $user->supplier_id = $supplier->id;
                    $user->created_by  = $this->data['auth']->id;
                    $user->own_data_visible = 1;
                    $user->password = Hash::make('000000');
                    $user->status = 0;
                }
                else{
                    $user = User::find($user_id);
                }
                $user->email = $request->email;
                $user->save();
        }
            $response['status'] = true;
            $response['message'] = "Supplier updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Supplier not found";
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

    public function create_login_account(Request $request, string $supplier_id)
    {

        $valiate_option['new_password'] = "min:6|required_with:new_password_confirm|same:new_password_confirm";
        $valiate_option['new_password_confirm'] = "min:6";
        $valiate_option['email'] = "required|email|unique:users|max:255";
        $validated = $request->validate($valiate_option);

        $supplier = Suppliers::find($supplier_id);
        if($supplier){
            $user = new User;
            $user->name = $supplier->name;
            $user->phone_number = $supplier->phone_number;
            $user->type = 'supplier';
            $user->supplier_id = $supplier->id;
            $user->created_by  = $this->data['auth']->id;
            $user->own_data_visible = 1;
            $user->password = Hash::make($request->new_password);
            $user->status = 1;
            $user->email = $request->email;
            $user->save();

            $supplier->email = $request->email;
            $supplier->save();

            $response['status'] = true;
            $response['message'] = "Login account created";

        }
        else{
            $response['status'] = false;
            $response['message'] = "Invalid Supplier";
        }
        return response()->json($response);
    }

    public function change_profile(Request $request, $supplier_id){
        $response['status'] = false;
        $response['message'] = 'Something Wrong!';
        $supplier = Suppliers::find($supplier_id);
        if($supplier){
            if ($request->hasFile('logo_image')) {
                $timestamp = time();
                $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
                $saveDir = "public/uploads/".$db_path;
                $fileName = $timestamp.".jpg";
                $savePath = $saveDir . $fileName;
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0755, true);
                }
                $file = $request->file('logo_image');
                $file->move($saveDir, $fileName);
    
                $supplier->logo = "uploads/".$db_path . $fileName;
                $supplier->save();
    
                $response['status'] = true;
                $response['message'] = 'Supplier logo Update';
                $response['profile_url'] = asset("uploads/".$db_path . $fileName);
            }
        }
        else{
            $response['message'] = 'Invalid Supplier';
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Suppliers::find($id);
        if($supplier){
            $user = User::where('supplier_id',$supplier->id)->delete();
            $supplier->delete();
            $response['status'] = true;
            $response['message'] = "Supplier deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Supplier not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Suppliers::select('id','name');
        if($request->default_value){
            $items->where('id',$request->default_value);
        }
        else{
            $items->where('name','like','%'.$request->q.'%');
        }
        $response['status'] = true;
        $response['items'] = $items->get();
        return response()->json($response);
    }
}
