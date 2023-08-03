<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\knjigovodja;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KnjigovodjaController extends Controller
{
    public function index(Request $request): View
    {
        $knjigovodje = knjigovodja::orderBy('id','DESC')->paginate(99);
        
        
        return view('knjigovodja.index',compact('knjigovodje'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('knjigovodja.create');
    }

    public function edit($id): View
    {
        $knjigovodja = knjigovodja::find($id);
    
        return view('knjigovodja.edit',compact('knjigovodja'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'naziv' => 'required|unique:knjigovodja,naziv',
            'telefon' => 'required'
        ]);
    
        $input = $request->all();
    
        $user = knjigovodja::create($input);
    
        return redirect()->route('knjigovodja.index')
                        ->with('success','Knjigovođa uspešno unešen');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'naziv' => 'required',
            'telefon' => 'required'
        ]);
    
        $input = $request->all();
    
        $user = knjigovodja::find($id);
        $user->update($input);
    
        return redirect()->route('knjigovodja.index')
                        ->with('success','Knigovođa uspešno promenjen');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("knjigovodja")->where('id',$id)->delete();
        return redirect()->route('knjigovodja.index')
                        ->with('success','Knjigovodja uspešno izbrisan');
    }
}
