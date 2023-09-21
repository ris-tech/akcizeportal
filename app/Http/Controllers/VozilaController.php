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
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;
use Spatie\PdfToImage\Pdf;

class VozilaController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function show($id): View
    {
        $data = [];
        $klijent = Klijenti::where('id', $id)->first();
        $vozila = Vozila::where('klijent_id', $id)->get();

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

        return view('Vozila.show',compact('vozila','klijent'), $data);
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
        if($uploaded_file->extension() == 'pdf') {
            $pdf = new Pdf($uploaded_file);
            $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.jpg';
            $pdf->saveImage($docPath,$new_file);
        } else {
            $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.'.$uploaded_file->extension();
            $uploaded_file->move($docPath,$new_file);
        }

        

        Vozila::where('reg_broj', $request->reg_broj)->update([
            'od' => $request->od,
            'do' => $request->do,
            'licenca' => $new_file
        ]);

        return redirect()->route('vozila.show',$request->id)
        ->with('success','Licenca uspešno unešena');
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
        unlink($file);

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

}