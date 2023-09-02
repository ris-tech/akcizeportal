<?php

namespace App\Http\Controllers;

use App\Mail\Ugovor;
use App\Models\Dokumenta;
use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\OdgovornoLice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class DokumentaController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function upload(Request $request): RedirectResponse
    {
        
        $klijent = Klijenti::find($request->id);
        if($klijent->token != NULL) {
            $hiddenfolder_enc = $klijent->token;
        } else {
            $hiddenfolder_enc = md5($klijent->naziv);
            Klijenti::find($request->id)  
            ->update(
                ['token' => $hiddenfolder_enc]
            );

            $setToken = Klijenti::find($request->id);
            $setToken->token = $hiddenfolder_enc;
            $setToken->save();
        }

        $hiddenFolder=substr($hiddenfolder_enc,0,8);
        $docPath = public_path('storage/'.$hiddenFolder.'/');
        if (!is_dir($docPath)) {
            mkdir($docPath, 0777, true );
        }

        $uploaded_file = $request->file('upload');
        $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.'.$uploaded_file->extension();
        $uploaded_file->move($docPath,$new_file);

        $dokumenta = Dokumenta::where('klijent_id', $request->id);
        //dd($dokumenta->get());
        if ($dokumenta->get()->isNotEmpty()) {
            if($request->docType == 'ugovor') {
                Dokumenta::where('klijent_id', $request->id)
                ->update(['ugovor' => $new_file, 'datum_ugovora' => date('Y-m-d'), 'broj_ugovora' => 'upload']);
            }
            if($request->docType == 'pep') {
                Dokumenta::where('klijent_id', $request->id)
                ->update(['pep' => $new_file, 'datum_pep' => date('Y-m-d')]);
            }
        } else {
            if($request->docType == 'ugovor') {
                $new_dokumenta = new Dokumenta();
                $datum_ugovora = date('Y-m-d');
                $new_dokumenta->klijent_id = $request->id;
                $new_dokumenta->ugovor = $new_file;
                $new_dokumenta->datum_ugovora = $datum_ugovora;
                $new_dokumenta->broj_ugovora = 'upload';
                
                $new_dokumenta->save();
            }
            if($request->docType == 'pep') {
                $new_dokumenta = new Dokumenta();
                $datum_pep = date('Y-m-d');
                $new_dokumenta->klijent_id = $request->id;
                $new_dokumenta->pep = $new_file;
                $new_dokumenta->datum_pep = $datum_pep;
                
                $new_dokumenta->save();
            }
        }
        return redirect()->route('dokumenta.show',$request->id)
        ->with('success',$request->docType.' uspešno uploadovano');
    }

    public function show($id): View
    {
        $pass_doc = [];
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
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
        return view('Dokumenta.index',compact('klijent','odgovorno_lice'), $pass_doc);
    }
    public function destroy(Request $request, $id)
    {

        if ($request->docType == 'ugovor') {
            $upd = Dokumenta::where('klijent_id', $id)
            ->update(['ugovor' => NULL, 'datum_ugovora' => NULL, 'broj_ugovora' => NULL]);
        }

        if ($request->docType == 'pep') {
            Dokumenta::where('klijent_id', $id)
            ->update(['pep' => NULL, 'datum_pep' => NULL]);

        }

        return redirect()->route('dokumenta.show',$id)
            ->with('success',$request->docType.' uspešno izbrisan');
    }

    public function sendMail(Request $request)
    {
        $email = $request->email;
        $docType = $request->docType;
        $docTypeName = $request->docTypeName;
        $data = [
            'docType' => $docType,
            'docTypeName' => $docTypeName
        ];
        $id = $request->query('id');
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage/'.$hiddenFolder;
        $hiddenFolderPath = public_path($dokumenta_path);


        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $dokumenta = Dokumenta::where('klijent_id', $id)->get();

        //dd($dokumenta[0]);

        $data += [
            'dokumenta_path' => $dokumenta_path,
            'ugovor' => $dokumenta[0]->ugovor,
            'pep' => $dokumenta[0]->pep
        ];


        if($odgovorno_lice->pol == 1) {
            $data += [
                'formalno' => 'Postovani g.'
            ];
        } else {
            $data += [
                'formalno' => 'Postovana gđo.'
            ];
        }

        $data += [
            'ime' => $odgovorno_lice->ime,
            'prezime' => $odgovorno_lice->prezime,
            'email' => $email,
        ];

        if ($docType == 'ugovor') {
            $file = env('APP_URL').'/'.$dokumenta_path.'/'.$dokumenta[0]->ugovor;
        }

        if ($docType == 'pep') {
            $file = env('APP_URL').'/'.$dokumenta_path.'/'.$dokumenta[0]->pep;
        }

        Mail::send('Mailovi.mail', $data, function($message)use($docTypeName, $email, $odgovorno_lice, $file) {
            $message->to($email)
            ->subject('Akcize.rs | '.$docTypeName);
            $message->attach($file, [
                'as' => $docTypeName.'.pdf',
                'mime' => 'application/pdf'
            ]);
        });
        return redirect()->route('dokumenta.show',$id)
        ->with('success',$request->docType.' uspešno poslat');



    }

}
