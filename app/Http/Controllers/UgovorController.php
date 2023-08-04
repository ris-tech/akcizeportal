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

class UgovorController extends Controller
{
    public function edit($id): View
    {
        $klient = Klijenti::find($id);
        return view('ugovor.index',compact('klient'));
    }
    
    public function store(Request $request)
    {


        PDF::loadView('pdf')->save(public_path('ugovor.pdf'));


        return response()->json(['success'=>'']);
    }

}