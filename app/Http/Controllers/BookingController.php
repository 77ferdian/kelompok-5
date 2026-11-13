<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $allBookings = Booking::all();
        $total     = $allBookings->count();
        $menunggu  = $allBookings->where('status', 'menunggu')->count();
        $disetujui = $allBookings->where('status', 'disetujui')->count();
        $selesai   = $allBookings->where('status', 'selesai')->count();

        $query = Booking::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();
        return view('bookings.index', compact('bookings', 'total', 'menunggu', 'disetujui', 'selesai'));
    }

    public function analytics()
    {
        $allBookings = Booking::all();
        $totalBookings = $allBookings->count();
        $avgLamaSewa = $totalBookings > 0 ? round($allBookings->avg('lama_sewa'), 1) : 0;
        $totalHariSewa = $allBookings->sum('lama_sewa');
        $selesaiCount = $allBookings->where('status', 'selesai')->count();
        $completionRate = $totalBookings > 0 ? round(($selesaiCount / $totalBookings) * 100, 1) : 0;

        // 1. Perbandingan Jenis Kendaraan (Mobil vs Motor)
        $jenisCounts = [
            'mobil' => $allBookings->where('jenis_kendaraan', 'mobil')->count(),
            'motor' => $allBookings->where('jenis_kendaraan', 'motor')->count(),
        ];

        // 2. Distribusi Status Booking
        $statusCounts = [
            'menunggu'  => $allBookings->where('status', 'menunggu')->count(),
            'disetujui' => $allBookings->where('status', 'disetujui')->count(),
            'selesai'   => $allBookings->where('status', 'selesai')->count(),
            'batal'     => $allBookings->where('status', 'batal')->count(),
        ];

        // 3. Top 5 Kendaraan Terpopuler
        $topVehicles = Booking::select('nama_kendaraan', DB::raw('count(*) as total'))
            ->groupBy('nama_kendaraan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 4. Tren Booking Bulanan (6 Bulan Terakhir)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth()->toDateString();
            $endOfMonth = $month->copy()->endOfMonth()->toDateString();
            $monthLabel = $month->translatedFormat('M Y');

            $count = Booking::whereBetween('tanggal_sewa', [$startOfMonth, $endOfMonth])->count();
            $monthlyTrend['labels'][] = $monthLabel;
            $monthlyTrend['data'][] = $count;
        }

        return view('bookings.analytics', compact(
            'totalBookings',
            'avgLamaSewa',
            'totalHariSewa',
            'completionRate',
            'jenisCounts',
            'statusCounts',
            'topVehicles',
            'monthlyTrend'
        ));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'no_hp' => 'required',
            'jenis_kendaraan' => 'required',
            'nama_kendaraan' => 'required',
            'tanggal_sewa' => 'required|date',
            'lama_sewa' => 'required|numeric',
        ]);

        Booking::create($request->all());

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil ditambahkan!');
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'no_hp' => 'required',
            'jenis_kendaraan' => 'required',
            'nama_kendaraan' => 'required',
            'tanggal_sewa' => 'required|date',
            'lama_sewa' => 'required|numeric',
            'status' => 'required',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')->with('success', 'Data booking berhasil diperbarui!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Data booking berhasil dihapus!');
    }
    //
}
