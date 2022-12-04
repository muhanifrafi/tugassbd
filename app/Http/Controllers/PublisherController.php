<?php
    
namespace App\Http\Controllers;
    
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    
class PublisherController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:publisher-list|publisher-create|publisher-edit|publisher-delete', ['only' => ['index','show']]);
         $this->middleware('permission:publisher-create', ['only' => ['create','store']]);
         $this->middleware('permission:publisher-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:publisher-delete', ['only' => ['destroy','deletelist']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $find = $request->find;
        $publishers = DB::table('publishers')
                    ->where('nama_publisher','LIKE','%'.$find.'%')
                    ->whereNull('deleted_at')
                    ->paginate(6);
        return view('publishers.index',compact('publishers'))
            ->with('i', (request()->input('page', 1) - 1) * 6);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('publishers.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'id_publisher' => 'required',
            'nama_publisher' => 'required',
        ]);
    
        DB::insert('INSERT INTO publishers(id_publisher,nama_publisher) VALUES (:id_publisher, :nama_publisher)',
        [
            'id_publisher' => $request->id_publisher,
            'nama_publisher' => $request->nama_publisher
        ]
        );
    
        return redirect()->route('publishers.index')
                        ->with('success','Publisher created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        return view('publishers.show',compact('publisher'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rak  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publisher = DB::table('publishers')->where('id_publisher', $id)->first();
        return view('publishers.edit',compact('publisher'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
         $request->validate([
            'id_publisher' => 'required',
            'nama_publisher' => 'required',
        ]);
    
        DB::update('UPDATE publishers SET id_publisher = :id_publisher, nama_publisher = :nama_publisher WHERE id_publisher = :id',
        [
            'id' => $id,
            'id_publisher' => $request->id_publisher,
            'nama_publisher' => $request->nama_publisher,
        ]
        );
    
        return redirect()->route('publishers.index')
                        ->with('success','Rak updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::update('UPDATE publishers SET deleted_at = NOW() WHERE id_publisher = :id_publisher', ['id_publisher' => $id]);
    
        return redirect()->route('publishers.index')
                        ->with('success','Rak deleted successfully');
    }
    
    public function deletelist()
    {
        $publishers = DB::table('publishers')
                        ->whereNotNull('deleted_at')
                        ->paginate(6);
        return view('/publishers/trash',compact('publishers'))
            ->with('i', (request()->input('page', 1) - 1) * 6);

    }
    public function restore($id)
    {
        DB::update('UPDATE publishers SET deleted_at = NULL WHERE id_publisher = :id_publisher', ['id_publisher' => $id]);
        return redirect()->route('publishers.index')
                        ->with('success','Publisher Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::delete('DELETE FROM publishers WHERE id_publisher=:id_publisher', ['id_publisher' => $id]);
        return redirect()->route('publishers.index')
                        ->with('success','Publisher Deleted Permanently');
    }
}