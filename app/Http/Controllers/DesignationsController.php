<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designations;

class DesignationsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Designations";

        return view('designations.list', $this->data);
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

        $designationsquery = Designations::select(Designations::raw('id'));
        if (!empty($searchValue)) {
            $designationsquery->where('name','like','%'.$searchValue.'%');
        }
        $totalcount = $designationsquery->count();
        $designationsquery->select(Designations::raw('id, name, created_by, created_at, updated_at, status'));
        $designationsquery->skip($start)->take($rowPerPage);
        $designationsquery->orderBy($columnName, $columnSortOrder);
        $rows = $designationsquery->get();


        $designations = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['created_by'] = $row->created_by;
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
                                        <li><a class="dropdown-item edit-item-btn designation-edit" href="'.route('designations.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn designation-delete" href="'.route('designations.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $designations[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $designations,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $response['status'] = true;
        $response['message'] = "Page found";
        $response['body'] = view('designations.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:designations|max:255'
        ]);

        $designation = new Designations;
        $designation->name = $request->name;
        $designation->details = $request->details;
        $designation->created_by  = 1;
        $designation->save();
        $response['status'] = true;
        $response['message'] = "New designation added";
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
        $this->data['designation'] = Designations::find($id);
        if($this->data['designation']){
            $response['body'] = view('designations.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Designation not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:designations,name,' . $id . '|max:255'
        ]);

        $designation = Designations::find($id);
        if($designation){
            $designation->name = $request->name;
            $designation->details = $request->details;
            $designation->save();
            $response['status'] = true;
            $response['message'] = "Designation updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Designation not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designations::find($id);
        if($designation){
            $designation->delete();
            $response['status'] = true;
            $response['message'] = "Designation deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Designation not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Designations::select('id','name');
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
