<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class SearchController extends Controller
{
    // halaman search
    public function index()
    {
        return view('anggota.search');
    }

    // query AJAX
    public function search(Request $request)
    {
        $q = $request->q;

        $books = Buku::where('judul', 'like', "%$q%")
            ->orWhere('penulis', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json($books);
    }
}