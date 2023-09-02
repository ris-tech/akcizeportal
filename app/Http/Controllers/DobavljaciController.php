<?php

namespace App\Http\Controllers;

use App\Models\Dobavljaci;
use Illuminate\Http\Request;
use App\Models\Gorivo;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DobavljaciController extends Controller
{
    public function index(Request $request): View
    {
        $dobavljaci = Dobavljaci::orderBy('ime','ASC')->paginate(99);
        
        
        return view('dobavljaci.index',compact('dobavljaci'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('dobavljaci.create');
    }

    public function edit($id): View
    {
        $dobavljaci = Dobavljaci::find($id);
    
        return view('dobavljaci.edit',compact('dobavljaci'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required'
        ]);
    
        $input = $request->all();
    
        $dobavljaci = Dobavljaci::create($input);
    
        return redirect()->route('dobavljaci.index')
                        ->with('success','Dobavljač uspešno unešen');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required'
        ]);
    
        $input = $request->all();
    
        $dobavljac = Dobavljaci::find($id);
        $dobavljac->update($input);
    
        return redirect()->route('dobavljaci.index')
                        ->with('success','Dobavljač uspešno promenjen');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("dobavljaci")->where('id',$id)->delete();
        return redirect()->route('dobavljaci.index')
                        ->with('success','Dobavljač uspešno izbrisan');
    }
}
