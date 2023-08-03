<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\poreska_filijala;
use App\Models\poreska_inspektor;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PoreskaFilijalaController extends Controller
{
    public function index(Request $request): View
    {
        $poreske_filijale = poreska_filijala::orderBy('id','DESC')->paginate(99);

        return view('poreske_filijale.index',compact('poreske_filijale'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('poreske_filijale.create');
    }

    public function edit($id): View
    {
        $poreska_filijala = poreska_filijala::find($id);
        $poreski_inspektori = poreska_inspektor::where('poreska_filijala_id', $id)->paginate(99);
    
        return view('poreske_filijale.edit',compact('poreska_filijala','poreski_inspektori'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required|unique:knjigovodja,naziv',
            'ulica' => 'required',
            'broj_ulice' => 'required',
            'postanski_broj' => 'required',
            'mesto' => 'required',
        ]);
    
        $input = $request->all();
    
        $data = poreska_filijala::create($input);
    
        return redirect()->route('poreskafilijala.index')
                        ->with('success','Knjigovođa uspešno unešen');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'ime' => 'required|unique:knjigovodja,naziv',
            'ulica' => 'required',
            'broj_ulice' => 'required',
            'postanski_broj' => 'required',
            'mesto' => 'required',
        ]);
    
        $input = $request->all();
    
        $data = poreska_filijala::find($id);
        $data->update($input);
    
        return redirect()->route('poreskafilijala.index')
                        ->with('success','Poreska Filijala uspešno promenjena');
    }

    public function destroy($id): RedirectResponse
    {
        DB::table("poreska_filijala")->where('id',$id)->delete();
        return redirect()->route('poreskafilijala.index')
                        ->with('success','Poreska Filijala uspešno izbrisana');
    }
}
