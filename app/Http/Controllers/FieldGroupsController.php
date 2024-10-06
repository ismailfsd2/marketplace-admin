<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\FieldGroups;

class FieldGroupsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Field Groups";

        return view('field_groups.list', $this->data);
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

        $query = FieldGroups::select(FieldGroups::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(FieldGroups::raw('id, name, created_by, created_at, updated_at'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();


        $field_groups = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['created_by'] = $row->created_user->name;
            $temp['created_at'] = $row->created_at->format('d-M-Y H:i');
            $temp['updated_at'] = $row->updated_at->format('d-M-Y H:i');
            $temp['actions'] = '<div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="'.route('field_groups.fields.list',$row->id).'"><i class="ri-list-unordered align-bottom me-2 text-muted"></i> Field List</a></li>
                                        <li><a class="dropdown-item edit-item-btn field-group-edit" href="'.route('field_groups.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn field-group-delete" href="'.route('field_groups.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $field_groups[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $field_groups,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.+
     */
    public function create()
    {
        $response['status'] = true;
        $response['message'] = "Page found";
        $response['body'] = view('field_groups.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_option['name'] = 'required|unique:field_groups|max:255';
        $validated = $request->validate($validate_option);

        $field_group = new FieldGroups;
        $field_group->name = $request->name;
        $field_group->detail = $request->detail;
        $field_group->created_by  = $this->data['auth']->id;
        $field_group->save();
        $response['status'] = true;
        $response['message'] = "New field group added";
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
        $this->data['field_group'] = FieldGroups::find($id);
        if($this->data['field_group']){
            $response['body'] = view('field_groups.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Field group not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:field_groups,name,' . $id . '|max:255',
        ]);

        $field_group = FieldGroups::find($id);
        if($field_group){
            $field_group->name = $request->name;
            $field_group->detail = $request->detail;
            $field_group->save();
            $response['status'] = true;
            $response['message'] = "Field group updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Field group not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field_group = FieldGroups::find($id);
        if($field_group){
            $field_group->delete();
            $response['status'] = true;
            $response['message'] = "Field group deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Field group not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = FieldGroups::select('id','name');
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
