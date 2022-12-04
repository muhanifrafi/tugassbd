<?php
    
namespace App\Http\Controllers;
    
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    
class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy','deletelist']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $products = DB::table('products')
                    ->where('name','LIKE','%'.$keyword.'%')
                    ->whereNull('deleted_at')
                    ->paginate(6);
        return view('products.index',compact('products'))
                ->with('i', (request()->input('page', 1) - 1) * 6);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_game' => 'required',
            'name' => 'required',
            'detail' => 'required',
            'no_rak' => 'required',
            'no_publisher' => 'required',
        ]);
    
        DB::insert('INSERT INTO products(id_game,name,detail,no_rak, no_publisher) VALUES (:id_game, :name,:detail ,:no_rak, :no_publisher)',
        [
            'id_game' => $request->id_game,
            'name' => $request->name,
            'detail' => $request->detail,
            'no_rak' => $request->no_rak,
            'no_publisher' => $request->no_publisher,
        ]
        );
    
        return redirect()->route('products.index')
                        ->with('success','Game created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = DB::table('products')->where('id_game', $id)->first();
        return view('products.edit',compact('product'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
         $request->validate([
            'id_game' => 'required',
            'name' => 'required',
            'detail' => 'required',
            'no_rak' => 'required',
            'no_publisher' => 'required'
        ]);
       //$game->update($request->all());
        DB::update('UPDATE products SET id_game = :id_game, name = :name,detail = :detail ,no_rak = :no_rak, no_publisher = :no_publisher WHERE id_game = :id',
        [
            'id' => $id,
            'id_game' => $request->id_game,
            'name' => $request->name,
            'detail' => $request->detail,
            'no_rak' => $request->no_rak,
            'no_publisher' => $request->no_publisher,
           
        ]
        );
        return redirect()->route('products.index')
                        ->with('success','Game updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::update('UPDATE products SET deleted_at = NOW() WHERE id_game = :id_game', ['id_game' => $id]);
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
    
    public function deletelist()
    {
        $products = DB::table('products')
                    ->whereNotNull('deleted_at')
                    ->paginate(6);
        return view('/products/trash',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 6);

    }
    public function restore($id)
    {
        DB::update('UPDATE products SET deleted_at = NULL WHERE id_game = :id_game', ['id_game' => $id]);
        return redirect()->route('products.index')
                        ->with('success','Product Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::delete('DELETE FROM products WHERE id_game=:id_game', ['id_game' => $id]);
        return redirect()->route('products.index')
                        ->with('success','Product Deleted Permanently');
    }
}