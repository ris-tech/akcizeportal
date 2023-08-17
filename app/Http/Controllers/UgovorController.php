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
        $klient = Klijenti::find($id);
        return view('ugovor.index',compact('klient'));
    }

}