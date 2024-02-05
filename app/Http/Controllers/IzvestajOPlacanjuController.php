<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use App\Models\Banke;
use App\Models\Nalozi;
use App\Models\Pozicije;
use App\Models\izvestaj_o_placanju;
use App\Models\Klijenti;
use App\Models\Dobavljaci;
use App\Models\poreska_filijala;
use App\Models\Fajlovi;
use App\Models\izvestaj_po_vozilu;
use Illuminate\Database\Query\Builder;

class IzvestajOPlacanjuController extends Controller
{
    function __construct()
    {
         //
    }

    public function index(): View
    {

        $nalozi = Nalozi::where('izvestaj_o_placanju_gotov', false)
                ->with('unosilac')
                ->with('kvartal')
                ->with('klijent')
                ->get();
        //dd($nalozi);
        return view('izvestaji.indexOPlacanju',compact('nalozi'));
    }

    public function getBindDocs(Request $request): JsonResponse
    {
      
        $files = $request->input('files');
        $fileArr = [];
        if($files != '' || $files != 'null')
        {
            if(str_contains($files, '|'))
            {
                $fileArr = explode('|',$files);
            } else {
                $fileArr = [$files];
            }
        }
        foreach($fileArr as $idx => $file) {
            $fajlovi = Fajlovi::where('id', $file)->first();
            $nalog = Nalozi::where('id', $fajlovi->nalog_id)->first();

            $klijent = Klijenti::where('id', $nalog->klijent_id)->first();

            $klijent_token = $klijent->token;

            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path =  asset('storage').DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$nalog->id.DIRECTORY_SEPARATOR.$fajlovi->folder;

            $docPath =      $dokumenta_path.DIRECTORY_SEPARATOR;
            $docPathTmb =   $dokumenta_path.DIRECTORY_SEPARATOR.'tmb'.DIRECTORY_SEPARATOR;

            $jsonArr['fajlovi'][$idx]['id'] = $fajlovi->id;
            $jsonArr['fajlovi'][$idx]['fajl'] = $docPath.$fajlovi->fajl;
            $jsonArr['fajlovi'][$idx]['tmb'] = $docPathTmb.$fajlovi->fajl;

        }
		
		return response()->json($jsonArr);
    }

    public function edit($id): View
    {
        $nalozi = Nalozi::where('id', $id)->first();
        $klijent_pod = Klijenti::find($nalozi->klijent_id);
        $poreska_filijala = poreska_filijala::where('id', $klijent_pod->poreska_filijala_id)->first();

        $dobavljaci = Pozicije::selectRaw('*, SUM(iznos) as SUMIZNOS')
                    ->where('nalog_id', $id)->groupby('dobavljac_id')
                    ->with('dobavljac')
                    ->get();

        

       
        foreach($dobavljaci as $dobavljac) {
            $pozicije[$dobavljac->dobavljac_id] = izvestaj_o_placanju::where('nalog_id', $id)->where('dobavljac_id', $dobavljac->dobavljac_id)->get();
        }
        $banke = Banke::get();

        return view('izvestaji.izvestajOPlacanju',compact('nalozi','poreska_filijala', 'dobavljaci','pozicije', 'banke'));
    }

    public function store(Request $request): RedirectResponse
    {
        //dd($request);
        
        izvestaj_o_placanju::where('nalog_id', $request->nalog_id)->delete();

        foreach($request->dobavljac_id as $dobavljac_id) {

            foreach($request->broj[$dobavljac_id] as $idx => $val) {
                //dd($request->vezni_dokument[$dobavljac_id][$idx]);
                if($request->broj[$dobavljac_id][$idx] != null || $request->datum[$dobavljac_id][$idx] != null || $request->iznos[$dobavljac_id][$idx] != null || $request->napomena[$dobavljac_id][$idx] != null || $request->vezni_dokument[$dobavljac_id][$idx] != null) {
                    $izvestajOPlacanju = new izvestaj_o_placanju;

                    $izvestajOPlacanju->nalog_id = $request->nalog_id;
                    $izvestajOPlacanju->dobavljac_id = $dobavljac_id;
                    $izvestajOPlacanju->broj = $request->broj[$dobavljac_id][$idx];
                    $izvestajOPlacanju->datum = $request->datum[$dobavljac_id][$idx];
                    $izvestajOPlacanju->banka_id = $request->banka_id[$dobavljac_id][$idx];
                    $izvestajOPlacanju->iznos = $request->iznos[$dobavljac_id][$idx];
                    $izvestajOPlacanju->napomena = $request->napomena[$dobavljac_id][$idx];
                    $izvestajOPlacanju->vezni_dokument = $request->vezni_dokument[$dobavljac_id][$idx];
                    $izvestajOPlacanju->bindDoc = $request->bindDoc[$dobavljac_id][$idx];
                    
                    $izvestajOPlacanju->save();
                }
            }

        }

        return redirect()->route('izvestajOPlacanju.index')
                        ->with('success','Izveštaj uspešno sačuvan');
    }

}