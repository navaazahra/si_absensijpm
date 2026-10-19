<?php

namespace App\Http\Controllers;

class GuideController extends Controller
{
    public function supir()
    {
        return view('guide.supir');
    }

    public function admin()
    {
        return view('guide.admin');
    }

    public function petinggi()
    {
        return view('guide.petinggi');
    }

    public function umum()
    {
        return view('guide.umum');
    }
}