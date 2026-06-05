<?php

namespace App\Traits;

use App\Models\Pesanan;

trait OrderStats
{
    /**
     * Get order counts grouped by status.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOrderStats()
    {
        return Pesanan::selectRaw('status_pesanan, count(*) as total')
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');
    }

    /**
     * Map common order status counts for dashboards.
     *
     * @param \Illuminate\Support\Collection $statusCounts
     * @return array
     */
    public function mapStatusCounts($statusCounts)
    {
        return [
            'menunggu' => $statusCounts->get('menunggu', 0),
            'diproses' => $statusCounts->get('diproses', 0),
            'dikirim'  => $statusCounts->get('dikirim', 0),
            'selesai'  => $statusCounts->get('selesai', 0),
            'total'    => $statusCounts->sum(),
        ];
    }
}
