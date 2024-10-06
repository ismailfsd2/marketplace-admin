<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Categories;

class CategoriesController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['page_title'] = "Categories";

        return view('categories.list', $this->data);
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

        $query = Categories::select(Categories::raw('id'));
        if (!empty($searchValue)) {
            $query->where('name','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Categories::raw('id, name, slug, icon, thumbnail_image, parent_category, field_group_id, created_by, created_at, updated_at, status'));
        $query->with(['created_user','parent','field_group']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();

        $categories = [];
        foreach($rows as $row){
            if($row->icon == ""){
                $temp['icon'] = '<img src="'.asset('assets/images/no-image.png').'" width="100" >';
            }
            else{
                $temp['icon'] = '<img src="'.asset($row->icon).'" width="100" >';
            }
            if($row->thumbnail_image == ""){
                $temp['thumbnail_image'] = '<img src="'.asset('assets/images/no-image.png').'" width="100" >';
            }
            else{
                $temp['thumbnail_image'] = '<img src="'.asset($row->thumbnail_image).'" width="100" >';
            }
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['slug'] = $row->slug;
            if($row->parent){
                $temp['parent_category'] = $row->parent->name;
            }
            else{
                $temp['parent_category'] = 'No Parent Category';
            }
            if($row->field_group){
                $temp['field_group'] = $row->field_group->name;
            }
            else{
                $temp['field_group'] = 'No Parent Category';
            }
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
                                        <li><a class="dropdown-item edit-item-btn category-edit" href="'.route('categories.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn category-delete" href="'.route('categories.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $categories[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $categories,
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
        $response['body'] = view('categories.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_option['name'] = 'required|unique:categories|max:255';
        $validate_option['slug'] = 'required|unique:categories|max:255';
        $validated = $request->validate($validate_option);

        $category = new Categories;
        $timestamp = time();
        $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
        $saveDir = "public/uploads/".$db_path;
        if ($request->hasFile('thumbnail')) {
            $fileName = $timestamp.'-'.rand(10,100).".jpg";
            $savePath = $saveDir . $fileName;
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0755, true);
            }
            $file = $request->file('thumbnail');
            $file->move($saveDir, $fileName);
            $category->thumbnail_image = "uploads/".$db_path . $fileName;
        }

        if ($request->hasFile('icon')) {
            $fileName = $timestamp.'-'.rand(10,100).".jpg";
            $savePath = $saveDir . $fileName;
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0755, true);
            }
            $icon_file = $request->file('icon');
            $icon_file->move($saveDir, $fileName);
            $category->icon = "uploads/".$db_path . $fileName;
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_category = $request->parent_category;
        $category->field_group_id = $request->fields_group;
        $category->created_by  = $this->data['auth']->id;
        $category->save();
        $response['status'] = true;
        $response['message'] = "New category added";
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
        $this->data['category'] = Categories::find($id);
        if($this->data['category']){
            $response['body'] = view('categories.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Category not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate_option['name'] = 'required|unique:categories,name,' . $id . '|max:255';
        $validate_option['slug'] = 'required|unique:categories,slug,' . $id . '|max:255';
        $validated = $request->validate($validate_option);

        $category = Categories::find($id);
        if($category){



            $timestamp = time();
            $db_path = "images/".date('Y')."/".date('m')."/".date('d')."/";
            $saveDir = "public/uploads/".$db_path;
            if ($request->hasFile('thumbnail')) {
                $fileName = $timestamp.'-'.rand(10,100).".jpg";
                $savePath = $saveDir . $fileName;
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0755, true);
                }
                $file = $request->file('thumbnail');
                $file->move($saveDir, $fileName);
                $category->thumbnail_image = "uploads/".$db_path . $fileName;
            }
    
            if ($request->hasFile('icon')) {
                $fileName = $timestamp.'-'.rand(10,100).".jpg";
                $savePath = $saveDir . $fileName;
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0755, true);
                }
                $icon_file = $request->file('icon');
                $icon_file->move($saveDir, $fileName);
                $category->icon = "uploads/".$db_path . $fileName;
            }
    
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->parent_category = $request->parent_category;
            $category->field_group_id = $request->fields_group;
            $category->status = $request->status;
            $category->save();
            $response['status'] = true;
            $response['message'] = "Category updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Category not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);
        if($category){
            $category->delete();
            $response['status'] = true;
            $response['message'] = "Category deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Category not found";
        }
        return response()->json($response);
    }

    public function select(Request $request){
        $items = Categories::select('id','name');
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
