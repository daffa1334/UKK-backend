<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\transaksi;
use App\Member;
use App\detail_transaksi;
use App\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class transaksiController extends Controller
{
    // public $response;
    public $user;

    public function __construct()
    {
        $this-> user = JWTAuth::parseToken()->authenticate();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_member' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->errorResponse($validator->errors());
        }

        $transaksi = new transaksi();
        $transaksi->id_member = $request->id_member;
        $transaksi->tgl = Carbon::now();
        $transaksi->batas_waktu = Carbon::now()->addDays(3);
        $transaksi->status = 'baru';
        $transaksi->dibayar = 'belum_dibayar';
        $transaksi->id = $this->user->id;
        $transaksi->save();

        $data = transaksi::where('id_transaksi', '=', $transaksi->id_transaksi)->first();

        return Response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil ditambahkan', 
            'data' => $data]);
    }

 public function getAll()
    {
        $id_user = $this->user->id;
        $data_user = User::where('id', '=', $id_user)->first();
        $data = DB::table('transaksi')->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->join('users', 'transaksi.id', 'users.id')
            ->select('transaksi.id_transaksi', 'member.nama_member', 'transaksi.tgl', 'transaksi.status' , 'users.name')
            ->where('users.id_outlet', $data_user->id_outlet)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
  public function getById($id)
  {
      $data = DB::table('transaksi')->join('member', 'transaksi.id_member', 'member.id_member')
                                    ->select('transaksi.*', 'member.nama_member')
                                    ->where('transaksi.id_transaksi', $id)
                                    ->first();

      return response()->json(['data' => $data]);
  }

  public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $transaksi = transaksi::where('id_transaksi', '=', $id)->first();
        $transaksi->status = $request->status;
        
        $transaksi->save();
        
        return response()->json(['message' => 'Status berhasil diubah']);
    }

    public function bayar($id)
    {
        $transaksi = transaksi::where('id_transaksi', '=', $id)->first();
        $subtotal = detail_transaksi::where('id_transaksi',$id)->sum('subtotal');
        $transaksi->tgl_bayar = Carbon::now();
        $transaksi->status = "Diambil";
        $transaksi->dibayar = "dibayar";
        $transaksi->total_bayar = $subtotal;


        
        $transaksi->save();
        
        return response()->json(['message' => 'Pembayaran berhasil']);
    }

    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_outlet'=> 'required',
            'tahun' => 'required',
            'bulan' => 'required'
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $id_outlet = $request->id_outlet;

        $data = DB::table('transaksi')
            ->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->join('users', 'users.id','=','transaksi.id')
            ->select('transaksi.id', 'transaksi.tgl', 'transaksi.tgl_bayar', 'transaksi.total_bayar', 'member.nama_member','users.name')
            ->where('users.id_outlet', "=", $id_outlet)
            ->whereYear('tgl', '=', $tahun)
            ->whereMonth('tgl', '=', $bulan)
            ->get();

        return response()->json($data);
    }

}



