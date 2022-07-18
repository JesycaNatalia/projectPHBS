<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\JawabanUser;
use App\Models\ResponUser;
use App\Models\Kuisoner;
use App\Models\Bulan;
use App\Models\Ppemantauan;
use Illuminate\Http\Request;

class GformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulan = Bulan::orderBy('id', 'desc')->first();
        if ($bulan != null) {
            $respon_user = ResponUser::where([['bulan_id', $bulan->id], ['kartu_keluarga_id', Auth::user()->kartu_keluarga_id]])->first();
            // jika user belum respon atau isi gform maka muncullah dia ke view isi gform 
            if ($respon_user == null) {
                $kuisoner['kuisoners'] = Kuisoner::get();
                return view('user.dashboard.gformkuisoner.index', $kuisoner);
                // kalau user udah ngisi maka muncul ke 
            } else {
                $bulan = Bulan::orderBy('id', 'desc')->first();
                $kuisoner = Kuisoner::count();
                $respon_user['respon_users'] = ResponUser::with('bulan')->where('kartu_keluarga_id', Auth::user()->kartu_keluarga_id)->get();
                return view('user.dashboard.gformkuisoner.detail2', $respon_user, compact('kuisoner', 'bulan'));
            }
        }
    }

    public function getPemantauan($id)
    {
        // $id =  Ppemantauan::findOrFail($id);
        $kuisoners = Kuisoner::where('ppemantauan_id', $id)->get();

        // dd($kuisoners);


        return view('user.dashboard.gformkuisoner.index', [
            'kuisoners' => $kuisoners
        ]);
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
        $pemantauan_id = $request->ppemantauan_id;
        $bulan = Bulan::orderBy('id', 'desc')->first();
        foreach ($request->keys() as $index => $kuisoner_id) {

            if ($index == 0 || $index == (count($request->keys()) - 1)) {
                continue;
            } else {
                JawabanUser::create([
                    'bulan_id' => $bulan->id,
                    'ppemantauan_id' => $pemantauan_id,
                    'kuisoner_id' => $kuisoner_id,
                    'isi_kuisoner_id' => $request->$kuisoner_id,
                    'user_id' => Auth::user()->id,
                ]);
            }
        }

        $jawabans = JawabanUser::with('isi_kuisoner')->where([['bulan_id', $bulan->id], ['user_id', Auth::user()->id], ['ppemantauan_id', $request->ppemantauan_id]])->get();
        $total_skor = 0;
        $skor_nol = 0;
        foreach ($jawabans as $jawaban) {
            $total_skor = $total_skor + $jawaban->isi_kuisoner->skor;
            if ($jawaban->isi_kuisoner->skor == '0') {
                $skor_nol++;
            }
        }

        // $total_skor = 0;
        // $dibagi = 0;
        // dd($total_skor);
        // foreach ($jawabans as $jawaban) {
        //     if ($jawaban->isi_kuisoner->skor == 0) {
        //         $dibagi++;
        //     }
        // }
        // foreach ($jawabans as $jawaban) {
        //     $total_skor = $total_skor + ($jawaban->isi_kuisoner->skor / 10);
        // }
        // dd($total_skor);
        ResponUser::create([
            'bulan_id' => $bulan->id,
            'kartu_keluarga_id' => Auth::user()->kartu_keluarga_id,
            'total_skor' => $total_skor,
            'skor_nol' => $skor_nol,
            'ppemantauan_id' => $pemantauan_id,
            'user_id' => Auth::user()->id,
        ]);

        $bulan = Bulan::orderBy('id', 'desc')->first();
        $kuisoner = Kuisoner::where('ppemantauan_id', $pemantauan_id)->count();
        $respon_user['respon_users'] = ResponUser::with('bulan')->where('kartu_keluarga_id', Auth::user()->kartu_keluarga_id)->get();

        return view('user.dashboard.gformkuisoner.detail', $respon_user, compact('kuisoner', 'bulan'));

        // return redirect(route('user.dashboard.gform.index'))->with("OK", "Berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_result($bulan_id, Request $request)
    {
        $jawaban_user['jawaban_users'] = JawabanUser::with('isi_kuisoner')->where([['bulan_id', $bulan_id], ['user_id', Auth::user()->id], ['ppemantauan_id', $request->ppemantauan_id]])->get();
        $kuisoner['kuisoners'] = Kuisoner::where('ppemantauan_id', $request->ppemantauan_id)->get();
        return view('user.dashboard.gformkuisoner.detail_jawaban', $kuisoner, $jawaban_user);
    }

    public function show($id)
    {
        $bulan = Bulan::orderBy('id', 'desc')->first();
        if ($bulan != null) {
            // $k = Kuisoner::where('ppemantauan_id', $id)->first();
            $respon_user = ResponUser::where([['bulan_id', $bulan->id], ['kartu_keluarga_id', Auth::user()->kartu_keluarga_id], ['ppemantauan_id', $id]])->first();

            // $jawaban_user = JawabanUser::where([['bulan_id', $bulan->id], ['user_id', Auth::user()->id], ['ppemantauan_id', $id]])->first();
            if ($respon_user == null) {
                $kuisoner['kuisoners'] = Kuisoner::where('ppemantauan_id', $id)->get();
                return view('user.dashboard.gformkuisoner.index', $kuisoner);
            } else {
                $bulan = Bulan::orderBy('id', 'desc')->first();
                $kuisoner = Kuisoner::where('ppemantauan_id', $id)->count();
                $respon_user['respon_users'] = ResponUser::with('bulan')->where([['kartu_keluarga_id', Auth::user()->kartu_keluarga_id], ['ppemantauan_id', $id]])->get();
                return view('user.dashboard.gformkuisoner.detail2', $respon_user, compact('kuisoner', 'bulan'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
