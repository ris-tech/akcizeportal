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
use App\Models\Nalozi;
use App\Models\Pozicije;
use App\Models\Klijenti;
use App\Models\Dobavljaci;
use App\Models\poreska_filijala;
use App\Models\Fajlovi;
use App\Models\izvestaj_po_vozilu;
use Illuminate\Database\Query\Builder;

class IzvestajiController extends Controller
{
    function __construct()
    {
         //
    }

    public function index(): View
    {
        $nalozi = Nalozi::where('unos_gotov', true)
                ->with('unosilac')
                ->with('kvartal')
                ->with('klijent')
                ->get();
        //dd($nalozi);
        return view('izvestaji.indexPoVozilu',compact('nalozi'));
    }

    public function edit($id): View
    {

        $vozilaPoNalogu =  Pozicije::groupBy('vozila')
                            ->select('*', DB::raw('SUM(iznos) as sum_iznos, SUM(kolicina) as sum_kolicina'))
                            ->leftjoin('izvestaj_po_vozilu', 'pozicije.vozila', '=', 'izvestaj_po_vozilu.vozilo_id', 'and', 'izvestaj_po_vozilu.nalog_id', '=', $id)
                            ->where('pozicije.nalog_id', $id)
                            ->with('vozilo')
                            ->get();
        
                           //dd($vozilaPoNalogu);

        $dobavljaciPoNalogu = Pozicije::groupBy('dobavljac_id')
                            ->select('*', DB::raw('SUM(iznos) as sum_iznos'))
                            ->where('nalog_id', $id)
                            ->with('dobavljac')
                            ->get();
        $ukupniIznos = Pozicije::select('*', DB::raw('SUM(iznos) as sum_iznos'))
        ->where('nalog_id', $id)->first();
        //dd($dobavljaciPoNalogu);
        $dobavljaciPoVozilu = [];

        foreach($vozilaPoNalogu as $vozilo) {
            $dobavljaci = Pozicije::select('*', DB::raw('SUM(kolicina) as dob_kolicina'))
                            ->groupBy('dobavljac_id')
                            ->with('dobavljac')
                            ->with('vozilo')
                            ->where('nalog_id', $id)
                            ->where('vozila', $vozilo->vozila)
                            ->get();
      
            foreach($dobavljaci as $dobavljacPoVozilu)
            {
               // dd($dobavljacPoVozilu);
                $dobavljaciPoVozilu[$dobavljacPoVozilu->vozila][$dobavljacPoVozilu->dobavljac_id] = $dobavljacPoVozilu->dob_kolicina;
            }
        }
        //dd($dobavljaciPoVozilu);
        $nalozi = Nalozi::where('id',$id)
                ->with('klijent')
                ->with('unosilac')
                ->with('kvartal')
                ->first();

        $klijent_pod = Klijenti::find($nalozi->klijent_id);
        $klijent_token = $klijent_pod->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

        
        $dobavljaci = Dobavljaci::get();
        $fajlovi = Fajlovi::where('nalog_id',$id)
                    ->where('tip', 'sken_ulazne_fakture')
                    ->get();
        $cndFiles = count($fajlovi);
        $poreska_filijala = poreska_filijala::where('id', $klijent_pod->poreska_filijala_id)->first();

        $data = [
            'resp' => true,
            'dokumenta_path' => $dokumenta_path,
            'pos' => 1,
            'sumpos' => 1,
            'tip' => 'izvestaj_po_vozilu',
            'filepos' => 0,
            'cntFiles' => $cndFiles,
            'iznosUkupno' => $ukupniIznos
        ];



        $reft = DB::table('pozicije')
                        ->select('pozicije.datum_fakture', 'pozicije.broj_fakture', 'pozicije.kolicina', 'vozila.reg_broj', 'vozila.od', 'vozila.do')
                        ->leftjoin('vozila', 'pozicije.vozila', '=', 'vozila.id')
                        ->where('pozicije.nalog_id', $id)
                        ->where(function (Builder $query) {
                            $query->whereRaw('vozila.od > pozicije.datum_fakture')
                            ->orWhereRaw('vozila.do < pozicije.datum_fakture');
                        })
                        
                        ->orderBy('pozicije.vozila', 'asc')
                        ->orderBy('pozicije.datum_fakture', 'asc')
                        ->get();
        //dd($reft);
        //dd($pozicije);

        return view('izvestaji.izvestajPoVozilu',compact('dobavljaciPoNalogu', 'vozilaPoNalogu', 'nalozi','poreska_filijala','fajlovi','dobavljaci','dobavljaciPoVozilu','reft'), $data);
    }

    public function sacuvajIzvestajPoVozilu(Request $request): RedirectResponse
    {
        
        izvestaj_po_vozilu::where('nalog_id', $request->nalog_id)->delete();

        $vozila = $request->vozilo;

        foreach($vozila as $idx => $vozilo) {

            $ipv = new izvestaj_po_vozilu;

            $ipv->nalog_id = $request->nalog_id;
            $ipv->vozilo_id = $vozilo;
            $ipv->predjene_km = $request->km[$idx];

            $ipv->save();
        }

        return redirect()->route('izvestaji.edit',$request->nalog_id)
        ->with('success', 'uspešno sačuvano');

    }

}