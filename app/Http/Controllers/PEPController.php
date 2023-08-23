<?php

namespace App\Http\Controllers;

use App\Models\Klijenti;
use App\Models\OdgovornoLice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Dokumenta;

class PEPController extends Controller
{

    public function edit($id): View
    {
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $docPath = 'storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($docPath);

        $dokumenta = Dokumenta::where('klijent_id', $id)->get();

        $pep = [
            'pep_file' => '',
            'docPath' => $docPath
        ];
        
        if ($dokumenta->isNotEmpty()) {
            
            if($dokumenta->pluck('pep')[0] != NULL) {
                $pep = [
                    'pep_file' => $dokumenta->pluck('pep')[0],
                    'docPath' => $docPath
                ];            
            }
        }
                
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);

        return view('Dokumenta.pep.index',compact('klijent','odgovorno_lice'), $pep);
    }

    public function store(Request $request)
    {

        $password="password";
        $klijent = Klijenti::find($request->clientId);
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        if($klijent->token != NULL) {
            $hiddenfolder_enc = $klijent->token;
        } else {
            $hiddenfolder_enc = md5($klijent->naziv);
            Klijenti::find($request->clientId)  
            ->update(
                ['token' => $hiddenfolder_enc]
            );

            $setToken = Klijenti::find($request->clientId);
            $setToken->token = $hiddenfolder_enc;
            $setToken->save();

        }

        $pep_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.pdf';

        $hiddenFolder=substr($hiddenfolder_enc,0,8);
        $docPath = public_path('storage/'.$hiddenFolder.'/');
        if (!is_dir($docPath)) {
            mkdir($docPath, 0777, true );
        }
        
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

        PDF::loadView('pdf.pep',compact('klijent','odgovorno_lice'), $sigarr)->setPaper('a4', 'landscape')->save($docPath.$pep_file);

        Storage::disk('public')->delete($sigfile);

        $dokumenta = Dokumenta::where('klijent_id', $request->clientId);
        //dd($dokumenta->get());
        if ($dokumenta->get()->isNotEmpty()) {

            Dokumenta::where('klijent_id', $request->clientId)
            ->update(['pep' => $pep_file, 'datum_pep' => date('Y-m-d')]);
            
        } else {
            $new_dokumenta = new Dokumenta();
            $datum_pep = date('Y-m-d');
            $new_dokumenta->klijent_id = $request->clientId;
            $new_dokumenta->pep = $pep_file;
            $new_dokumenta->datum_pep = $datum_pep;
            
            $new_dokumenta->save();
        }
        

        return response()->json(['success'=> $sigfile]);
    }

}