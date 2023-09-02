<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gorivo;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GorivoController extends Controller
{
    public function index(Request $request): View
    {
        $goriva = Gorivo::orderBy('id','DESC')->paginate(99);
        
        
        return view('gorivo.index',compact('goriva'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('gorivo.create');
    }

    public function edit($id): View
    {
        $goriva = Gorivo::find($id);
    
        return view('gorivo.edit',compact('goriva'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required'
        ]);
    
        $input = $request->all();
    
        $gorivo = Gorivo::create($input);
    
        return redirect()->route('gorivo.index')
                        ->with('success','Gorivo uspešno unešen');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required'
        ]);
    
        $input = $request->all();
    
        $user = Gorivo::find($id);
        $user->update($input);
    
        return redirect()->route('gorivo.index')
                        ->with('success','Gorivo uspešno promenjen');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("gorivo")->where('id',$id)->delete();
        return redirect()->route('gorivo.index')
                        ->with('success','Gorivo uspešno izbrisan');
    }
}
