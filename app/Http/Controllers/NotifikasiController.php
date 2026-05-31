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
            ->get()
            ->map(function (Notifikasi $notifikasi) {
                $timeString = 'Baru saja';
                if ($notifikasi->created_at) {
                    $diffInMinutes = $notifikasi->created_at->diffInMinutes(now());
                    $diffInHours = $notifikasi->created_at->diffInHours(now());
                    $diffInDays = $notifikasi->created_at->diffInDays(now());

                    if ($diffInMinutes < 10) {
                        $timeString = 'Baru saja';
                    } elseif ($diffInMinutes < 60) {
                        $roundedMinutes = floor($diffInMinutes / 10) * 10;
                        $timeString = $roundedMinutes . ' menit yang lalu';
                    } elseif ($diffInHours < 24) {
                        $timeString = $diffInHours . ' jam yang lalu';
                    } else {
                        $timeString = $diffInDays . ' hari yang lalu';
                    }
                }

                return [
                    'id' => $notifikasi->id_notifikasi,
                    'judul' => $notifikasi->judul,
                    'pesan' => $notifikasi->pesan,
                    'is_read' => (bool) $notifikasi->is_read,
                    'ikon' => $this->iconFor($notifikasi->judul),
                    'created_at' => $timeString,
                ];
            });

        return response()->json([
            'unreadCount' => Notifikasi::where('id_users', Auth::id())->where('is_read', 0)->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->id_users !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notifikasi->update(['is_read' => 1]);

        return response()->json([
            'status' => true,
            'unreadCount' => Notifikasi::where('id_users', Auth::id())->where('is_read', 0)->count()
        ]);
    }

    public function markAllRead()
    {
        Notifikasi::where('id_users', Auth::id())->update(['is_read' => 1]);

        return response()->json(['unreadCount' => 0]);
    }

    public function destroy(Notifikasi $notifikasi)
    {
        if ($notifikasi->id_users !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notifikasi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Notifikasi dihapus',
            'unreadCount' => Notifikasi::where('id_users', Auth::id())->where('is_read', 0)->count()
        ]);
    }

    private function iconFor(string $title): string
    {
        $title = strtolower($title);

        if (str_contains($title, 'promo') || str_contains($title, 'diskon')) {
            return '<i class="fi fi-rr-ticket text-blue-500"></i>';
        }

        if (str_contains($title, 'kirim') || str_contains($title, 'resi')) {
            return '<i class="fi fi-rr-truck-side text-teal-500"></i>';
        }
        
        if (str_contains($title, 'selesai')) {
            return '<i class="fi fi-rr-check-circle text-green-500"></i>';
        }
        
        if (str_contains($title, 'proses')) {
            return '<i class="fi fi-rr-settings text-purple-500"></i>';
        }

        if (str_contains($title, 'bayar')) {
            return '<i class="fi fi-rr-credit-card text-primary"></i>';
        }

        return '<i class="fi fi-rr-bell text-orange-500"></i>';
    }
}
