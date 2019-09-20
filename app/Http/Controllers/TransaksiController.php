<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\User;

class TransaksiController extends Controller
{
    //

    public function index(){
        $transaksi=Transaksi::all();
        //$data=['transaksi'=>$transaksi];
        return $transaksi;
    }

    public function create(Request $request, $id){
      //$username = $request->username;
      $user = User::find($id); 
      $transaksi = new Transaksi();

      $transaksi->username = $user->username;
      $transaksi->jenis=$request->jenis;
      $transaksi->nama_transaksi=$request->nama_transaksi;
      $transaksi->jumlah=$request->jumlah;
      $transaksi->save();

      if ($user != null) {
        if($request->jenis == "kredit"){
          $user->jumlah_saldo =$user->jumlah_saldo - $request->jumlah;
          $user->save();
        }else if($request->jenis == "debit"){
          $user->jumlah_saldo =$user->jumlah_saldo + $request->jumlah;
          $user->save();
        } else{
            return "Data salah";
        }
      }else{
        return "akun";
      }
      
     
      return "Berhasil";
    }

   
}
