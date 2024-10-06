<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Fields;

class FieldsController extends InitController
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $this->data['page_title'] = "Fields";
        $this->data['field_group_id'] = $id;

        return view('fields.list', $this->data);
    }

    /**
     * Display a listi Data of the resource.
     */
    public function data(Request $request, string $id)
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

        $query = Fields::select(Fields::raw('id'));
        $query = $query->where('field_group_id', $id);
        if (!empty($searchValue)) {
            $query->where('label','like','%'.$searchValue.'%');
            $query->where('machine_name','like','%'.$searchValue.'%');
        }
        $totalcount = $query->count();
        $query->select(Fields::raw('id, label, machine_name, placeholder, required, default_value, options, created_by, created_at, updated_at'));
        $query->with(['created_user']);
        $query->skip($start)->take($rowPerPage);
        $query->orderBy($columnName, $columnSortOrder);
        $rows = $query->get();


        $fields = [];
        foreach($rows as $row){
            $temp['id'] = $row->id;
            $temp['label'] = $row->label;
            $temp['machine_name'] = $row->machine_name;
            $temp['placeholder'] = $row->placeholder;
            $temp['required'] = $row->required;
            $temp['default_value'] = $row->default_value;
            $temp['options'] = '';
            if($row->options != ""){
                $options = json_decode($row->options,TRUE);
                if(count($options)>0){
                    $temp['options'] .= "<ul>";
                    foreach($options as $option){
                        $temp['options'] .= "<li>".$option['text']."</li>";
                    }
                    $temp['options'] .= "</ul>";
                }
            }
            $temp['created_by'] = $row->created_user->name;
            $temp['created_at'] = $row->created_at->format('d-M-Y H:i');
            $temp['updated_at'] = $row->updated_at->format('d-M-Y H:i');
            $temp['actions'] = '<div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item edit-item-btn field-edit" href="'.route('field_groups.fields.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn field-delete" href="'.route('field_groups.fields.delete',$row->id).'"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>';
            $fields[] =  $temp;
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalcount,
            "recordsFiltered" => $totalcount,
            "data" => $fields,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.+
     */
    public function create($id)
    {
        $response['status'] = true;
        $response['message'] = "Page found";
        $this->data['field_group_id'] = $id;
        $response['body'] = view('fields.add', $this->data)->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $validate_option['label'] = 'required|max:255';
        $validate_option['machine_name'] = 'required|unique:fields|max:255';
        $validate_option['type'] = 'required|max:255';
        $validate_option['required'] = 'required|max:255';
        $validated = $request->validate($validate_option);


        $field = new Fields;
        $field->field_group_id = $request->id;
        $field->label = $request->label;
        $field->machine_name = $request->machine_name;
        $field->type = $request->type;
        $field->placeholder = $request->placeholder;
        $field->required = $request->required;
        $check_options = explode('~,~', $request->options);
        $options = array();
        foreach($check_options as $check_option){
            if($check_option != ""){
                $option['value'] = $check_option;
                $option['text'] = $check_option;
                $options[] = $option;
            }
        }
        $field->options = json_encode($options);
        $field->created_by  = $this->data['auth']->id;
        $field->save();
        $response['status'] = true;
        $response['message'] = "New field added";
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
        $this->data['field'] = Fields::find($id);
        if($this->data['field']){
            $response['body'] = view('fields.edit', $this->data)->render();
            $response['status'] = true;
            $response['message'] = "Record found";
        }
        else{
            $response['message'] = "Field not found";
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate_option['label'] = 'required|max:255';
        $validate_option['machine_name'] = 'required|unique:fields,machine_name,' . $id . '|max:255';
        $validate_option['type'] = 'required|max:255';
        $validate_option['required'] = 'required|max:255';
        $validated = $request->validate($validate_option);

        $field = Fields::find($id);
        if($field){
            $field->label = $request->label;
            $field->machine_name = $request->machine_name;
            $field->type = $request->type;
            $field->placeholder = $request->placeholder;
            $field->required = $request->required;
            $check_options = explode('~,~', $request->options);
            $options = array();
            foreach($check_options as $check_option){
                if($check_option != ""){
                    $option['value'] = $check_option;
                    $option['text'] = $check_option;
                    $options[] = $option;
                }
            }
            $field->options = json_encode($options);
            $field->created_by  = $this->data['auth']->id;
            $field->save();
            $response['status'] = true;
            $response['message'] = "Field updated";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Field not found";
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Fields::find($id);
        if($field){
            $field->delete();
            $response['status'] = true;
            $response['message'] = "Field deleted";
        }
        else{
            $response['status'] = false;
            $response['message'] = "Field not found";
        }
        return response()->json($response);
    }

}
