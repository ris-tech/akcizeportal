<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banke;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BankeController extends Controller
{
    public function index(Request $request): View
    {
        $banke = Banke::orderBy('id','DESC')->paginate(99);
        
        
        return view('banke.index',compact('banke'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('banke.create');
    }

    public function edit($id): View
    {
        $banke = Banke::find($id);
    
        return view('banke.edit',compact('banke'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required|unique:banke,ime'
        ]);
    
        $input = $request->all();
    
        $user = Banke::create($input);
    
        return redirect()->route('banke.index')
                        ->with('success','Banka uspešno unešena');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required|unique:banke,ime'
        ]);
    
        $input = $request->all();
    
        $data = Banke::find($id);
        $data->update($input);
    
        return redirect()->route('banke.index')
                        ->with('success','Banka uspešno promenjena');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("banke")->where('id',$id)->delete();
        return redirect()->route('banke.index')
                        ->with('success','Banka uspešno izbrisana');
    }
}
