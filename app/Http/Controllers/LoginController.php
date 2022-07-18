<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kuisoner;
use App\Models\Ppemantauan;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\Bulan;
use App\Models\ResponUser;
use App\Models\StatusKeluarga;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // buat request nama login sesuai dengan username yang dimasukkan
        $user = User::where('nama', $request->nama)->first();
        if ($user == null) {
            return redirect()->back()->with('ERR', 'Nama yang Anda masukkan tidak terdaftar.');
        }
        if (!Auth::attempt(['nama' => $request->nama, 'password' => $request->password])) {
            return redirect()->back()->with('ERR', 'Password yang Anda masukkan salah.');
        }

        // pengkondisian buat halaman yang muncul setelah login
        // variabel chart diinisialisaiin karena di halaman view dashboard itu ada variabel chart
        $chart = (new LarapexChart)->areaChart();
        if (Auth::user()->role == 'admin') {
            return view('admin.dashboard.dashboard.index',  ['chart' => $chart]);
        } else if (Auth::user()->role == 'ketuart') {
            return view('ketuart.dashboard.index');
        } else {
            // di halaman view dashboard user ga ada variabel yang dipake, makanya jesyy ga inisialisasiin apa apa
            return redirect()->route('user.dashboard.dashboard.index');
        }
    }

    public function index_register()
    {
        return view('auth.register');
    }

    public function reset_password()
    {
        return view('auth.passwords.reset');
    }

    public function update_password(Request $request)
    {
        $user = User::where('nik', $request->nik)->first();
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $data_kk = KartuKeluarga::where('no_kk', $request->no_kk)->first();
        if ($data_kk == null) {
            $kartu_keluarga = KartuKeluarga::create([
                'no_kk' => $request->no_kk,
            ]);
        } else {
            $kartu_keluarga = $data_kk;
        }

        $user = User::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'kartu_keluarga_id' => $kartu_keluarga->id,
            'status_kepala' => $request->status_kepala,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => bcrypt($request->password),
            'role' => 'user'
        ]);

        StatusKeluarga::create([
            'kartu_keluarga_id' => $kartu_keluarga->id,
            'user_id' => $user->id,
        ]);

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('OK', 'Berhasil logout');
    }
}
