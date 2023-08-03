<?php

namespace App\Http\Controllers;

use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UgovorController extends Controller
{
    public function edit($id): View
    {
        $klient = Klijenti::find($id);
        return view('ugovor.index',compact('klient'));
    }
}