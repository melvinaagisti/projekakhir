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


    public function filterkehadiran(Request $request)
    {
        $jabatans = User::all();
        $data_request = $request->all();
        $pegawai_id = User::where('nama','like',"%".$request->filter_nama."%")->pluck('id');
        // $bulan_id = date('Y') .'-' . $request->filter_bulan .'-' . $request->filter_tanggal;


        $tanggal = $request->filter_tanggal;

        if ($request->filter_nama == ''):
            $kehadirans = Kehadiran::select('kehadirans.*', 'pegawais.id as pegawaiID', 'pegawais.nama as nama_pegawai')
                        ->join('pegawais', 'pegawais.id', '=', 'kehadirans.pegawai_id')
                        ->where('tanggal', $tanggal)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        elseif( !$pegawai_id->isEmpty()):
            $kehadirans = Kehadiran::select('kehadirans.*', 'pegawais.id as pegawaiID', 'pegawais.nama as nama_pegawai')
                        ->join('pegawais', 'pegawais.id', '=', 'kehadirans.pegawai_id')
                        ->where('tanggal', $tanggal)
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('pegawai_id', 'asc')
                        ->paginate(10);
        else:
            $kehadirans = array();
        endif;
        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $jumlahPegawai = Kehadiran::where('tanggal', $tanggal)
        ->where('jam_masuk', '!=', null)
        ->orderBy('tanggal', 'asc')
        ->orderBy('pegawai_id', 'asc');
        foreach ($jabatans as $item):
            $jabatan_total[$item->id] = Kehadiran::where('tanggal', $tanggal)
                    ->join('pegawais', 'kehadirans.pegawai_id' ,'=','pegawais.id')
                    ->join('jabatans', 'pegawais.jabatan_id' ,'=','jabatans.id')
                    ->where('jam_masuk', '!=', null)
                    ->where('jabatan_id', $item->id)
                    ->get();
        endforeach;
        return view('gocay.kehadiran', [
            'kehadirans' => $kehadirans,
            'jumlahPegawai' => $jumlahPegawai,
            'jabatan_total' => $jabatan_total,
            'jabatans' => $jabatans,
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
        // $pegawai = new Pegawai;
        // $pegawai->nama = $request->nama;
        // $pegawai->jabatan_id = $request->jabatan_id;
        // $pegawai->tanggal_lahir = $request->tanggal_lahir;
        // $pegawai->nik = $request->nik;
        // $pegawai->tanggal_masuk = $request->tanggal_masuk;
        // $pegawai->alamat = $request->alamat;
        // $pegawai->nohp = $request->nohp;
        // $pegawai->bank_id = $request->bank_id;
        // $pegawai->no_rek = $request->no_rek;
        // $pegawai->atas_nama = $request->atas_nama;
        // $pegawai->save();




        if($kehadirans){
            return redirect()->back()->with(['success' => 'Data Pegawai'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function show(Kehadiran $kehadirans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // $kehadirans = Kehadiran::findOrFail($request->get('id'));
        // $kehadirans['jam_masuk'] = date('H:i', strtotime($kehadirans['jam_masuk']));
        // $kehadirans['jam_istirahat'] = date('H:i', strtotime($kehadirans['jam_istirahat']));
        // $kehadirans['jam_masuk_istirahat'] = date('H:i', strtotime($kehadirans['jam_masuk_istirahat']));
        // $kehadirans['jam_pulang'] = date('H:i', strtotime($kehadirans['jam_pulang']));
        // return response()->json($kehadirans);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kehadiran $kehadirans)
    {
        // $this->validate($request, [
        //     'pegawai_id' => 'required',
        //     'jam_masuk' => 'required',
        //     'jam_istirahat' => 'required',
        //     'jam_masuk_istirahat' => 'required',
        //     'jam_pulang' => 'required',
        //     ]);

        // $kehadirans = Kehadiran::find($request->id);
        // $kehadirans->update($request->all());

        // if($kehadirans){
        //     return redirect()->back()->with(['success' => 'Data Kehadiran'.$request->input('nama').'berhasil disimpan']);
        // }else{
        //     return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kehadiran  $kehadirans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // $kehadirans = Kehadiran::where('id', $id)
        //       ->delete();
        // return redirect()->back()
        //                 ->with('success','Post deleted successfully');
    }

     public function ExportPDFKehadiraBulanan(Request $request)
    {
     set_time_limit(10000);
     $month = date('m', strtotime($request->tanggal));
    //  $pegawais_count = Pegawai::get()->count('id');
     // dd($pegawais_count);
     $pegawais = Pegawai::limit(5)
                ->get();
                $jadwals = Jadwal::all();
                // dd($pegawais);
        // $batas_tanggal = date('t');
        // $kehadiran_bulanan = Kehadiran::whereBetween('tanggal', [date('Y-m-d', strtotime('first day of this month')),date('Y-m-d', strtotime('last day of this month'))])
        // ->whereYear('tanggal', date('Y'))
        // ->whereMonth('tanggal', date('m'))
        // ->orderBy('pegawai_id', 'asc')
        // ->orderBy('tanggal', 'asc')
        // ->get();
        $tanggal = date('Y') .'-' . date('m') .'-' . $request->tanggal;
        $kehadiran_data = Kehadiran::where('tanggal', $tanggal)
        ->where('pegawai_id', $request->pegawai_id)
        ->get();
        $bulan_jadwal = Kehadiran::orderBy('tanggal', 'desc')
        ->select('tanggal',DB::raw('YEAR(tanggal) year, MONTH(tanggal) month'))
        ->groupBy('year','month')
        ->whereRaw('MONTH(tanggal) = '. $month)->first()
        ->get();
        // dd($bulan_jadwal);
        // foreach ($pegawais as $p):
        //     for ($x=1; $x <= date('t'); $x++):
        //         $tanggal = date('Y') .'-' . date('m') .'-' . $x;
        //         $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
        //         ->where('pegawai_id', $p->id)
        //         ->limit(5)
        //         ->get();
        //     endfor;
        // endforeach;
        // $tanggal_terakhir = Kehadiran::latest()->first();

        // $kehadirans = Kehadiran::where('tanggal', Carbon::now()->toDateString())
        // ->orderBy('tanggal', 'asc')
        // ->orderBy('pegawai_id', 'asc')
        // ->paginate(10);


        // $setting = Setting::all();
        // dd($kehadiran_bulanan);

        $pegawais = Pegawai::all();
        foreach ($pegawais as $p):
            for ($x=1; $x <= date('t', strtotime($month)); $x++):
                $tanggal = date('Y') .'-' . $month .'-' . $x;
                $kehadiran_bulanan[$p->id][$x] = Kehadiran::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->get();
                $jadwal[$p->id][$x] = Jadwal::where('tanggal', date('Y-m-d', strtotime($tanggal)))
                ->where('pegawai_id', $p->id)
                ->first();
                if($jadwal[$p->id][$x] != null):
                    $polas[$p->id][$x] = Pola::where('id', $jadwal[$p->id][$x]->pola_id)->first();
                else:
                    $polas[$p->id][$x] = Pola::where('id', 1)->first();
                endif;
            endfor;
        endforeach;
      $pdf = SnappyPDF::loadView('gocay.cetak.kehadiran_bulanan', [
            'kehadiran_bulanan' => $kehadiran_bulanan,
            // 'kehadirans' => $kehadirans,
            'bulan_jadwal' => $bulan_jadwal,
            'jadwals' => $jadwals,
            'polas' => $polas,
            'bulan' => $request->tanggal,
            'pegawais' => $pegawais,
    ])->setPaper('a4','landscape')
    ->setOption('margin-top', 4)
    ->setOption('margin-bottom', 4)
    ->setOption('margin-left', 4)
    ->setOption('margin-right', 4);
      // download PDF file with download method
      return $pdf->stream('Kehadiran Bulanan Bulan '.'.pdf');
    }
}
