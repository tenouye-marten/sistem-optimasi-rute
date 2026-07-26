<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\OptimasiRute;
use App\Models\OptimasiRuteDetail;
use App\Models\Pengangkutan;
use App\Models\PengangkutanDetail;
use App\Models\Pool;
use App\Models\Tpa;
use App\Models\Tps;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengangkutanSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();
        $kendaraans = Kendaraan::all();
        $pool = Pool::first();
        $tpa = Tpa::first();
        $tpsList = Tps::all();

        if ($drivers->count() < 3 || $tpsList->count() < 3 || !$pool || !$tpa) {
            return;
        }

        DB::transaction(function () use ($drivers, $kendaraans, $pool, $tpa, $tpsList) {

            // Data skenario historis (Hari lalu sampai hari ini)
            $scenarios = [
                // 1. Hari Ini - Driver 1 (Selesai Pagi)
                [
                    'driver_idx' => 0,
                    'days_ago'   => 0,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 7,
                    'end_hour'   => 10,
                    'tps_indices'=> [0, 1, 2],
                    'volumes'    => [650, 700, 850],
                    'ket'        => 'Pengangkutan Pagi Sentani Kota & Hawai',
                ],

                // 2. Hari Ini - Driver 2 (Sedang Berjalan)
                [
                    'driver_idx' => 1,
                    'days_ago'   => 0,
                    'status'     => 'Sedang Berjalan',
                    'status_pj'  => 'Menuju TPS',
                    'start_hour' => 9,
                    'end_hour'   => null,
                    'tps_indices'=> [3, 4, 5],
                    'volumes'    => [800, 0, 0], // TPS 1 selesai, sisanya belum
                    'ket'        => 'Pengangkutan Siang Doyo Baru & Kemiri',
                ],

                // 3. Hari Ini - Driver 3 (Belum Berangkat)
                [
                    'driver_idx' => 2,
                    'days_ago'   => 0,
                    'status'     => 'Belum Berangkat',
                    'status_pj'  => 'Menuju TPS',
                    'start_hour' => null,
                    'end_hour'   => null,
                    'tps_indices'=> [0, 2, 4],
                    'volumes'    => [0, 0, 0],
                    'ket'        => 'Pengangkutan Sore Sentani Barat',
                ],

                // 4. Kemarin (Sub 1 Day) - Driver 1 (Selesai)
                [
                    'driver_idx' => 0,
                    'days_ago'   => 1,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 6,
                    'end_hour'   => 9,
                    'tps_indices'=> [1, 3, 5],
                    'volumes'    => [720, 810, 940],
                    'ket'        => 'Pengangkutan Rutin Kemarin Pagi',
                ],

                // 5. Kemarin (Sub 1 Day) - Driver 2 (Selesai)
                [
                    'driver_idx' => 1,
                    'days_ago'   => 1,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 8,
                    'end_hour'   => 11,
                    'tps_indices'=> [0, 2, 4],
                    'volumes'    => [900, 650, 780],
                    'ket'        => 'Pengangkutan Pasar Pharaa & Pos 7',
                ],

                // 6. 2 Hari Lalu (Sub 2 Days) - Driver 3 (Selesai)
                [
                    'driver_idx' => 2,
                    'days_ago'   => 2,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 7,
                    'end_hour'   => 10,
                    'tps_indices'=> [2, 3, 5],
                    'volumes'    => [850, 790, 1100],
                    'ket'        => 'Pengangkutan Wilayah Barat',
                ],

                // 7. 3 Hari Lalu (Sub 3 Days) - Driver 1 (Selesai)
                [
                    'driver_idx' => 0,
                    'days_ago'   => 3,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 6,
                    'end_hour'   => 9,
                    'tps_indices'=> [0, 1, 4],
                    'volumes'    => [1100, 680, 750],
                    'ket'        => 'Pengangkutan Rutin Sentani',
                ],

                // 8. 5 Hari Lalu (Sub 5 Days) - Driver 2 (Selesai)
                [
                    'driver_idx' => 1,
                    'days_ago'   => 5,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 8,
                    'end_hour'   => 11,
                    'tps_indices'=> [1, 2, 3],
                    'volumes'    => [780, 890, 920],
                    'ket'        => 'Pengangkutan Tengah Minggu',
                ],

                // 9. 7 Hari Lalu (Sub 7 Days) - Driver 3 (Selesai)
                [
                    'driver_idx' => 2,
                    'days_ago'   => 7,
                    'status'     => 'Selesai',
                    'status_pj'  => 'Selesai',
                    'start_hour' => 7,
                    'end_hour'   => 10,
                    'tps_indices'=> [0, 4, 5],
                    'volumes'    => [1050, 720, 860],
                    'ket'        => 'Pengangkutan Mingguan Pasar',
                ],
            ];

            foreach ($scenarios as $key => $sc) {
                $driver = $drivers[$sc['driver_idx'] % $drivers->count()];
                $kendaraan = $kendaraans->where('driver_id', $driver->id)->first() ?? $kendaraans->first();
                $tanggal = Carbon::today()->subDays($sc['days_ago']);

                $kodeOpt = 'OPT-' . $tanggal->format('Ymd') . '-00' . ($sc['driver_idx'] + 1);

                // Create Optimasi Rute
                $optimasi = OptimasiRute::create([
                    'kode_optimasi'    => $kodeOpt,
                    'tanggal_generate' => $tanggal,
                    'driver_id'        => $driver->id,
                    'kendaraan_id'     => $kendaraan->id,
                    'pool_id'          => $pool->id,
                    'tpa_id'           => $tpa->id,
                    'jumlah_tps'       => count($sc['tps_indices']),
                    'total_jarak'      => 10.5 + ($key * 2.5),
                    'estimasi_waktu'   => 40 + ($key * 5),
                    'status'           => 'Aktif',
                    'keterangan'       => $sc['ket'],
                ]);

                // Create Optimasi Details
                $optDetails = [];
                foreach ($sc['tps_indices'] as $seq => $tpsIdx) {
                    $tpsItem = $tpsList[$tpsIdx % $tpsList->count()];
                    $optDetails[] = OptimasiRuteDetail::create([
                        'optimasi_rute_id' => $optimasi->id,
                        'tps_id'           => $tpsItem->id,
                        'urutan'           => $seq + 1,
                        'jarak'            => 3.5 + $seq,
                        'estimasi_waktu'   => 15,
                    ]);
                }

                // Calculated values
                $totalVolumeDiangkut = array_sum($sc['volumes']);
                $waktuMulai = $sc['start_hour'] ? (clone $tanggal)->setHour($sc['start_hour'])->setMinute(0) : null;
                $waktuSelesai = $sc['end_hour'] ? (clone $tanggal)->setHour($sc['end_hour'])->setMinute(30) : null;
                
                $muatanSekarang = 0;
                if ($sc['status'] == 'Sedang Berjalan') {
                    $muatanSekarang = $sc['volumes'][0]; // TPS pertama selesai
                }

                // Create Pengangkutan
                $pengangkutan = Pengangkutan::create([
                    'optimasi_rute_id'    => $optimasi->id,
                    'driver_id'           => $driver->id,
                    'tanggal'             => $tanggal,
                    'waktu_mulai'         => $waktuMulai,
                    'waktu_selesai'       => $waktuSelesai,
                    'status'              => $sc['status'],
                    'status_perjalanan'    => $sc['status_pj'],
                    'kapasitas_kendaraan' => $kendaraan->kapasitas,
                    'muatan_sekarang'     => $muatanSekarang,
                    'keterangan'          => $sc['ket'],
                ]);

                // Create Pengangkutan Details
                foreach ($optDetails as $seq => $detailOpt) {
                    $volDiangkut = $sc['volumes'][$seq] ?? 0;
                    $statusDetail = 'Belum';

                    if ($sc['status'] == 'Selesai') {
                        $statusDetail = 'Selesai';
                    } elseif ($sc['status'] == 'Sedang Berjalan') {
                        $statusDetail = ($seq === 0) ? 'Selesai' : (($seq === 1) ? 'Proses' : 'Belum');
                    }

                    $tiba = $waktuMulai ? (clone $waktuMulai)->addMinutes($seq * 35) : null;
                    $selesaiTPS = $tiba ? (clone $tiba)->addMinutes(15) : null;

                    PengangkutanDetail::create([
                        'pengangkutan_id'         => $pengangkutan->id,
                        'optimasi_rute_detail_id' => $detailOpt->id,
                        'tps_id'                  => $detailOpt->tps_id,
                        'urutan'                  => $detailOpt->urutan,
                        'volume_total'            => $volDiangkut > 0 ? $volDiangkut : 750,
                        'volume_diangkut'         => $volDiangkut,
                        'volume_sisa'             => ($statusDetail == 'Selesai') ? 0 : 750,
                        'waktu_tiba'              => $statusDetail != 'Belum' ? $tiba : null,
                        'waktu_selesai'           => $statusDetail == 'Selesai' ? $selesaiTPS : null,
                        'status'                  => $statusDetail,
                    ]);
                }
            }
        });
    }
}