<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public function logDocument(string $action, array $data): void
    {
        $this->log('document', $action, $data);
    }

    public function logTransaction(string $action, array $data): void
    {
        $this->log('transaction', $action, $data);
    }

    private function log(string $type, string $action, array $data): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'action' => $action,
            'data' => $data,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
} 