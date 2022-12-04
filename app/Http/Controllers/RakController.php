<?php
    
namespace App\Http\Controllers;
    
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
    
class RakController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:rak-list|rak-create|rak-edit|rak-delete', ['only' => ['index','show']]);
         $this->middleware('permission:rak-create', ['only' => ['create','store']]);
         $this->middleware('permission:rak-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:rak-delete', ['only' => ['destroy','deletelist']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $rak = DB::table('raks')
                ->where('name','LIKE','%'.$search.'%')
                ->whereNull('deleted_at')
                ->paginate(6);
        return view('raks.index',compact('rak'))
            ->with('i', (request()->input('page', 1) - 1) * 6);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('raks.create');
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
            'id_rak' => 'required',
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        DB::insert('INSERT INTO raks(id_rak,name,detail) VALUES (:id_rak, :name,:detail)',
        [
            'id_rak' => $request->id_rak,
            'name' => $request->name,
            'detail' => $request->detail,
        ]);
    
        return redirect()->route('raks.index')
                        ->with('success','Rak created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $rak
     * @return \Illuminate\Http\Response
     */
    public function show(Rak $rak)
    {
        return view('raks.show',compact('rak'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rak = DB::table('raks')->where('id_rak', $id)->first();
        return view('raks.edit',compact('rak'));
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
         request()->validate([
            'id_rak' => 'required',
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        DB::update('UPDATE raks SET id_rak = :id_rak, name = :name,detail = :detail  WHERE id_rak = :id',
        [
            'id' => $id,
            'id_rak' => $request->id_rak,
            'name' => $request->name,
            'detail' => $request->detail,
        ]);
    
        return redirect()->route('raks.index')
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
        DB::update('UPDATE raks SET deleted_at = NOW() WHERE id_rak = :id_rak', ['id_rak' => $id]);
    
        return redirect()->route('raks.index')
                        ->with('success','Rak deleted successfully');
    }
    
    public function deletelist()
    {
        $rak = DB::table('raks')
                ->whereNotNull('deleted_at')
                ->paginate(6);
        return view('/raks/trash',compact('rak'))
            ->with('i', (request()->input('page', 1) - 1) * 6);

    }
    public function restore($id)
    {
        DB::update('UPDATE raks SET deleted_at = NULL WHERE id_rak = :id_rak', ['id_rak' => $id]);
        return redirect()->route('raks.index')
                        ->with('success','Rak Restored successfully');
    }
    public function deleteforce($id)
    {
        DB::delete('DELETE FROM raks WHERE id_rak=:id_rak', ['id_rak' => $id]);
        return redirect()->route('raks.index')
                        ->with('success','Rak Deleted Permanently');
    }
}