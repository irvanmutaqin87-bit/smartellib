<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
      // =====================
      // STATISTIK
      // =====================
      $totalBuku = Buku::count();
      $totalAnggota = User::where('role', 'anggota')->count();
      $totalPeminjaman = Peminjaman::count();
      $totalDenda = \App\Models\Denda::sum('jumlah_denda');

      $filter = $request->get('filter', 'bulanan');

      $labels = [];
      $data = [];

      if ($filter == 'harian') {
          for ($i = 6; $i >= 0; $i--) {
              $date = Carbon::now()->subDays($i)->format('Y-m-d');
              $labels[] = $date;

              $data[] = Peminjaman::whereDate('created_at', $date)->count();
          }
      }

      if ($filter == 'bulanan') {
          for ($i = 5; $i >= 0; $i--) {
              $month = Carbon::now()->subMonths($i);

              $labels[] = $month->format('M Y');

              $data[] = Peminjaman::whereMonth('created_at', $month->month)
                  ->whereYear('created_at', $month->year)
                  ->count();
          }
      }

      if ($filter == 'tahunan') {
          for ($i = 4; $i >= 0; $i--) {
              $year = Carbon::now()->subYears($i)->year;

              $labels[] = $year;

              $data[] = Peminjaman::whereYear('created_at', $year)->count();
          }
      }

      // AJAX CHART
      if ($request->ajax()) {
          return response()->json([
              'labels' => $labels,
              'data' => $data
          ]);
      }

      return view('petugas.dashboard.index', [
          'labels' => $labels,
          'data' => $data,
          'totalBuku' => $totalBuku,
          'totalAnggota' => $totalAnggota,
          'totalPeminjaman' => $totalPeminjaman,
          'totalDenda' => $totalDenda,
          'peminjaman' => Peminjaman::latest()->limit(5)->get(),
          'buku' => Buku::latest()->limit(5)->get(),
          'anggota' => User::where('role','anggota')->latest()->limit(5)->get(),
      ]);
  }
}