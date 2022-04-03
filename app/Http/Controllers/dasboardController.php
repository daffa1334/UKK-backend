<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\dasboard;
use JWTAuth;
use App\Member;
use App\Transaksi;


class dasboardController extends Controller
{
    public function index()
    {
        $member = Member::count();
        $baru = Transaksi::where('status', '=', 'Baru')->count();
        $proses = Transaksi::where('status', '=', 'Proses')->count();
        $pendapatan = Transaksi::where('dibayar', '=', 'dibayar')->sum('total_bayar');

        return response()->json([
            'member' => $member,
            'baru' => $baru,
            'proses' => $proses,
            'pendapatan' => $pendapatan,
        ]);
    }
}