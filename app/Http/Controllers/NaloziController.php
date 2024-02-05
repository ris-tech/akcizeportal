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
use Illuminate\Support\Facades\Validator;
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
        $nalozi = Nalozi::where('klijent_id', $id)
                    ->with('skener_ulazne_fakture')
                    ->with('skener_izlazne_fakture')
                    ->with('skener_izvodi')
                    ->with('skener_kompenzacije')
                    ->with('skener_knjizna_odobrenja')
                    ->with('unosilac')
                    ->with('kvartal')
                    ->get();

        return view('Nalozi.index',compact('nalozi'), $data);
    }
    public function index(Request $request): View
    {
        $data = [
            'id' => $request->id
        ];
        $nalozi = Nalozi::
                  with('skener_ulazne_fakture')
                ->with('skener_izlazne_fakture')
                ->with('skener_izvodi')
                ->with('skener_kompenzacije')
                ->with('skener_knjizna_odobrenja')
                ->with('unosilac')
                ->with('gorivo')
                ->with('kvartal')
                ->get();

        $goriva = Gorivo::get();
        $kvartali = Kvartali::where('godina', date('Y'))->get();
        $users = User::get();
        

        return view('Nalozi.index',compact('nalozi', 'goriva', 'kvartali', 'users'), $data)
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
        
        
        $nalozi = Nalozi::where('id', $id)
                ->with('skener_ulazne_fakture')
                ->with('skener_izlazne_fakture')
                ->with('skener_izvodi')
                ->with('skener_kompenzacije')
                ->with('skener_knjizna_odobrenja')
                ->with('unosilac')
                ->with('kvartal')
                ->first();
        
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
                if (in_array('evrodizel',$request->gorivo)) {
                    $crt_nalog->evrodizel = 1;
                } else {
                    $crt_nalog->evrodizel = NULL;
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

            if(isset($request->taxi)) {
                $crt_nalog->taxi = true;
            }
            
            $crt_nalog->tng = $request->tng;
            $crt_nalog->skener_ulazne_fakture_id = $request->skener_ulazne_fakture_id;
            $crt_nalog->skener_izlazne_fakture_id = $request->skener_izlazne_fakture_id;
            $crt_nalog->skener_izvodi_id = $request->skener_izvodi_id;
            $crt_nalog->skener_kompenzacije_id = $request->skener_kompenzacije_id;
            $crt_nalog->skener_knjizna_odobrenja_id = $request->skener_knjizna_odobrenja_id;
            $crt_nalog->unosilac_id = $request->unosilac_id;
            $crt_nalog->dokumentacija_in = $request->dokumentacija_in;
            $crt_nalog->dokumentacija_in_komentar = $request->dokumentacija_in_komentar;
            $crt_nalog->dokumentacija_out = $request->dokumentacija_out;
            $crt_nalog->dokumentacija_out_komentar = $request->dokumentacija_out_komentar;

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
        //dd($request);
        $nalog = Nalozi::where('id', $id);
        if (isset($request->gorivo)) {
            //dd($request->gorivo);
            if (in_array('evrodizel',$request->gorivo)) {
                $evrodizel = 1;
            } else {
                $evrodizel = NULL;
            }
            if (in_array('tng',$request->gorivo)) {
                $tng = 1;
            } else {
                $tng = NULL;
            }           
        } else {
            return back()
            ->withInput()
            ->withErrors(['Gorivo nije izabrano']);
        }
        $taxi = false;
        if(isset($request->taxi)) {
            $taxi = true;
        }
        
        Nalozi::where('id', $id)->update(
            [
                "kvartal_id" => $request->kvartal_id,
                "evrodizel" => $evrodizel,
                "tng" => $tng,
                "taxi" => $taxi,
                "skener_ulazne_fakture_id" => $request->skener_ulazne_fakture_id,
                "skener_izlazne_fakture_id" => $request->skener_izlazne_fakture_id,
                "skener_izvodi_id" => $request->skener_izvodi_id,
                "skener_kompenzacije_id" => $request->skener_kompenzacije_id,
                "skener_knjizna_odobrenja_id" => $request->skener_knjizna_odobrenja_id,
                "unosilac_id" => $request->unosilac_id,
                "kvartal_id" => $request->kvartal_id,
                "dokumentacija_in" => $request->dokumentacija_in,
                "dokumentacija_in_komentar" => $request->dokumentacija_in_komentar,
                "dokumentacija_out" => $request->dokumentacija_out,
                "dokumentacija_out_komentar" => $request->dokumentacija_out_komentar,
            ]
        ); 
    
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