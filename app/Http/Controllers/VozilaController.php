<?php

namespace App\Http\Controllers;

use App\Models\Dokumenta;
use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kvartali;
use App\Models\Pozicije;
use App\Models\Vozila;
use App\Models\izvestaj_po_vozilu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Query\Builder;
use DB;
use Spatie\PdfToImage\Pdf;

class VozilaController extends Controller
{
    public $kvartalCol = [];

    public function __invoke()
    {
        
    }



    public function show($id, $kvartal = NULL): View
    {
        $data = [];
        $klijent = Klijenti::where('id', $id)->first();
        
        
        if($kvartal != NULL) {
            $kvartali = Kvartali::where('id', $kvartal)->groupBy('godina')->get();
            $this->kvartalCol = Kvartali::where('id', $kvartal)->groupBy('godina')->first();
            $vozila = DB::table('vozila')->select('*')->where('klijent_id', $id)
            ->where(function (Builder $query) {
                $query->where('od', '>', $this->kvartalCol->od)
                ->orWhere('do', '<', $this->kvartalCol->do);
            })->get();
            $data += [
                'filter' => true,
                'kvartalId' => $kvartal
            ];
        } else {
            $vozila = Vozila::where('klijent_id', $id)->get();
            $kvartali = Kvartali::groupBy('godina')->get();
            $data += [
                'filter' => false
            ];
        }

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

        return view('Vozila.show',compact('vozila','klijent','kvartali'), $data);
    }

    public function getKvartal(Request $request): JsonResponse
    {
        $kvartali = Kvartali::where('godina', $request->godina)->get();

        return response()->json(['kvartali' => $kvartali]);
    }

    public function getVozilo(Request $request): JsonResponse
    {
       
        $resp_json = [];
        $klijent = Klijenti::where('id', $request->id)->first();
        $vozila = Vozila::where('klijent_id', $request->id)->get();

        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = '/storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($dokumenta_path);
        if (is_dir($hiddenFolderPath)) {
            $resp_json += [
                'klijent' => $klijent,
                'vozila' => $vozila,
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $resp_json += [
                'klijent' => $klijent,
                'vozila' => $vozila,
                'dokumenta_path' => '-'
            ];
        }

        return response()->json($resp_json);
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

        Vozila::where('reg_broj', $request->reg_broj)->update([
            'od' => $request->od,
            'do' => $request->do,
            'licenca' => $new_file
        ]);

        return redirect()->route('vozila.show',$request->id)
        ->with('success','Licenca uspešno unešena');
    }

    public function addVozilo(Request $request): RedirectResponse
    {
        $reg_br = '';
        if ($request->reg_broj1 != '' && $request->reg_broj2 != '' && $request->reg_broj3 != '') {
            $reg_br = $request->reg_broj1.'-'.$request->reg_broj2.'-'.$request->reg_broj3;
        }
        $request->merge([
            'reg_broj' => $reg_br,
        ]);
    
        $this->validate($request, [
            'reg_broj' => 'required|unique:vozila,reg_broj'
        ],
        [
            'reg_broj.required' => 'Najmanje jedno polje nije ispunjeno!',
            'reg_broj.unique' => 'Registarski broj je već korisćen!',
        ]);


        Vozila::insert([
            'klijent_id' => $request->id,
            'reg_broj' => $reg_br,
        ]);
        return redirect()->route('vozila.show',$request->id)
        ->with('success','Vozilo uspešno unešeno')
        ->withErrors('test', 'login');
    }
    
    public function uploadSaobracajna(Request $request): RedirectResponse
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
        $uploaded_file = $request->file('upload_saobracanje');
        if($uploaded_file->extension() == 'pdf') {
            
        }

        $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.'.$uploaded_file->extension();
        $uploaded_file->move($docPath,$new_file);


        Vozila::where('reg_broj', $request->reg_broj)->update([
            'saobracajna_od' => $request->saobracajna_od,
            'saobracajna_do' => $request->saobracajna_do,
            'broj_sasije' => $request->broj_sasije,
            'saobracajna' => $new_file,
        ]);

        return redirect()->route('vozila.show',$request->id)
        ->with('success','Licenca uspešno unešena');
    }

    public function destroyVozilo(Request $request): RedirectResponse
    {
        $vozUpoz = '';
        $pozicije = Pozicije::leftjoin('nalozi', 'pozicije.nalog_id', '=', 'nalozi.id')
                	->leftjoin('kvartali', 'nalozi.kvartal_id', '=', 'kvartali.id')
                    ->where('nalozi.klijent_id', $request->klijent_id)
                    ->where('vozila', $request->vozilo)
                    ->groupby('nalozi.id')
                    ->get();
        if ($pozicije->isNotEmpty()) {
            foreach($pozicije as $pozicija) {
                $vozUpoz = $vozUpoz.$pozicija->kvartal.' | ';
            }
            return Redirect::back()->withErrors(['msg' => 'Vozilo postoji jos u nalozima '.$vozUpoz]);
        } else {
            izvestaj_po_vozilu::where('vozilo_id', $request->vozilo)->delete();
        

            Vozila::where('id', $request->vozilo)->delete();
            return redirect()->route('vozila.show',$request->klijent_id)
                ->with('success','Vozilo uspešno izbrisano')
                ->withErrors('error', 'Vozilo postoji jos u nalozima');
        }
    }

    public function destroy(Request $request, $id)
    {
        $vozilo = Vozila::where('klijent_id', $id)
        ->where('reg_broj', $request->reg_broj)->first();

        $klijent = Klijenti::where('id', $id)->first();
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($dokumenta_path);
        $file =$hiddenFolderPath.$vozilo->licenca;
        if(file_exists($file)) {
            unlink($file);
        }

        Vozila::where('klijent_id', $id)
        ->where('reg_broj', $request->reg_broj)
        ->update([
            'licenca' => NULL,
            'od' => NULL,
            'do' => NULL
        ]);

        return redirect()->route('vozila.show',$id)
            ->with('success','Licenca uspešno izbrisan');
    }

    public function destroySaobracajnu(Request $request, $id)
    {
        //dd($request);
        $vozilo = Vozila::where('klijent_id', $id)
        ->where('reg_broj', $request->reg_broj)->first();

        //dd($vozilo);

        $klijent = Klijenti::where('id', $id)->first();
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage/'.$hiddenFolder.'/';
        $hiddenFolderPath = public_path($dokumenta_path);
        $file =$hiddenFolderPath.$vozilo->saobracajna;
        if(file_exists($file)) {
            unlink($file);
        }

        Vozila::where('klijent_id', $id)
        ->where('reg_broj', $request->reg_broj)
        ->update([
            'saobracajna' => NULL,
            'saobracajna_od' => NULL,
            'saobracajna_do' => NULL,
            'broj_sasije' => NULL
        ]);

        return redirect()->route('vozila.show',$id)
            ->with('success','Licenca uspešno izbrisan');
    }

}
