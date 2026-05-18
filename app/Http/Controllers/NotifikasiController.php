<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Notifikasi::where('id_users', Auth::id())
            ->latest('id_notifikasi')
            ->take(8)
            ->get()
            ->map(function (Notifikasi $notifikasi) {
                return [
                    'id' => $notifikasi->id_notifikasi,
                    'judul' => $notifikasi->judul,
                    'pesan' => $notifikasi->pesan,
                    'is_read' => (bool) $notifikasi->is_read,
                    'ikon' => $this->iconFor($notifikasi->judul),
                ];
            });

        return response()->json([
            'unreadCount' => Notifikasi::where('id_users', Auth::id())->where('is_read', 0)->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAllRead()
    {
        Notifikasi::where('id_users', Auth::id())->update(['is_read' => 1]);

        return response()->json(['unreadCount' => 0]);
    }

    private function iconFor(string $title): string
    {
        $title = strtolower($title);

        if (str_contains($title, 'promo') || str_contains($title, 'diskon')) {
            return '🎟️';
        }

        if (str_contains($title, 'kirim') || str_contains($title, 'resi')) {
            return '🚚';
        }

        if (str_contains($title, 'bayar')) {
            return '💳';
        }

        return '🔔';
    }
}
