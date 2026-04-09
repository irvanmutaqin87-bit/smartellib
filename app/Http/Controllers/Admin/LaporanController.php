<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // =========================
    // HALAMAN INDEX LAPORAN
    // =========================
    public function index(Request $request)
    {
        $totalPeminjaman = Peminjaman::count();
        $totalPengembalian = Peminjaman::whereNotNull('tanggal_kembali')->count();
        $totalDenda = Denda::count();
        $totalPendapatanDenda = Denda::where('status_denda', 'lunas')->sum('jumlah_denda');

        return view('admin.laporan.index', compact(
            'totalPeminjaman',
            'totalPengembalian',
            'totalDenda',
            'totalPendapatanDenda'
        ));
    }

    // =========================
    // AJAX DATA LAPORAN
    // =========================
    public function getData(Request $request)
    {
        $jenis = $request->jenis_laporan ?? 'peminjaman';

        if ($jenis === 'peminjaman') {
            return $this->laporanPeminjaman($request);
        }

        if ($jenis === 'pengembalian') {
            return $this->laporanPengembalian($request);
        }

        if ($jenis === 'denda') {
            return $this->laporanDenda($request);
        }

        return response()->json([
            'table' => '<div class="p-6 text-center text-red-500">Jenis laporan tidak valid.</div>',
            'pagination' => '',
        ]);
    }

    // =========================
    // DOWNLOAD PDF
    // =========================
    public function downloadPdf(Request $request)
    {
        $jenis = $request->jenis_laporan ?? 'peminjaman';

        if ($jenis === 'peminjaman') {
            return $this->downloadPeminjamanPdf($request);
        }

        if ($jenis === 'pengembalian') {
            return $this->downloadPengembalianPdf($request);
        }

        if ($jenis === 'denda') {
            return $this->downloadDendaPdf($request);
        }

        abort(404);
    }

    // =========================
    // QUERY FILTER PERIODE
    // =========================
    private function applyDateFilter($query, Request $request, $column)
    {
        $periode = $request->periode;
        $tanggalDari = $request->tanggal_dari;
        $tanggalSampai = $request->tanggal_sampai;

        if ($periode === 'hari_ini') {
            $query->whereDate($column, now()->toDateString());
        } elseif ($periode === '7_hari') {
            $query->whereDate($column, '>=', now()->subDays(6)->toDateString());
        } elseif ($periode === 'bulan_ini') {
            $query->whereMonth($column, now()->month)
                  ->whereYear($column, now()->year);
        } elseif ($periode === 'tahun_ini') {
            $query->whereYear($column, now()->year);
        }

        if ($tanggalDari) {
            $query->whereDate($column, '>=', $tanggalDari);
        }

        if ($tanggalSampai) {
            $query->whereDate($column, '<=', $tanggalSampai);
        }

        if ($request->bulan) {
            $query->whereMonth($column, $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear($column, $request->tahun);
        }

        return $query;
    }

    // =========================
    // LAPORAN PEMINJAMAN
    // =========================
    private function laporanPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['anggota.user', 'buku', 'denda'])
            ->latest();

        $query = $this->applyDateFilter($query, $request, 'tanggal_pinjam');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('buku', function ($sub) use ($search) {
                      $sub->where('judul', 'like', "%{$search}%")
                          ->orWhere('kode_buku', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->paginate(10);

        $table = view('admin.laporan.partials.table', [
            'jenis' => 'peminjaman',
            'data' => $data,
        ])->render();

        return response()->json([
            'table' => $table,
            'pagination' => $data->links()->render(),
            'totalBox' => $data->total(),
        ]);
    }

    // =========================
    // LAPORAN PENGEMBALIAN
    // =========================
    private function laporanPengembalian(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])
            ->whereNotNull('tanggal_kembali')
            ->latest();

        $query = $this->applyDateFilter($query, $request, 'tanggal_kembali');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('buku', function ($sub) use ($search) {
                      $sub->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->paginate(10);

        $table = view('admin.laporan.partials.table', [
            'jenis' => 'pengembalian',
            'data' => $data,
        ])->render();

        return response()->json([
            'table' => $table,
            'pagination' => $data->links()->render(),
            'totalBox' => $data->total(),
        ]);
    }

    // =========================
    // LAPORAN DENDA
    // =========================
    private function laporanDenda(Request $request)
    {
        $query = Denda::with(['peminjaman.anggota.user', 'peminjaman.buku', 'verifikator'])
            ->latest();

        $query = $this->applyDateFilter($query, $request, 'created_at');

        if ($request->status) {
            $query->where('status_denda', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('peminjaman', function ($q) use ($search) {
                $q->whereHas('anggota', function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%");
                })->orWhereHas('buku', function ($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%");
                });
            });
        }

        $data = $query->paginate(10);

        $table = view('admin.laporan.partials.table', [
            'jenis' => 'denda',
            'data' => $data,
        ])->render();

        return response()->json([
            'table' => $table,
            'pagination' => $data->links()->render(),
            'totalBox' => $data->total(),
        ]);
    }

    // =========================
    // PDF PEMINJAMAN
    // =========================
    private function downloadPeminjamanPdf(Request $request)
    {
        $query = Peminjaman::with(['anggota.user', 'buku', 'denda'])->latest();
        $query = $this->applyDateFilter($query, $request, 'tanggal_pinjam');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('buku', function ($sub) use ($search) {
                      $sub->where('judul', 'like', "%{$search}%")
                          ->orWhere('kode_buku', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.peminjaman', [
            'data' => $data,
            'request' => $request,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman.pdf');
    }

    // =========================
    // PDF PENGEMBALIAN
    // =========================
    private function downloadPengembalianPdf(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])
            ->whereNotNull('tanggal_kembali')
            ->latest();

        $query = $this->applyDateFilter($query, $request, 'tanggal_kembali');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('buku', function ($sub) use ($search) {
                      $sub->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.pengembalian', [
            'data' => $data,
            'request' => $request,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengembalian.pdf');
    }

    // =========================
    // PDF DENDA
    // =========================
    private function downloadDendaPdf(Request $request)
    {
        $query = Denda::with(['peminjaman.anggota.user', 'peminjaman.buku', 'verifikator'])->latest();
        $query = $this->applyDateFilter($query, $request, 'created_at');

        if ($request->status) {
            $query->where('status_denda', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('peminjaman', function ($q) use ($search) {
                $q->whereHas('anggota', function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%");
                })->orWhereHas('buku', function ($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%");
                });
            });
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.denda', [
            'data' => $data,
            'request' => $request,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-denda.pdf');
    }
}