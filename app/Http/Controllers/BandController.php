<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandRequest;
use App\Models\Band;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BandController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Band::class);
    }

    public function store(StoreBandRequest $request): RedirectResponse
    {
        $bandData = $request->validated();

        $band = Band::make($bandData);
        $band->founder_id = auth()->id();
        $band->save();

        return to_route('bands.edit', ['band' => $band]);
    }

    public function edit(Band $band): Response
    {
        return Inertia::render('Band/Edit', [
            'band' => $band->load(['members', 'invitations'])
        ]);
    }

    public function update(StoreBandRequest $request, Band $band): RedirectResponse
    {
        $newBand = $request->validated();
        $band->update($newBand);

        return to_route('bands.edit', ['band' => $band]);
    }

    public function destroy(Band $band)
    {
        $band->delete();
        return to_route('bands.index');
    }

    public function removeMember(Band $band, string $memberId): RedirectResponse
    {
        $band->members()->detach($memberId);
        return to_route('bands.edit', ['band' => $band]);
    }
}
