<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Units;

class UnitsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Units";

        return view('units.list', $this->data);
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

        $query = Units::select(Units::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
            $query->where('code','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Units::raw('id, name, code, created_by, created_at, updated_at, status'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();


        $units = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['code'] = $row->code;
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
                                        <li><a class="dropdown-item edit-item-btn unit-edit" href="'.route('units.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn unit-delete" href="'.route('units.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $units[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $units,
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
        $response['body'] = view('units.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_option['name'] = 'required|unique:units|max:255';
        $validate_option['code'] = 'required|unique:units|max:255';
        $validated = $request->validate($validate_option);

        $unit = new Units;
        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->detail = $request->detail;
        $unit->created_by  = $this->data['auth']->id;
        $unit->save();
        $response['status'] = true;
        $response['message'] = "New unit added";
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
        $this->data['unit'] = Units::find($id);
        if($this->data['unit']){
            $response['body'] = view('units.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Unit not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:units,name,' . $id . '|max:255',
            'code' => 'required|unique:units,code,' . $id . '|max:255',
        ]);

        $unit = Units::find($id);
        if($unit){
            $unit->name = $request->name;
            $unit->code = $request->code;
            $unit->detail = $request->detail;
            $unit->status = $request->status;
            $unit->save();
            $response['status'] = true;
            $response['message'] = "Unit updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Unit not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Units::find($id);
        if($unit){
            $unit->delete();
            $response['status'] = true;
            $response['message'] = "Unit deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Unit not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Units::select('id','name');
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
