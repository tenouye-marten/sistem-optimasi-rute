<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    /**
     * Menampilkan daftar driver
     */
  public function index(Request $request)
{
    $search = $request->search;

    $drivers = Driver::with('user')
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->orWhere('kode_driver', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.driver.index', compact('drivers', 'search'));
}

    /**
     * Form tambah driver
     */
    public function create()
    {
        return view('admin.driver.create');
    }

    /**
     * Simpan data driver
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'             => 'required|max:100',
            'nik'              => 'required|digits_between:16,20|unique:drivers,nik',
            'no_hp'            => 'required|max:15',
            'alamat'           => 'nullable',
            'jenis_kelamin'    => 'required|in:L,P',
            'status'           => 'required|in:Aktif,Tidak Aktif',
        ]);

        $existingKodes = Driver::pluck('kode_driver')->map(fn($k) => trim($k))->toArray();
        $maxNomor = 0;
        foreach ($existingKodes as $k) {
            if (preg_match('/(\d+)/', $k, $match)) {
                $num = (int) $match[1];
                if ($num > $maxNomor) {
                    $maxNomor = $num;
                }
            }
        }

        $nomor = $maxNomor + 1;

        do {
            $kodeDriver = 'DRV' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
            $nomor++;
        } while (
            in_array($kodeDriver, $existingKodes) ||
            Driver::where('kode_driver', $kodeDriver)->orWhere('kode_driver', 'like', $kodeDriver . '%')->exists()
        );

        Driver::create([
            'kode_driver'      => $kodeDriver,
            'nama'             => $request->nama,
            'nik'              => $request->nik,
            'no_hp'            => $request->no_hp,
            'alamat'           => $request->alamat,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'status'           => $request->status,
        ]);

        return redirect()
            ->route('admin.driver.index')
            ->with('success', 'Data Driver berhasil ditambahkan.');
    }

    /**
     * Detail Driver
     */
   public function show(Driver $driver)
{
    $driver->load('user.roles');

    return view('admin.driver.show', compact('driver'));
}

    /**
     * Form Edit Driver
     */
    public function edit(Driver $driver)
    {
        return view('admin.driver.edit', compact('driver'));
    }

    /**
     * Update Driver
     */
    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'nama'             => 'required|max:100',
            'nik'              => 'required|digits_between:16,20|unique:drivers,nik,' . $driver->id,
            'no_hp'            => 'required|max:15',
            'alamat'           => 'nullable',
            'jenis_kelamin'    => 'required|in:L,P',
            'status'           => 'required|in:Aktif,Tidak Aktif',
        ]);

        $driver->update([
            'nama'             => $request->nama,
            'nik'              => $request->nik,
            'no_hp'            => $request->no_hp,
            'alamat'           => $request->alamat,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'status'           => $request->status,
        ]);

        return redirect()
            ->route('admin.driver.index')
            ->with('success', 'Data Driver berhasil diperbarui.');
    }

    /**
     * Hapus Driver
     */
 public function destroy(Driver $driver)
{
    if ($driver->user) {
        $driver->user->delete();
    }

    $driver->delete();

    return redirect()
        ->route('admin.driver.index')
        ->with('success', 'Data Driver berhasil dihapus.');
}
    /**
 * Form Buat Akun Driver
 */
public function createAccount(Driver $driver)
{
    if ($driver->user) {
        return redirect()
            ->route('admin.driver.show', $driver)
            ->with('warning', 'Driver sudah memiliki akun login.');
    }

    return view('admin.driver.account.create', compact('driver'));
}


/**
 * Simpan Akun Driver
 */
public function storeAccount(Request $request, Driver $driver)
{
    if ($driver->user) {
        return redirect()
            ->route('admin.driver.show', $driver)
            ->with('warning', 'Driver sudah memiliki akun login.');
    }

    $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $user = User::create([
        'driver_id' => $driver->id,
        'name'      => $driver->nama,
        'email'     => $request->email,
        'password'  => Hash::make('password'),
    ]);

    

    $user->assignRole('driver');

    return redirect()
        ->route('admin.driver.show', $driver)
        ->with('success', 'Akun driver berhasil dibuat.');
}


/**
 * Reset Password Driver
 */
public function resetPassword(Driver $driver)
{
    if (!$driver->user) {

        return redirect()
            ->route('admin.driver.show', $driver)
            ->with('error', 'Driver belum memiliki akun login.');

    }

    $driver->user->update([

        'password' => Hash::make('password'),

    ]);

    return redirect()
        ->route('admin.driver.show', $driver)
        ->with('success', 'Password berhasil direset menjadi "password".');
}

}