<?php

namespace App\Http\Controllers;

use App\Models\Dokumenta;
use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\OdgovornoLice;
use App\Models\Vozila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class DokumentaController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function storeFiles(Request $request): JsonResponse
    {
        //dd($request);
        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;
        
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = public_path('storage/'.$hiddenFolder.'/');
        if (!is_dir($dokumenta_path)) {
            mkdir($dokumenta_path, 0777, true );
        }

        $image = $request->file('file');
        $imageName = Uuid::uuid4().'.'.$image->extension();
        $image->move($dokumenta_path,$imageName);

        $dokumenta = new Dokumenta;

        $dokumenta->klijent_id = $request->klijent_id;
        $dokumenta->tip = $request->docType;
        $dokumenta->fajl = $imageName;

        $dokumenta->save();

        return response()->json(['file'=>$imageName]);
    }

    public function deleteFile(Request $request): JsonResponse
    {
        Dokumenta::where('klijent_id', $request->klijent_id)
                    ->where('fajl', $request->fajl)
                    ->delete();

        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;
        
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = public_path('storage/'.$hiddenFolder.'/');
        $file =$dokumenta_path.$request->fajl;
        unlink($file);

        return response()->json(['success'=>'true']);
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

        $dokumenta = Dokumenta::where('klijent_id', $request->id)->where('tip', $request->docType);
        //dd($dokumenta->get());

        $new_dokumenta = new Dokumenta();
        $datum_fajla = date('Y-m-d');
        $new_dokumenta->klijent_id = $request->id;
        $new_dokumenta->tip = $request->docType;
        $new_dokumenta->fajl = $new_file;
        $new_dokumenta->datum_fajla = $datum_fajla;
        $new_dokumenta->broj_fajla = 'upload';
        
        $new_dokumenta->save();
       
        return redirect()->route('dokumenta.show',$request->id)
        ->with('success',$request->docType.' uspešno uploadovano');
    }

    public function showDokumenta(Request $request): View
    {
        $data = [];
        $klijent = Klijenti::where('id', $request->id)->first();
        $dokumenta = Dokumenta::where('klijent_id', $klijent->id)->where('tip', $request->docType)->get();
        $data += [
            'docType' => $request->docType,
            'docTypeName' => $request->docTypeName
        ];

        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = '/storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($dokumenta_path);
        if (is_dir($hiddenFolderPath)) {
            $data += [
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $data += [
                'dokumenta_path' => '-'
            ];
        }

        
        return view('Dokumenta.showDokumenta',compact('klijent','dokumenta'), $data);
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
        $analiticka_kartica = Dokumenta::where('klijent_id', $id)->where('tip','analiticke_kartice')->count();
        $saobracajna = Dokumenta::where('klijent_id', $id)->where('tip','saobracajna')->count();
        $depo_karton = Dokumenta::where('klijent_id', $id)->where('tip','depo_karton')->count();
        $vozila = Vozila::where('klijent_id', $id)->count();
        $licenca = Vozila::where('klijent_id', $id)->where('licenca', '!=', NULL)->count();
        $pass_doc += [
            'analiticka_kartica' =>  $analiticka_kartica,
            'vozila' =>  $vozila,
            'licenca' =>  $licenca,
            'saobracajna' =>  $saobracajna,
            'depo_karton' =>  $depo_karton
        ];
        if (is_dir($hiddenFolderPath)) {
            $pass_doc += [
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $pass_doc += [
                'dokumenta_path' => '-'
            ];
        }

        $ugovor = Dokumenta::where('klijent_id', $id)
                    ->where('tip', 'ugovor')
                    ->get();

        if($ugovor->isNotEmpty()) {
                $pass_doc += [
                    'ugovor' => $ugovor[0]->fajl,
                    'broj_ugovora' => $ugovor[0]->broj_fajla,
                    'datum_ugovora' => $ugovor[0]->datum_fajla
                ];
        } else {
            $pass_doc += [
                'ugovor' => '-',
                'broj_ugovora' => 'Nema',
                'datum_ugovora' => '-'
            ];
        }

        $pep = Dokumenta::where('klijent_id', $id)
                    ->where('tip', 'pep')
                    ->get();
        if($pep->isNotEmpty()) {
            $pass_doc += [
                'pep' => $pep[0]->fajl,
                'datum_pep' => $pep[0]->datum_fajla
            ];
        } else {
            $pass_doc += [
                'pep' => 'Nema',
                'datum_pep' => '-'
            ];
        }
        
        return view('Dokumenta.index',compact('klijent','odgovorno_lice'), $pass_doc);
    }
    public function destroy(Request $request, $id)
    {

        Dokumenta::where('klijent_id', $id)
        ->where('tip', $request->docType)
        ->delete();

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
        $dokumenta = Dokumenta::where('klijent_id', $id)->where('tip',$docType)->first();

        //dd($dokumenta[0]);


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

        $file = env('APP_URL').'/'.$dokumenta_path.'/'.$dokumenta->fajl;

        //dd($dokumenta);

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
