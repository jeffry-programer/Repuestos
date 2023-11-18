<?php

namespace App\Http\Livewire\LaravelExamples;

use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserManagement extends Component
{

    protected $listeners = ['deleteUser'];

    public function render()
    {
        $name_label = explode("/", $_SERVER['REQUEST_URI'])[2];
        $name_label = str_replace("_", " ", $name_label);
        $name_table = Table::where('label', $name_label)->first()->name;
        $data = DB::table($name_table)->get();
        $label = Table::where('name',$name_table)->first()->label;
        $atributes = Schema::getColumnListing($name_table);
        $extra_data = [];
        foreach($atributes as $field){
            if(str_contains($field, '_id')){
                $table = explode("_", $field)[0];
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
        foreach($data as $key){
            if($key != $request->label && $key != $request->_token){
                if($count == 0){
                    $query .= "'".$key."'";
                }else{
                    $query .= ",'".$key."'";
                }
                $count++;
            }
        }
        $date = Carbon::now();
        $query .= ",'".$date."')";
        DB::insert($query);
        session()->flash('message', 'Registro agregado exitosamente!!');
        return redirect('/table-management/'.$request->label);
    }

    public function delete(Request $request){
        $name_table = Table::where('label', $request->label)->first()->name;
        $query = "delete from $name_table where id = $request->id";
        DB::delete($query);
        session()->flash('message', 'Registro eliminado exitosamente!!');
        return redirect('/table-management/'.$request->label);
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
                    $query .= "$field = '".$data[$field]."'";
                }else{
                    $query .= ", $field = '".$data[$field]."'";
                }
            }
        }
        $query .= "where id = $request->id";
        DB::update($query);
        session()->flash('message', 'Registro editado exitosamente!!');
        return redirect('/table-management/'.$request->label);
    }
}
