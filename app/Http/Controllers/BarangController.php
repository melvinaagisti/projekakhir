<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PDF;
use SnappyPDF;

class BarangController extends Controller
{

    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data_request = $request->all();
        $barangs = Barang::paginate(10);


        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        $tanggal = date('Y-m-d');

        return view('sparepart.barang', [
            'barangs' => $barangs,
            'data_request' => $data_request,
            'bulan' => $bulan,
            'tanggal' => $tanggal,
        ])->with('i', ($request->input('page', 1) - 1) * 10);


    }









    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'jabatan_id' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',

        ]);
        // $barang = new barang;
        // $barang->nama = $request->nama;
        // $barang->jabatan_id = $request->jabatan_id;
        // $barang->tanggal_lahir = $request->tanggal_lahir;
        // $barang->nik = $request->nik;
        // $barang->tanggal_masuk = $request->tanggal_masuk;
        // $barang->alamat = $request->alamat;
        // $barang->nohp = $request->nohp;
        // $barang->bank_id = $request->bank_id;
        // $barang->no_rek = $request->no_rek;
        // $barang->atas_nama = $request->atas_nama;
        // $barang->save();




        // if($barangs){
        //     return redirect()->back()->with(['success' => 'Data barang'.$request->input('nama').'berhasil disimpan']);
        // }else{
        //     return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        // }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\barang  $barangs
     * @return \Illuminate\Http\Response
     */
    public function show(barang $barangs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\barang  $barangs
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // $barangs = barang::findOrFail($request->get('id'));
        // $barangs['jam_masuk'] = date('H:i', strtotime($barangs['jam_masuk']));
        // $barangs['jam_istirahat'] = date('H:i', strtotime($barangs['jam_istirahat']));
        // $barangs['jam_masuk_istirahat'] = date('H:i', strtotime($barangs['jam_masuk_istirahat']));
        // $barangs['jam_pulang'] = date('H:i', strtotime($barangs['jam_pulang']));
        // return response()->json($barangs);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\barang  $barangs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, barang $barangs)
    {
        // $this->validate($request, [
        //     'barang_id' => 'required',
        //     'jam_masuk' => 'required',
        //     'jam_istirahat' => 'required',
        //     'jam_masuk_istirahat' => 'required',
        //     'jam_pulang' => 'required',
        //     ]);

        // $barangs = barang::find($request->id);
        // $barangs->update($request->all());

        // if($barangs){
        //     return redirect()->back()->with(['success' => 'Data barang'.$request->input('nama').'berhasil disimpan']);
        // }else{
        //     return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\barang  $barangs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // $barangs = barang::where('id', $id)
        //       ->delete();
        // return redirect()->back()
        //                 ->with('success','Post deleted successfully');
    }


}
