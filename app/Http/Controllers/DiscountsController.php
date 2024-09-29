<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discounts;

class DiscountsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Discounts";

        return view('discounts.list', $this->data);
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

        $query = Discounts::select(Discounts::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
            $query->where('code','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Discounts::raw('id, name, code, type, rate, created_by, created_at, updated_at, status'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();


        $discounts = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['code'] = $row->code;
            $temp['type'] = $row->type;
            $temp['rate'] = $row->rate;
            $temp['start_date'] = $row->start_date;
            $temp['end_date'] = $row->end_date;
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
                                        <li><a class="dropdown-item edit-item-btn discount-edit" href="'.route('discounts.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn discount-delete" href="'.route('discounts.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $discounts[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $discounts,
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
        $response['body'] = view('discounts.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_option['name'] = 'required|unique:discounts|max:255';
        $validate_option['code'] = 'required|unique:discounts|max:255';
        $validate_option['type'] = 'required|max:255';
        $validate_option['rate'] = 'required|max:255';
        $validated = $request->validate($validate_option);

        $discount = new Discounts;
        $discount->name = $request->name;
        $discount->code = $request->code;
        $discount->type = $request->type;
        $discount->rate = $request->rate;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->detail = $request->detail;
        $discount->created_by  = $this->data['auth']->id;
        $discount->save();
        $response['status'] = true;
        $response['message'] = "New discount added";
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
        $this->data['discount'] = Discounts::find($id);
        if($this->data['discount']){
            $response['body'] = view('discounts.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Discount not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:discounts,name,' . $id . '|max:255',
            'code' => 'required|unique:discounts,code,' . $id . '|max:255',
            'type' => 'required|max:255',
            'rate' => 'required|max:255',
        ]);

        $discount = Discounts::find($id);
        if($discount){
            $discount->name = $request->name;
            $discount->code = $request->code;
            $discount->type = $request->type;
            $discount->rate = $request->rate;
            $discount->detail = $request->detail;
            $discount->status = $request->status;
            $discount->save();
            $response['status'] = true;
            $response['message'] = "Discount updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Discount not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discounts::find($id);
        if($discount){
            $discount->delete();
            $response['status'] = true;
            $response['message'] = "Discount deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Discount not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Discounts::select('id','name');
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
