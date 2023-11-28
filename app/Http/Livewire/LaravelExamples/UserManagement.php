<?php

namespace App\Http\Livewire\LaravelExamples;

use App\Models\AditionalPicturesProduct;
use App\Models\Product;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class UserManagement extends Component
{

    protected $listeners = ['deleteUser'];

    public function render(){
        $name_label = explode("/", $_SERVER['REQUEST_URI'])[2];
        $name_label = str_replace("_", " ", $name_label);
        $name_label = str_replace("%20", " ", $name_label);
        $name_table = Table::where('label', $name_label)->first()->name;
        if($name_table == 'products'){
            $data = Product::all();
        }else{
            $data = DB::table($name_table)->get();
        }
        $label = Table::where('name',$name_table)->first()->label;
        $atributes = Schema::getColumnListing($name_table);
        $extra_data = [];
        foreach($atributes as $field){
            if(str_contains($field, '_id')){
                $table = explode("_id", $field)[0];
                $extra_data[$field]['fields'] = Schema::getColumnListing($table);
                $extra_data[$field]['values'] = DB::table($table)->get();
            }
        }
        return view('livewire.laravel-examples.user-management', ['data' => $data, 'label' => $label, 'atributes' => $atributes, 'extra_data' => $extra_data]);
    }

    public function store(Request $request){
        $name_table = Table::where('label', $request->label)->first()->name;
        $atributes = Schema::getColumnListing($name_table);
        $data = $request->all();
        $query = 'insert into '.$name_table. ' (';
        $count = 0;
        $image = false;
        foreach($atributes as $field){
            if($field != 'created_at' && $field != 'updated_at' && $field != 'id'){
                if($count == 0){
                    $query .= $field;
                }else{
                    $query .= ','.$field;
                }
                $count++;
            }
        }
        $query .= ',created_at) values (';
        $count = 0;
        foreach($atributes as $field){
            if($field != 'id' && $field != 'created_at' && $field != 'updated_at'){
                if($field == 'image'){
                    $image = true;
                    $data[$field] = '';
                } 
                if($data[$field] != $request->label && $data[$field] != $request->_token){
                    if($count == 0){
                        $query .= "'".$data[$field]."'";
                    }else{
                        $query .= ",'".$data[$field]."'";
                    }
                    $count++;
                }
            }
        }
        $date = Carbon::now();
        $query .= ",'".$date."')";
        DB::insert($query);
        session()->flash('message', 'Registro agregado exitosamente!!');
        return redirect('/table-management/'.str_replace(' ','_', $request->label));
    }

    public function store2(Request $request){
        $name_table = Table::where('label', $request->label)->first()->name;
        $atributes = Schema::getColumnListing($name_table);
        $data = $request->all();
        $query = 'insert into '.$name_table. ' (';
        $count = 0;
        $image = false;
        foreach($atributes as $field){
            if($field != 'created_at' && $field != 'updated_at' && $field != 'id'){
                if($count == 0){
                    $query .= $field;
                }else{
                    $query .= ','.$field;
                }
                $count++;
            }
        }
        $query .= ',created_at) values (';
        $count = 0;
        foreach($atributes as $field){
            if($field != 'id' && $field != 'created_at' && $field != 'updated_at'){
                if($field == 'image'){
                    $image = true;
                    $data[$field] = '';
                } 
                if($data[$field] != $request->label && $data[$field] != $request->_token){
                    if($count == 0){
                        $query .= "'".$data[$field]."'";
                    }else{
                        $query .= ",'".$data[$field]."'";
                    }
                    $count++;
                }
            }
        }
        $date = Carbon::now();
        $query .= ",'".$date."')";
        DB::insert($query);
        $id = DB::table($name_table)->latest('id')->first()->id;
        return json_encode($name_table.'-'.$id);
    }

    public function delete(Request $request){
        $name_table = Table::where('label', $request->label)->first()->name;
        $query = "delete from $name_table where id = $request->id";
        DB::delete($query);
        session()->flash('message', 'Registro eliminado exitosamente!!');
        return redirect('/table-management/'.str_replace(' ','_', $request->label));
    }

    public function update(Request $request){
        $name_table = Table::where('label', $request->label)->first()->name;
        $atributes = Schema::getColumnListing($name_table);
        $data = $request->all();
        $query = 'update '.$name_table. ' set ';
        $count = 0;
        foreach($atributes as $field){
            if($field != 'created_at' && $field != 'updated_at' && $field != 'id'){
                if($count == 0){
                    $query .= "$field = '".$data[$field]."' ";
                }else{
                    $query .= ", $field = '".$data[$field]."' ";
                }
                $count++;
            }
        }
        $query .= "where id = $request->id";
        DB::update($query);
        session()->flash('message', 'Registro editado exitosamente!!');
        return redirect('/table-management/'.str_replace(' ','_', $request->label));
    }

    public function saveImgs(Request $request){
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);

        $route_image = $request->file('file')->store('public/images-prod/'.$request->id);

        $url = Storage::url($route_image);

        $image = DB::table($request->table)->find($request->id);

        if($image->image == ''){
            $query = "update $request->table set image = '$url' where id = $request->id";
            DB::update($query);
        }else{
            $image = new AditionalPicturesProduct();
            $image->products_id = $request->id;
            $image->image = $url;
            $image->created_at = Carbon::now();
            $image->save();
        }
    }

    public function updateImgs(Request $request){

    }
}
