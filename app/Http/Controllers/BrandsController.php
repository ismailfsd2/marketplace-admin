<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Brands;

class BrandsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Brands";

        return view('brands.list', $this->data);
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

        $query = Brands::select(Brands::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
            $query->where('slug','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Brands::raw('id, name, slug, logo, created_by, created_at, updated_at, status'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();


        $brands = [];
        foreach($rows as $row){
            if($row->logo == ""){
                $temp['logo'] = '<img src="'.asset('assets/images/no-image.png').'" width="100" >';
            }
            else{
                $temp['logo'] = '<img src="'.asset($row->logo).'" width="100" >';
            }
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['slug'] = $row->slug;
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
                                        <li><a class="dropdown-item edit-item-btn brand-edit" href="'.route('brands.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn brand-delete" href="'.route('brands.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $brands[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $brands,
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
        $response['body'] = view('brands.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_option['name'] = 'required|unique:brands|max:255';
        $validate_option['slug'] = 'required|unique:brands|max:255';
        $validated = $request->validate($validate_option);

        $brand = new Brands;
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        if ($request->hasFile('logo')) {
            $timestamp = time();
            $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
            $saveDir = "public/uploads/".$db_path;
            $fileName = $timestamp.".jpg";
            $savePath = $saveDir . $fileName;
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0755, true);
            }
            $file = $request->file('logo');
            $file->move($saveDir, $fileName);
            $brand->logo = "uploads/".$db_path . $fileName;
        }
        $brand->detail = $request->detail;
        $brand->created_by  = $this->data['auth']->id;
        $brand->save();
        $response['status'] = true;
        $response['message'] = "New brand added";
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
        $this->data['brand'] = Brands::find($id);
        if($this->data['brand']){
            $response['body'] = view('brands.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Brand not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:brands,name,' . $id . '|max:255',
            'slug' => 'required|unique:brands,slug,' . $id . '|max:255',
        ]);

        $brand = Brands::find($id);
        if($brand){
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            if ($request->hasFile('logo')) {
                $timestamp = time();
                $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
                $saveDir = "public/uploads/".$db_path;
                $fileName = $timestamp.".jpg";
                $savePath = $saveDir . $fileName;
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0755, true);
                }
                $file = $request->file('logo');
                $file->move($saveDir, $fileName);
                $brand->logo = "uploads/".$db_path . $fileName;
            }
            $brand->detail = $request->detail;
            $brand->status = $request->status;
            $brand->save();
            $response['status'] = true;
            $response['message'] = "Brand updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Brand not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brands::find($id);
        if($brand){
            $brand->delete();
            $response['status'] = true;
            $response['message'] = "Brand deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Brand not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Brands::select('id','name');
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
