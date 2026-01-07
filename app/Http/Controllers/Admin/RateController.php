<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RateController extends Controller
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function index(): View
    {
        $rates = Rate::latest()->paginate(10);
        $currentRate = Rate::latest()->first();

        return view('admin.rates.index', compact('rates', 'currentRate'));
    }

    public function edit(Rate $rate): View
    {
        return view('admin.rates.edit', compact('rate'));
    }

    public function update(Request $request, Rate $rate): RedirectResponse
    {
        $validated = $request->validate([
            'rate' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $rate->update($validated);

        $this->auditService->log('rate.updated', [
            'rate_id' => $rate->id,
            'old_rate' => $rate->getOriginal('rate'),
            'new_rate' => $rate->rate,
        ]);

        return redirect()->route('admin.rates.index')
            ->with('success', 'Rate updated successfully.');
    }
} 