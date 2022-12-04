<?php
    
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JoinController extends Controller
{
    public function index()
    {
        $joins = DB::table('products')
            ->join('raks', 'products.no_rak', '=', 'raks.id_rak')
            ->join('publishers', 'products.no_publisher', '=', 'publishers.id_publisher')
            ->select('products.name as nama', 'products.detail as detail', 'raks.name as rak_name','publishers.nama_publisher as nama_publisher')
            ->whereNull('products.deleted_at')
            ->paginate(6);
            return view('totals.index',compact('joins'))
                ->with('i', (request()->input('page', 1) - 1) * 6);
    }
}