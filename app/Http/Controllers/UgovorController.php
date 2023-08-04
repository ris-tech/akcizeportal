<?php

namespace App\Http\Controllers;

use App\Models\Klijenti;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class UgovorController extends Controller
{
    public function edit($id): View
    {
        $klient = Klijenti::find($id);
        return view('ugovor.index',compact('klient'));
    }
    
    public function store(Request $request, $id)
    {
        
        $klient = Klijenti::find($id);
        $clientsig = $request->clientsig;
        $img = str_replace('data:image/png;base64,', '', $clientsig);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $random = Str::random(40);

        Storage::disk('public')->put($random.'.png', $data);

        PDF::loadView('pdf',compact('klient',['clientsig' => $random.'.png']))->save(public_path('ugovor.pdf'));

        Storage::disk('public')->delete($random.'.png');

        return response()->json(['success'=>'']);
    }

}