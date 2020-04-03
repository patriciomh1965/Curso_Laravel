<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MovProductos;
use DB;

class Productos extends Model
{
    protected $table = 'sys_10_producto';
    protected $primaryKey='id_producto';

    public function GetStock($id){
    	$data= MovProductos::select(DB::raw('sum(cantidad) as total'))->where('id_producto',$id)->first();
    	if($data)
    	{
    		return $data->total;
    	}else{
    		return '0';
    	}	
    }
    public function Categorias(){
    	return $this->belongsTo('App\Models\Categorias','id_categoria');
    }
}
