<?php

namespace App\Http\Controllers;

use App\Models\Dokumenta;
use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DokumentaController extends Controller
{
    public function show($id): View
    {
        $pass_doc = [];
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage/'.$hiddenFolder;
        $hiddenFolderPath = public_path($dokumenta_path);
        if (is_dir($hiddenFolderPath)) {
            $pass_doc += [
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $pass_doc += [
                'dokumenta_path' => '-'
            ];
        }

        $dokumenta = Dokumenta::where('klijent_id', $id)->get();
        
        if($dokumenta->isNotEmpty()) {
            foreach($dokumenta as $dokument) {
                
                if($dokument->ugovor != NULL) {
                    $pass_doc += [
                        'ugovor' => $dokument->ugovor,
                        'broj_ugovora' => $dokument->broj_ugovora,
                        'datum_ugovora' => $dokument->datum_ugovora
                    ];
                } else {
                    $pass_doc += [
                        'ugovor' => '-',
                        'broj_ugovora' => 'Nema',
                        'datum_ugovora' => '-'
                    ];
                }

                if($dokument->pep != NULL) {
                    $pass_doc += [
                        'pep' => $dokument->pep,
                        'datum_pep' => $dokument->datum_pep
                    ];
                } else {
                    $pass_doc += [
                        'pep' => 'Nema',
                        'datum_pep' => '-'
                    ];
                }
                //dd($pass_doc);
            }
        } else {
            $pass_doc += [
                'ugovor' => '-',
                'broj_ugovora' => 'Nema',
                'datum_ugovora' => '-',
                'pep' => 'Nema',
                'datum_pep' => '-'
            ];
        }
        return view('Dokumenta.index',compact('klijent'), $pass_doc);
    }
}
