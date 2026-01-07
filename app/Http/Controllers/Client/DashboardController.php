<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Transaction;
use App\Models\Rate;
use App\Models\Vault;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(): View
    {



        // Ensure user is authenticated - this helps with session restoration
        $user = Auth::user();




        if (!$user) {
            // If user is not authenticated, redirect to login
            return redirect()->route('login');
        }

        // Calculate total documents
        $totalDocuments = Document::where('user_id', $user->id)->count();

        // Calculate storage used (sum of all document file sizes)
        $storageUsed = 0;
        $userDocuments = Document::where('user_id', $user->id)->get();
        foreach ($userDocuments as $doc) {
            if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
                $storageUsed += Storage::disk('public')->size($doc->file_path);
            }
        }

        // Format storage used for display
        $storageUsedFormatted = $this->formatBytes($storageUsed);

        $stats = [
            'total_documents' => $totalDocuments,
            'pending_documents' => Document::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'total_transactions' => Transaction::where('user_id', $user->id)->count(),
            'pending_transactions' => Transaction::where('user_id', $user->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->count(),
        ];

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent documents with formatted size
        $recentDocuments = Document::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($document) {
                // Calculate file size from storage
                $fileSize = 0;
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    $fileSize = Storage::disk('public')->size($document->file_path);
                }

                return (object) [
                    'id' => $document->id,
                    'name' => $document->title ?? 'Untitled',
                    'type' => $document->type ? ucwords(str_replace('_', ' ', $document->type)) : 'Unknown',
                    'size' => $this->formatBytes($fileSize),
                    'created_at' => $document->created_at,
                ];
            });

        $currentRate = Rate::latest()->first();




        // Vault Capacity Logic
        $userVaultsCount = $user->vaults()->count();
        $vaultCapacityPerVaultOz = Vault::CAPACITY_KG * 35.274; // Convert KG to Oz
        $totalVaultCapacity = $userVaultsCount * $vaultCapacityPerVaultOz;
        $currentGoldBalance = $user->gold_balance;

        $showCapacityWarning = false;
        if ($userVaultsCount > 0 && $currentGoldBalance > $totalVaultCapacity) {
            $showCapacityWarning = true;
        } elseif ($userVaultsCount == 0 && $currentGoldBalance > 0) {
            // If user has no vaults but has gold, technically they need a vault.
            $showCapacityWarning = true;
        }

        return view('client.dashboard', [
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'recentDocuments' => $recentDocuments,
            'currentRate' => $currentRate,
            'totalDocuments' => $totalDocuments,
            'storageUsed' => $storageUsedFormatted,
            'userVaultsCount' => $userVaultsCount,
            'totalVaultCapacity' => $totalVaultCapacity,
            'showCapacityWarning' => $showCapacityWarning
        ]);
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}