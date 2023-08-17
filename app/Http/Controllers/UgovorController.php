<?php

namespace App\Http\Controllers;

use App\Models\Banke;
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

class UgovorController extends Controller
{

    public function edit($id): View
    {
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenfile_1=substr($klijent_token,0,2);
        $hiddenfile_2=substr($klijent_token,2,2);
        $hiddenfile_3=substr($klijent_token,4,2);
        $ugovor_path = 'storage/ugovori'.'/'.$hiddenfile_1.'/'.$hiddenfile_2.'/'.$hiddenfile_3.'/';
        $hiddenfolder = public_path($ugovor_path);
        if (!is_dir($hiddenfolder)) {
            mkdir($hiddenfolder, 0777, true );
        }
        $ugovor_src = array_diff(scandir($hiddenfolder), array('..', '.'));
        //dd($ugovor_src);
        if (empty($ugovor_src)) {
            $ugovor_file = '';
        } else {
            $ugovor_file = $ugovor_src[2];
            if (!is_file($hiddenfolder.$ugovor_file)) {
                $ugovor_file = '';
            }
        }

        $ugovor = [
                'ugovor_file' => $ugovor_file,
                'ugovor_path' => $ugovor_path
        ];
        //dd($ugovor);
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $banka = Banke::find($klijent->banka_id);
        $klijent->naziv = Transliterator::toCyrillic($klijent->naziv);
        $klijent->ulica = Transliterator::toCyrillic($klijent->ulica);
        $klijent->broj_ulice = Transliterator::toCyrillic($klijent->broj_ulice);
        $klijent->postanski_broj = Transliterator::toCyrillic($klijent->postanski_broj);
        $klijent->mesto = Transliterator::toCyrillic($klijent->mesto);
        $klijent->opstina = Transliterator::toCyrillic($klijent->opstina);
        $odgovorno_lice->ime = Transliterator::toCyrillic($odgovorno_lice->ime);
        $odgovorno_lice->prezime = Transliterator::toCyrillic($odgovorno_lice->prezime);


        return view('ugovor.index',compact('klijent','odgovorno_lice','banka'), $ugovor);
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

        $hiddenfile_1 = substr($hiddenfolder_enc,0,2);
        $hiddenfile_2 = substr($hiddenfolder_enc,2,2);
        $hiddenfile_3 = substr($hiddenfolder_enc,4,2);
        $hiddenfolder = public_path('storage/ugovori'.'/'.$hiddenfile_1.'/'.$hiddenfile_2.'/'.$hiddenfile_3.'/');
        if (!is_dir($hiddenfolder)) {
            mkdir($hiddenfolder, 0777, true );
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

        Storage::disk('public')->put($sigfile, $data);

        PDF::loadView('pdf',compact('klijent','odgovorno_lice','banka'), $sigarr)->save($hiddenfolder.$ugovor_file);

        Storage::disk('public')->delete($sigfile);




        return response()->json(['success'=> $sigfile]);
    }

}