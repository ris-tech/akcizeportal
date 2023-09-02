<?php

namespace App\Http\Controllers;

use App\Models\Fajlovi;
use App\Models\Gorivo;
use App\Models\Kvartali;
use App\Models\Nalozi;
use App\Models\Pozicije;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class NaloziController extends Controller
{
    public function __invoke()
    {
        //
    }
    public function show($id): View
    {
        $data = [
            'id' => $id
        ];
        $nalozi = Nalozi::where('klijent_id', $id)->get();
       
        $nalozi->load('skener');
        $nalozi->load('unosilac');
        //
        $nalozi->load('kvartal');
        //dd($nalozi);

        return view('Nalozi.index',compact('nalozi'), $data);
    }
    public function index(Request $request): View
    {
        $nalozi = Nalozi::paginate(99);
        
        $nalozi->load('skener');
        $nalozi->load('unosilac');
        $nalozi->load('gorivo');
        $nalozi->load('kvartal');

        $goriva = Gorivo::get();
        $kvartali = Kvartali::where('godina', date('Y'))->get();
        $users = User::get();
        

        return view('Nalozi.index',compact('nalozi', 'goriva', 'kvartali', 'users'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(Request $request): View
    {
        $data = [
            'id' => $request->id
        ];
        $goriva = Gorivo::get();
        $kvartali = Kvartali::where('godina', date('Y'))->get();
        $users = User::get();

        return view('Nalozi.create',compact('kvartali','goriva','users'), $data);
    }

    public function getKvartali(Request $request): JsonResponse
    {
        $godina = $request->godina;
        $kvartali = Kvartali::where('godina', $godina)->get();

        return response()->json($kvartali);
    }
    

    public function edit($id): View
    {
        
        
        $nalozi = Nalozi::find($id)->first();

        $nalozi->load('skener');
        $nalozi->load('unosilac');
        $nalozi->load('kvartal');
        $kvartali = Kvartali::where('godina', $nalozi->kvartal['godina'])->get();
        $users = User::get();

        return view('Nalozi.edit',compact('nalozi', 'kvartali', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        
        //dd($request);
        $input = $request->all();

        $nalozi = Nalozi::where('klijent_id', $request->klijent_id)
        ->where('kvartal_id', $request->kvartal_id)->get();
        if ($nalozi->isEmpty()) {
            //dd($request);
            $crt_nalog = new Nalozi;
            $crt_nalog->klijent_id = $request->klijent_id;
            $crt_nalog->kvartal_id = $request->kvartal_id;
            if (isset($request->gorivo)) {
                if (in_array('eurodizel',$request->gorivo)) {
                    $crt_nalog->eurodizel = 1;
                } else {
                    $crt_nalog->eurodizel = NULL;
                }
                if (in_array('tng',$request->gorivo)) {
                    $crt_nalog->tng = 1;
                } else {
                    $crt_nalog->tng = NULL;
                }   
            } else {
                return back()
                ->withInput()
                ->withErrors(['Gorivo nije izabrano']);
            }
            
            $crt_nalog->tng = $request->tng;
            $crt_nalog->skener_id = $request->skener_id;
            $crt_nalog->unosilac_id = $request->unosilac_id;

            $crt_nalog->save();

            return redirect()->route('nalozi.show', ['nalozi' => $request->klijent_id])
                        ->with('success','Nalog uspešno unešen');
        } else {
            return redirect()->route('nalozi.show', ['nalozi' => $request->klijent_id])
                        ->with('error','Nalog za taj kvartal već kreiran');
        }

        
    }

    public function update(Request $request, $id): RedirectResponse
    {
        
        $input = $request->all();
    
        $nalog = Nalozi::find($id);
        if (isset($request->gorivo)) {
            //dd($request->gorivo);
            if (in_array('eurodizel',$request->gorivo)) {
                $nalog->eurodizel = 1;
            } else {
                $nalog->eurodizel = NULL;
            }
            if (in_array('tng',$request->gorivo)) {
                $nalog->tng = 1;
            } else {
                $nalog->tng = NULL;
            }           
        } else {
            return back()
            ->withInput()
            ->withErrors(['Gorivo nije izabrano']);
        }
        $nalog->update($input);
    
        return redirect()->route('nalozi.show', ['nalozi' => $request->klijent_id])
                        ->with('success','Dobavljač uspešno promenjen');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        Fajlovi::where('nalog_id', $id)->delete();
        Pozicije::where('nalog_id',$id)->delete();
        $Nalozi = Nalozi::find($id);
        $Nalozi->delete();
        return redirect()->route('nalozi.show', ['nalozi' => $request->klijent_id])
                        ->with('success','Nalog uspešno izbrisan');
    }
}