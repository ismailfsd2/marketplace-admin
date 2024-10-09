<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use App\Models\PointOfContacts;

class PointOfContactsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index($supplier_id)
    {
        $this->data['page_title'] = "Point Of Contacts";

        $supplier = Suppliers::find($supplier_id);
        if($supplier){
            $this->data['supplier'] = $supplier;
            return view('point_of_contacts.list', $this->data);
        }
        else{
            return redirect()->route('suppliers.list');
        }

    }

    /**
     * Display a listi Data of the resource.
     */
    public function data(Request $request, $supplier_id)
    {
        $draw 				= 		$request->get('draw'); // Internal use
        $start 				= 		$request->get("start"); // where to start next records for pagination
        $rowPerPage 		= 		$request->get("length"); // How many recods needed per page for pagination
        $orderArray 	    = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns'); // It will give us columns array
        $searchArray 		= 		$request->get('search');
        $columnIndex 		= 		$orderArray[0]['column'];  // This will let us know,
        $columnName 		= 		$columnNameArray[$columnIndex]['data']; // Here we will get column name, 
        $columnSortOrder 	= 		$orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue 		= 		$searchArray['value']; // This is search value 

        $query = PointOfContacts::select(PointOfContacts::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
            $query->where('email','like','%'.$searchValue.'%');
            $query->where('phone','like','%'.$searchValue.'%');
        }
        $query->where('supplier_id',$supplier_id);
        $totalcount = $query->count();
        $query->select(PointOfContacts::raw('*'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();

        $point_of_contacts = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['designation'] = $row->designation;
            $temp['phone_number'] = $row->phone_number;
            $temp['email'] = $row->email;
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
                                        <li><a class="dropdown-item edit-item-btn point-of-contact-edit" href="'.route('point_of_contacts.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn point-of-contact-delete" href="'.route('point_of_contacts.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $point_of_contacts[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $point_of_contacts,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($supplier_id)
    {
        $supplier = Suppliers::find($supplier_id);
        if($supplier){
            $this->data['supplier'] = $supplier;
            $response['status'] = true;
            $response['message'] = "Page found";
            $response['body'] = view('point_of_contacts.add', $this->data)->render();
            return response()->json($response);
        }
        else{
            return redirect()->route('suppliers.list');
        }



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $supplier_id)
    {

        $validate_option['name'] = 'required|max:255';
        $validate_option['designation'] = 'required|max:255';
        $validate_option['phone_number'] = 'required|max:255';
        if($request->email != ""){
            $valiate_option['email'] = "required|email|unique:point_of_contacts|max:255";
        }
        $validated = $request->validate($validate_option);

        $poc = new PointOfContacts;
        $poc->supplier_id = $supplier_id;
        $poc->name = $request->name;
        $poc->designation = $request->designation;
        $poc->phone_number = $request->phone_number;
        $poc->email = $request->email;
        $poc->detail = $request->detail;
        $poc->created_by  = $this->data['auth']->id;
        $poc->save();
        $response['status'] = true;
        $response['message'] = "New POC added";
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
        $response['status'] = false;
        $this->data['poc'] = PointOfContacts::find($id);
        if($this->data['poc']){
            $response['body'] = view('point_of_contacts.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "POC not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate_option['name'] = 'required|max:255';
        $validate_option['designation'] = 'required|max:255';
        $validate_option['phone_number'] = 'required|max:255';
        if($request->email != ""){
            $valiate_option['email'] = "required|email|unique:point_of_contacts,email,".$id."|max:255";
        }
        $validated = $request->validate($validate_option);

        $poc = PointOfContacts::find($id);
        if($poc){
            $poc->name = $request->name;
            $poc->designation = $request->designation;
            $poc->phone_number = $request->phone_number;
            $poc->email = $request->email;
            $poc->detail = $request->detail;
            $poc->save();
            $response['status'] = true;
            $response['message'] = "POC updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "POC not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poc = PointOfContacts::find($id);
        if($poc){
            $poc->delete();
            $response['status'] = true;
            $response['message'] = "POC deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "POC not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = PointOfContacts::select('id','name');
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
