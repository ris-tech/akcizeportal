<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use App\Models\Klijenti;
use App\Models\Banke;
use App\Models\Vozila;
use App\Models\poreska_filijala;
use Illuminate\Http\RedirectResponse;
use App\Models\OdgovornoLice;
use App\Models\knjigovodja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Dokumenta;
use stdClass;

class KlijentiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $klijenti = DB::table('klijenti')
                ->select(array('klijenti.*', 'knjigovodja.naziv as knjigovodja'))
                ->leftJoin('knjigovodja', 'klijenti.knjigovodja_id', '=', 'knjigovodja.id')
                ->leftJoin('klijenti_dokumenta', 'klijenti.id', '=', 'klijenti_dokumenta.klijent_id')
                ->leftJoin('vozila', 'klijenti.id', 'vozila.klijent_id')
                ->groupBy('klijenti.id')
				->orderBy('klijenti.naziv', 'asc')
                ->get();
        $klijentiResult = $klijenti;
        $dokumenta = [];
        $vozila[] = '';
        
        foreach($klijentiResult as $klijent) {
            $vozilaCnt = Vozila::where('klijent_id', $klijent->id)->count();
            $vozila[$klijent->id] = $vozilaCnt;

            $ugovor = Dokumenta::where('klijent_id', $klijent->id)->where('tip', 'ugovor')->get();
            if($ugovor->isNotEmpty()) {
                $datum_fajla = '-';
                $broj_fajla = '-';
                if ($ugovor[0]->datum_fajla != NULL) {
                    $datum_fajla = $ugovor[0]->datum_fajla;
                }
                if ($ugovor[0]->broj_fajla != NULL) {
                    $broj_fajla = $ugovor[0]->broj_fajla;
                }
                $dokumenta['dokumenti'][$klijent->id]['ugovor']['datum_fajla'] = $datum_fajla;
                $dokumenta['dokumenti'][$klijent->id]['ugovor']['broj_fajla'] = $broj_fajla;
            } else {
                $dokumenta['dokumenti'][$klijent->id]['ugovor']['datum_fajla'] = '-';
                $dokumenta['dokumenti'][$klijent->id]['ugovor']['broj_fajla'] = '-';
            }

            $pep = Dokumenta::where('klijent_id', $klijent->id)->where('tip', 'pep')->get();
            if($pep->isNotEmpty()) {
                $datum_fajla = '-';
                $broj_fajla = '-';
                if ($pep[0]->datum_fajla != NULL) {
                    $datum_fajla = $pep[0]->datum_fajla;
                }
                if ($pep[0]->broj_fajla != NULL) {
                    $broj_fajla = $pep[0]->broj_fajla;
                }
                $dokumenta['dokumenti'][$klijent->id]['pep']['datum_fajla'] = $datum_fajla;
                $dokumenta['dokumenti'][$klijent->id]['pep']['broj_fajla'] = '-';

            } else {
                $dokumenta['dokumenti'][$klijent->id]['pep']['datum_fajla'] = '';
                $dokumenta['dokumenti'][$klijent->id]['pep']['broj_fajla'] = '-';
            }
        }
        return view('klijenti.index',compact('klijenti', 'vozila'), $dokumenta);
    }

    public function create(): View
    {
        $banke = Banke::paginate(99);
        $poreska_filijala = poreska_filijala::paginate(99);
        $knjigovodja = knjigovodja::paginate(99);

        return view('klijenti.create', compact('banke','poreska_filijala','knjigovodja'));
    }

    public function edit($id): View
    {
        $klijenti = Klijenti::find($id);
        $odgovorno_lice = OdgovornoLice::find($klijenti->odgovorno_lice_id);
        $banke = Banke::paginate(99);
        $poreska_filijala = poreska_filijala::paginate(99);
        $knjigovodja = knjigovodja::paginate(99);

        return view('klijenti.edit', compact('klijenti','odgovorno_lice','banke','poreska_filijala','knjigovodja'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'naziv' => 'required|unique:klijenti,naziv',
            'pib' => 'required|unique:klijenti,pib',
            'maticni_broj' => 'required',
            'ulica' => 'required',
            'broj_ulice' => 'required',
            'postanski_broj' => 'required',
            'mesto' => 'required',
            'opstina' => 'required',
            'pol' => 'required',
            'ime' => 'required',
            'prezime' => 'required',
            'telefon' => 'required',
            'jmbg' => 'required',
            'pocetak_obrade' => 'required',
            'poreska_filijala_id' => 'required',
            'knjigovodja_id' => 'required',
            'banka_id' => 'required',
            'broj_bankovog_racuna' => 'required',
            'cena' => 'required',
            'prioritet' => 'required',
        ]);

        $odgovorno_lice = new OdgovornoLice;

        $odgovorno_lice->pol = $request->pol;
        $odgovorno_lice->ime = $request->ime;
        $odgovorno_lice->prezime = $request->prezime;
        $odgovorno_lice->telefon = $request->telefon;
        $odgovorno_lice->email = $request->email;
        $odgovorno_lice->jmbg = $request->jmbg;

        $odgovorno_lice->save();

        $odgovorno_lice_id = $odgovorno_lice->id;

        $klijenti = new Klijenti;

        $klijenti->naziv = $request->naziv;
        $klijenti->pib = $request->pib;
        $klijenti->maticni_broj = $request->maticni_broj;
        $klijenti->ulica = $request->ulica;
        $klijenti->broj_ulice = $request->broj_ulice;
        $klijenti->postanski_broj = $request->postanski_broj;
        $klijenti->knjigovodja_id = $request->knjigovodja_id;
        $klijenti->mesto = $request->mesto;
        $klijenti->opstina = $request->opstina;
        $klijenti->odgovorno_lice_id = $odgovorno_lice_id;
        $klijenti->poreska_filijala_id = $request->poreska_filijala_id;
        $klijenti->pocetak_obrade = $request->pocetak_obrade;
        $klijenti->banka_id = $request->banka_id;
        $klijenti->broj_bankovog_racuna = $request->broj_bankovog_racuna;
        $klijenti->cena = $request->cena;
        $klijenti->prioritet = $request->prioritet;

        $klijenti->save();

        return redirect()->route('klijenti.index')
                        ->with('success','Klijent uspešno unešen');
    }

    protected $rules =
    [
        "pib" => 'required|unique:klijenti',
    ];

    public function update(Request $request, $id): RedirectResponse
    {
        $rules = $this->rules;
        $rules['pib'] = $rules['pib'].',id,'.$id;

        $validator = Validator::make($request->all(), $rules);


        $klijent = Klijenti::find($id);
		//dd($request);
        Klijenti::find($id)
            ->update(
                ['naziv' => $request->naziv,
                'pib' => $request->pib,
                'maticni_broj' => $request->maticni_broj,
                'ulica' => $request->ulica,
                'broj_ulice' => $request->broj_ulice,
                'postanski_broj' => $request->postanski_broj,
                'knjigovodja_id' => $request->knjigovodja_id,
                'mesto' => $request->mesto,
                'opstina' => $request->opstina,
                'poreska_filijala_id' => $request->poreska_filijala_id,
                'pocetak_obrade' => $request->pocetak_obrade,
                'banka_id' => $request->banka_id,
                'broj_bankovog_racuna' => $request->broj_bankovog_racuna,
                'cena' => $request->cena,
                'prioritet' => $request->prioritet]
            );

        OdgovornoLice::find($klijent->odgovorno_lice_id)
            ->update(
                ['pol' => $request->pol,
                'ime' => $request->ime,
                'prezime' => $request->prezime,
                'telefon' => $request->telefon,
                'email' => $request->email,
                'jmbg' => $request->jmbg]
            );

        return redirect()->route('klijenti.index')
                        ->with('success','Klijent uspešno promenjen');
    }

    public function destroy($id): RedirectResponse
    {

        Dokumenta::where('klijent_id', $id)->delete();
        Klijenti::find($id)->delete();
        return redirect()->route('klijenti.index')
                        ->with('success','Klijent uspešno izbrisan');
    }

}
