<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
use App\Models\Bebas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class logincontroller extends Controller
{
    public function index(){
        return view ('/login');
    }
    public function aksilogin(Request $Request){
        $name = $Request->input('u');
        $password = $Request->input('p');

        if (!is_string($name) || $name === '' || !is_string($password) || $password === '') {
            return redirect('/')->with('login_error', 'Username atau password salah.');
        }

         $jalur = new database;
         $hasilcek = $jalur->pull('users', ['name' => $name]);
         $passwordMatches = false;

         if ($hasilcek) {
            $storedPassword = $hasilcek->password;
            $passwordInfo = Hash::info($storedPassword);
            $passwordMatches = $passwordInfo['algo'] !== null
                ? Hash::check($password, $storedPassword)
                : hash_equals($storedPassword, $password);
         }

         if($passwordMatches){
            session(['u' => $hasilcek->name]);
            return redirect('/home');
         }
         else{
             return redirect('/')->with('login_error', 'Username atau password salah.');
         }
    }
      public function home(){
          if (session()->has('u')){
        $orders = DB::table('work_orders')->orderByDesc('created_at')->get();
        $parts = DB::table('spare_parts')->orderBy('name')->get();
          $users = DB::table('users')->orderBy('name')->get();
          return view('home', ['orders' => $orders, 'parts' => $parts, 'users' => $users]);
    }
    else{
        return redirect()->intended('/');
    }
}
    public function logout(){
        session()->flush();
        return redirect()->intended('/');
    }

  public function editview($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $jalur = new database;
    $user = $jalur->pull('users', ['id' => $id]);

    abort_if(!$user, 404);

    return view('edit', ['user' => $user ]);
  }

  public function update(Request $request, $id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    ]);

    abort_if(!DB::table('users')->where('id', $id)->exists(), 404);

    database::where('id', $id)->update($data);
    return redirect('/home')->with('success', 'Nama dan email user berhasil diperbarui.');
  }

  public function delete($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    abort_if(!DB::table('users')->where('id', $id)->exists(), 404);

    database::where('id', $id)->delete();
    return redirect('/home')->with('success', 'User berhasil dihapus.');
  }

  public function buatServis() {
    if (!session()->has('u')) {
        return redirect('/');
    }

    return view('service.form', ['order' => null]);
  }

  public function simpanServis(Request $request) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $data = $request->validate($this->aturanServis());
    $data['created_at'] = now();
    $data['updated_at'] = now();
    DB::table('work_orders')->insert($data);

    return redirect('/home')->with('success', 'Data servis berhasil dicatat.');
  }

  public function editServis($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $order = DB::table('work_orders')->where('id', $id)->first();

    abort_if(!$order, 404);

    return view('service.form', ['order' => $order]);
  }

  public function updateServis(Request $request, $id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $data = $request->validate($this->aturanServis());
    $data['updated_at'] = now();
    $updated = DB::table('work_orders')->where('id', $id)->update($data);

    abort_if(!$updated && !DB::table('work_orders')->where('id', $id)->exists(), 404);

    return redirect('/home')->with('success', 'Data servis berhasil diperbarui.');
  }

  public function hapusServis($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $deleted = DB::table('work_orders')->where('id', $id)->delete();

    abort_if(!$deleted, 404);

    return redirect('/home')->with('success', 'Data servis berhasil dihapus.');
  }

  private function aturanServis(): array {
    return [
        'customer_name' => 'required|string|max:120',
        'customer_phone' => 'required|string|max:30',
        'motorcycle' => 'required|string|max:120',
        'license_plate' => 'required|string|max:20',
        'complaint' => 'required|string|max:1000',
        'service_action' => 'nullable|string|max:1000',
        'mechanic' => 'nullable|string|max:120',
        'cost' => 'required|integer|min:0',
        'status' => 'required|in:Menunggu,Dikerjakan,Selesai,Diambil',
        'received_at' => 'required|date',
    ];
  }

  public function buatSukuCadang() {
    if (!session()->has('u')) {
        return redirect('/');
    }

    return view('spare_parts.form', ['part' => null]);
  }

  public function simpanSukuCadang(Request $request) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $data = $request->validate($this->aturanSukuCadang());
    $data['created_at'] = now();
    $data['updated_at'] = now();
    DB::table('spare_parts')->insert($data);

    return redirect('/home')->with('success', 'Suku cadang berhasil ditambahkan.');
  }

  public function editSukuCadang($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $part = DB::table('spare_parts')->where('id', $id)->first();

    abort_if(!$part, 404);

    return view('spare_parts.form', ['part' => $part]);
  }

  public function updateSukuCadang(Request $request, $id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $data = $request->validate($this->aturanSukuCadang($id));
    $data['updated_at'] = now();
    $updated = DB::table('spare_parts')->where('id', $id)->update($data);

    abort_if(!$updated && !DB::table('spare_parts')->where('id', $id)->exists(), 404);

    return redirect('/home')->with('success', 'Data suku cadang berhasil diperbarui.');
  }

  public function hapusSukuCadang($id) {
    if (!session()->has('u')) {
        return redirect('/');
    }

    $deleted = DB::table('spare_parts')->where('id', $id)->delete();

    abort_if(!$deleted, 404);

    return redirect('/home')->with('success', 'Suku cadang berhasil dihapus.');
  }

  private function aturanSukuCadang(?int $id = null): array {
    return [
        'code' => ['required', 'string', 'max:40', 'unique:spare_parts,code' . ($id ? ',' . $id : '')],
        'name' => 'required|string|max:150',
        'category' => 'nullable|string|max:100',
        'unit' => 'required|string|max:30',
        'stock' => 'required|integer|min:0',
        'minimum_stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0|max:9999999999.99',
    ];
  }

    public function exportLaporan(string $format) {
        if (!session()->has('u')) {
            return redirect('/');
        }

        $orders = DB::table('work_orders')
            ->orderByDesc('received_at')
            ->orderByDesc('id')
            ->get();

        if ($format === 'print') {
            return response()->view('reports.work_orders', [
                'orders' => $orders,
                'format' => $format,
            ]);
        }

        $extension = $format === 'excel' ? 'xls' : 'doc';
        $contenttype = $format === 'excel'
            ? 'application/vnd.ms-excel'
            : 'application/msword';

        return response()->view('reports.work_orders', [
            'orders' => $orders,
            'format' => $format,
        ], 200, [
            'Content-Type' => $contenttype . '; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_servis.' . $extension . '"',
        ]);
    }

    public function karyawan()
    {
        if (!session()->has('u')) {
            return redirect('/');
        }

        $karyawan = DB::table('karyawan')->orderBy('id_kry')->get();

        return view('karyawan', ['karyawan' => $karyawan]);
    }

    public function tkry()
    {
        return view("/tkry");
    }

    public function aksi_tkry(Request $request)
    {
        $validated = $request->validate([
            'u' => 'required|string|max:255|unique:users,username',
            'p' => 'required|string|max:255',
            'e' => 'required|string|email|max:255|unique:users,email',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jk' => 'required|in:L,P',
            'l' => 'required|in:1,2,3',
        ]);

        $data = [
            'name' => $validated['u'],
            'username' => $validated['u'],
            'password' => Hash::make($validated['p']),
            'email' => $validated['e'],
            'level' => $validated['l'],
        ];

        DB::transaction(function () use ($data, $validated) {
            $kelvin = new Bebas;
            $userId = $kelvin->tambah('users', $data);

            $kry = [
                'id_user' => $userId,
                'nama_kry' => $validated['nama'],
                'alamat_kry' => $validated['alamat'],
                'jk_kry' => $validated['jk'],
            ];
            DB::table('karyawan')->insert($kry);
        });

        return redirect()->intended('/home');
    }
}
