<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\paket;

class paketController extends Controller
{
  public $user;

  public function __construct()
  {
    // this->$user = JWTAuth::parseToken()->authenticate();
  }
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
      'jenis'  => 'required|string',
      'harga'  => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors());
    }

    $paket = new paket();
    $paket -> jenis   = $request -> jenis;
    $paket -> harga   = $request -> harga;

    $paket->save();
    $data = paket::where('id_paket', '=', $paket->id)->first();

    return Response()->json([
      'success' => true,
      'message' => 'Data paket berhasil ditambahkan',
      'data' => $data
    ]);
  }

  public function getAll()
  {
     

      $data= paket::get();

      return response()->json(['data' => $data]);
  }

  public function getById($id)
  {
      $data['paket'] = paket::where('id_paket', '=', $id)->first();

      return response()->json(['data' => $data]);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(),[
      'jenis'  => 'required|string',
      'harga'  => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors());
    }

    $paket = paket::where('id_paket', '=', $id)->first();
    $paket -> jenis   = $request -> jenis;
    $paket -> harga   = $request -> harga;

    $paket->save();

    return Response()->json(['message' => 'Data paket berhasil diubah']);
  }

 public function delete($id_paket)
    {
        $delete = Paket::where('id_paket', '=', $id_paket)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data user gagal dihapus'
            ]);
        }
    }
}