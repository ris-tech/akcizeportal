<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kvartali;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KvartaliController extends Controller
{
    public function index(Request $request): View
    {
        $kvartali = Kvartali::orderBy('od','desc')->paginate(99);
        
        
        return view('kvartali.index',compact('kvartali'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('kvartali.create');
    }

    public function edit($id): View
    {
        $kvartali = Kvartali::find($id);
    
        return view('kvartali.edit',compact('kvartali'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'godina' => 'required',
            'kvartal' => 'required',
            'od' => 'required',
            'do' => 'required'

        ]);
    
        $input = $request->all();
    
        $kvartali = Kvartali::create($input);
    
        return redirect()->route('kvartali.index')
                        ->with('success','Kvartal uspešno unešen');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'godina' => 'required',
            'kvartal' => 'required',
            'od' => 'required',
            'do' => 'required'
        ]);
    
        $input = $request->all();
    
        $user = Kvartali::find($id);
        $user->update($input);
    
        return redirect()->route('kvartali.index')
                        ->with('success','Kvartal uspešno promenjen');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("kvartali")->where('id',$id)->delete();
        return redirect()->route('kvartali.index')
                        ->with('success','Kvartal uspešno izbrisan');
    }
}
