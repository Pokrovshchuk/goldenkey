<?php

namespace App\Filters;

use Carbon\Carbon;

class CertificatesFilter extends QueryFilter
{
    public function DateFrom($date)
    {
        $date = Carbon::parse($date);
        $this->query->whereDate('created_at', '>=', $date);
    }

    public function DateTo($date)
    {
        $date = Carbon::parse($date);
        $this->query->whereDate('created_at', '<=', $date);
    }

    public function Status($status)
    {
        $this->query->where('status', $status);
    }

    public function Search($search)
    {
        $this->query->where('id', $search)
            ->orWhere('user_name', 'LIKE', "%${search}%");
    }
}
