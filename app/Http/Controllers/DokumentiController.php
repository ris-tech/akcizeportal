<?php

namespace App\Http\Controllers;

use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DokumentiController extends Controller
{
    public function index($id): View
    {
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $ugovoriPath = 'storage/'.$hiddenFolder.'/ugovori//';

        $hiddenFolderPath = public_path($ugovoriPath);
        if (!is_dir($hiddenFolderPath)) {
            mkdir($hiddenFolderPath, 0777, true );
        }
        $ugovor_src = array_diff(scandir($hiddenFolderPath), array('..', '.'));
        //dd($ugovor_src);
        if (empty($ugovor_src)) {
            $ugovor_file = '';
        } else {
            $ugovor_file = $ugovor_src[2];
            if (!is_file($hiddenFolderPath.$ugovor_file)) {
                $ugovor_file = '';
            }
        }

        $ugovor = [
                'ugovor_file' => $ugovor_file,
                'ugovor_path' => $hiddenFolderPath
        ];


        return view('dokumenti.index',compact('klijent'), $ugovor);
    }
}
