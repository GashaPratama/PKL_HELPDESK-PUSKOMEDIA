<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * List tiket + filter (q, status, kategori_id) + pagination
     */
    public function index(Request $request)
    {
        $q        = $request->input('q');
        $status   = $request->input('status');
        $kategori = $request->input('kategori'); // <-- ini ID kategori dari dropdown

        // Dropdown kategori langsung dari tabel kategoris
        // hasil: ['1' => 'Hardware', '2' => 'Jaringan', ...]
        $categoryOptions = Kategori::orderBy('nama')->pluck('nama', 'id');

        $tickets = Laporan::with(['kategori']) // eager load biar di blade bisa $t->kategori->nama
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('kendala', 'like', "%{$q}%")
                      ->orWhere('url_situs', 'like', "%{$q}%")
                      ->orWhere('ticket_id', 'like', "%{$q}%")
                      ->orWhere('id', 'like', "%{$q}%");
                });
            })
            ->when($status, fn ($qr) => $qr->where('status', $status))
            ->when($kategori, fn ($qr) => $qr->where('kategori_id', $kategori))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('superadmin.tickets.index', compact('tickets', 'q', 'status', 'kategori', 'categoryOptions'));
    }

    /**
     * Update status tiket (Di Cek / Diproses / Selesai / Ditolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Di Cek,Diproses,Selesai,Ditolak',
        ]);

        // Cari berdasarkan ticket_id ATAU id (fallback)
        $ticket = Laporan::where('ticket_id', $id)
                    ->orWhere('id', $id)
                    ->firstOrFail();

        $ticket->status = $request->status;
        $ticket->save();

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Opsional: endpoint kategori untuk kebutuhan lain (AJAX, dsb)
     */
    public function listCategories()
    {
        // Kembalikan array ['id' => 'nama'] agar mudah dipakai
        return response()->json(
            Kategori::orderBy('nama')->pluck('nama', 'id')
        );
    }
}
