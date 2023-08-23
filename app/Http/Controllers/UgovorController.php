<?php

namespace App\Http\Controllers;

use App\Models\Banke;
use App\Models\config;
use App\Models\Klijenti;
use App\Models\OdgovornoLice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Turanjanin\SerbianTransliterator\Transliterator;
use App\Models\Dokumenta;

class UgovorController extends Controller
{

    public function edit($id): View
    {
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $ugovoriPath = 'storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($ugovoriPath);

        $dokumenta = Dokumenta::where('klijent_id', $id)->get();
        
        $config = config::where('confvar', 'zadnji_broj_ugovora')->get();
        $br_ugovora = $config->pluck('confval')[0];
        $br_ugovora++;
        $novi_br_ugovora = 'AKZ'.sprintf("%04s", $br_ugovora);

        $ugovor = [
            'ugovor_file' => '',
            'ugovor_path' => $ugovoriPath,
            'br_ugovora' => $novi_br_ugovora
        ];
        
        if ($dokumenta->isNotEmpty()) {
            
            if($dokumenta->pluck('ugovor')[0] != NULL) {
                $ugovor = [
                    'ugovor_file' => $dokumenta->pluck('ugovor')[0],
                    'ugovor_path' => $ugovoriPath
                ];            
            }
        }
        
        //dd($br_ugovora);

        
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $banka = Banke::find($klijent->banka_id);
        $klijent->naziv_lat = $klijent->naziv;
        $klijent->naziv = Transliterator::toCyrillic($klijent->naziv);
        $klijent->ulica = Transliterator::toCyrillic($klijent->ulica);
        $klijent->broj_ulice = Transliterator::toCyrillic($klijent->broj_ulice);
        $klijent->postanski_broj = Transliterator::toCyrillic($klijent->postanski_broj);
        $klijent->mesto = Transliterator::toCyrillic($klijent->mesto);
        $klijent->opstina = Transliterator::toCyrillic($klijent->opstina);
        $odgovorno_lice->ime = Transliterator::toCyrillic($odgovorno_lice->ime);
        $odgovorno_lice->prezime = Transliterator::toCyrillic($odgovorno_lice->prezime);

        return view('Dokumenta.ugovor.index',compact('klijent','odgovorno_lice','banka'), $ugovor);
    }

    public function store(Request $request)
    {

        $password="password";
        $klijent = Klijenti::find($request->clientId);
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $banka = Banke::find($klijent->banka_id);
        $klijent->naziv = Transliterator::toCyrillic($klijent->naziv);        
        $hiddenfolder_enc = md5($klijent->naziv);
        Klijenti::find($request->clientId)  
        ->update(
            ['token' => $hiddenfolder_enc]
        );

        $setToken = Klijenti::find($request->clientId);
        $setToken->token = $hiddenfolder_enc;
        $setToken->save();

        $ugovor_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.pdf';

        $hiddenFolder=substr($hiddenfolder_enc,0,8);
        $ugovoriPath = public_path('storage/'.$hiddenFolder.'/');
        if (!is_dir($ugovoriPath)) {
            mkdir($ugovoriPath, 0777, true );
        }
        $klijent->ulica = Transliterator::toCyrillic($klijent->ulica);
        $klijent->broj_ulice = Transliterator::toCyrillic($klijent->broj_ulice);
        $klijent->postanski_broj = Transliterator::toCyrillic($klijent->postanski_broj);
        $klijent->mesto = Transliterator::toCyrillic($klijent->mesto);
        $klijent->opstina = Transliterator::toCyrillic($klijent->opstina);
        $odgovorno_lice->ime = Transliterator::toCyrillic($odgovorno_lice->ime);
        $odgovorno_lice->prezime = Transliterator::toCyrillic($odgovorno_lice->prezime);
        $clientsig = $request->clientsig;
        $img = str_replace('data:image/png;base64,', '', $clientsig);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $random = Str::random(40);
		$sigfile = $random.'.png';
		$sigarr = [
	            'sigfile' => $sigfile
	    ];
        //dd($request);
        Storage::disk('public')->put($sigfile, $data);

        PDF::loadView('pdf.ugovor',compact('klijent','odgovorno_lice','banka'), $sigarr)->save($ugovoriPath.$ugovor_file);

        Storage::disk('public')->delete($sigfile);

        $dokumenta = new Dokumenta();

        $dokumenta->klijent_id = $request->clientId;
        $dokumenta->ugovor = $ugovor_file;
        $dokumenta->datum_ugovora = $request->datum_ugovora;
        $dokumenta->broj_ugovora = $request->broj_ugovora;
        
        $dokumenta->save();

        return response()->json(['success'=> $sigfile]);
    }

}