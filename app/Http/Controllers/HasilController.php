<?php

namespace App\Http\Controllers;

use App\Models\EclatCalculation;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $calculations = EclatCalculation::all();
        $count = EclatCalculation::count();
        return view('layouts.pages.hasil', compact('calculations', 'count'));
    }

    public function show($id)
    {
        $calculation = EclatCalculation::with(['results', 'results.details.obat'])->findOrFail($id);
        return view('layouts.pages.detail', compact('calculation'));
    }
}
