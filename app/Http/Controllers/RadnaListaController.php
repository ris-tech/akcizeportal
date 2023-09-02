<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use App\Models\Klijenti;
use App\Models\Banke;
use App\Models\Dobavljaci;
use App\Models\poreska_filijala;
use Illuminate\Http\RedirectResponse;
use App\Models\OdgovornoLice;
use App\Models\knjigovodja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Dokumenta;
use App\Models\Fajlovi;
use App\Models\Nalozi;
use App\Models\Pozicije;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class RadnaListaController extends Controller
{
    function __construct()
    {
         //
    }

    public function index(Request $request): View
    {
        $nalozi = Nalozi::where([
                ['skener_id', '=', Auth::user()->id],
                ['sken_gotov', '=', 0]
            ])
                ->orWhere([
                    ['unosilac_id', '=', Auth::user()->id],
                    ['unos_gotov', '=', 0],
                ])
                ->get();

                $nalozi->load('skener');
                $nalozi->load('unosilac');
                $nalozi->load('kvartal');

        return view('radnalista.index',compact('nalozi'));
    }

    public function scan($id): View
    {
        
        $nalozi = Nalozi::where('id',$id)->first();
        //dd($nalozi);
        if($nalozi) {
            $klijent_pod = Klijenti::find($nalozi->klijent_id);
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            $data = [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path
            ];

            $fajlovi = Fajlovi::where('nalog_id',$id)->get();
            $poreska_filijala = poreska_filijala::find($klijent_pod->poreska_filijala_id)->first();
                    $nalozi->load('klijent');
                    $nalozi->load('skener');
                    $nalozi->load('unosilac');
                    $nalozi->load('kvartal');

            return view('radnalista.scan', compact('nalozi','poreska_filijala','fajlovi'), $data);
        } else {
            $data = [
                'resp' => false
            ];
            return view('radnalista.scan', $data);
        }
    }

    public function storeFiles(Request $request): JsonResponse
    {
        //dd($request);
        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;
        
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = public_path('storage/'.$hiddenFolder.'/'.$request->nalog_id.'/');
        if (!is_dir($dokumenta_path)) {
            mkdir($dokumenta_path, 0777, true );
        }

        $image = $request->file('file');
        $imageName = Uuid::uuid4().'.'.$image->extension();
        $image->move($dokumenta_path,$imageName);

        $fajlovi = new Fajlovi;

        $fajlovi->nalog_id = $request->nalog_id;
        $fajlovi->fajl = $imageName;

        $fajlovi->save();

        return response()->json(['file'=>$imageName]);
    }

    public function deleteFile(Request $request): JsonResponse
    {
        Fajlovi::where('nalog_id', $request->nalog_id)
                    ->where('fajl', $request->fajl)
                    ->update(['aktivan' => 0]);

        return response()->json(['success'=>'true']);
    }

    public function retrieveFile(Request $request): JsonResponse
    {
        Fajlovi::where('nalog_id', $request->nalog_id)
                    ->where('fajl', $request->fajl)
                    ->update(['aktivan' => 1]);

        return response()->json(['success'=>'true']);
    }

    public function finishScan(Request $request): RedirectResponse
    {
        $upd = Nalozi::where('id', $request->nalog_id)
                ->update(['sken_gotov' => 1]);

        $nalozi = Nalozi::where('skener_id', '=', Auth::user()->id)
        ->orWhere('unosilac_id', '=', Auth::user()->id)->get();

        $nalozi->load('skener');
        $nalozi->load('unosilac');
        $nalozi->load('kvartal');
        return redirect()->route('radnalista.index');
    }

    public function tabela($id): View
    {
        
        $nalozi = Nalozi::where('id',$id)->first();
        $pozicije = Pozicije::where('nalog_id', $id)->get();
        $suma = DB::table('pozicije')
                ->where('nalog_id', $id)
                ->select(DB::raw('vozila, SUM(iznos) iznos_goriva, SUM(kolicina) as kol_goriva'))
                ->groupBy('vozila')
                ->get();
        
        //dd($nalozi);
        if($nalozi) {
            $klijent_pod = Klijenti::find($nalozi->klijent_id);
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            $data = [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path,
                'pos' => 1,
                'sumpos' => 1
            ];
            $dobavljaci = Dobavljaci::get();
            $fajlovi = Fajlovi::where('nalog_id',$id)->get();
            $poreska_filijala = poreska_filijala::find($klijent_pod->poreska_filijala_id)->first();
                    $nalozi->load('klijent');
                    $nalozi->load('skener');
                    $nalozi->load('unosilac');
                    $nalozi->load('kvartal');

            return view('radnalista.tabela', compact('nalozi','pozicije','suma', 'poreska_filijala','fajlovi','dobavljaci'), $data);
        } else {
            $data = [
                'resp' => false
            ];
            return view('radnalista.tabela', $data);
        }
    }

    public function extImg($id): View
    {
        
        $nalozi = Nalozi::where('id',$id)->first();
        //dd($nalozi);
        if($nalozi) {
            $klijent_pod = Klijenti::find($nalozi->klijent_id);
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            $data = [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path,
                'i' => 0
            ];
            $fajlovi = Fajlovi::where('nalog_id',$id)->get();

            return view('radnalista.extImg', compact('nalozi','fajlovi'), $data);
        } else {
            $data = [
                'resp' => false
            ];
            return view('radnalista.extImg', $data);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        Pozicije::where('nalog_id', $request->nalog_id)->delete();
        $nalog_id = $request->nalog_id;
        $datum = $request->datum;
        $br_fakture = $request->br_fakture;
        $gorivo = $request->gorivo;
        $dobavljac = $request->dobavljac;
        $iznos = $request->iznos;
        $kolicina = $request->kolicina;
        $reg_vozila = $request->reg_vozila;


        for($i=0;$i<count($datum);$i++){
            $datasave = [
                'nalog_id'=>$nalog_id,
                'datum_fakture'=>$datum[$i],
                'broj_fakture'=>$br_fakture[$i],
                'gorivo'=>$gorivo[$i],
                'dobavljac_id'=>$dobavljac[$i],
                'iznos'=>str_replace(',', '.', $iznos[$i]),
                'kolicina'=>str_replace(',', '.', $kolicina[$i]),
                'vozila'=>$reg_vozila[$i],
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" =>  \Carbon\Carbon::now()
    
            ];
            Pozicije::insert($datasave);
        }
        return redirect()->route('radnalista.tabela', ['id' => $nalog_id])
                        ->with('success','Sačuvano');
    }

}
