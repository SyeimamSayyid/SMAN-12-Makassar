<?php

namespace App\Http\Controllers;

use App\Models\Spmb;
use Illuminate\Http\Request;

class SpmbController extends Controller
{
    public function index()
    {
        $spmb = Spmb::aktif()->latest('tanggal_upload')->paginate(6);
        return view('spmb.index', compact('spmb'));
    }

    public function show($slug)
    {
        $spmb = Spmb::where('slug', $slug)->aktif()->firstOrFail();
        $spmb->increment('views');
        
        $spmbLain = Spmb::aktif()
            ->where('id', '!=', $spmb->id)
            ->latest('tanggal_upload')
            ->limit(3)
            ->get();
        
        return view('spmb.show', compact('spmb', 'spmbLain'));
    }
}