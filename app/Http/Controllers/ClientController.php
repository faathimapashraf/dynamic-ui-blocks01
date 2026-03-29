<?php

namespace App\Http\Controllers;

use App\Models\UiBlock;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        $blocks = UiBlock::where('status', 'Active')
            ->orderBy('display_order')
            ->get();

            // dd($blocks);
        return view('client.home', compact('blocks'));
    }
}
