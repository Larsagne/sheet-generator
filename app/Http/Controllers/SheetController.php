<?php

namespace App\Http\Controllers;

use App\Events\SheetUpdated;
use App\Http\Requests\StoreSheetRequest;
use App\Models\Band;
use App\Models\Sheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class SheetController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Sheet::class);
    }

    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $userId = $user->id;
        $bands = $user->bands()->get();

        $sheets = Sheet::where('user_id', $userId)
            ->orWhereIn('id', function ($query) use ($userId) {
                $query->select('resourceable_id')
                    ->from('accesses')
                    ->where('resourceable_type', Sheet::class)
                    ->where('accessable_type', User::class)
                    ->where('accessable_id', $userId);
            })
            ->orWhereIn('id', function ($query) use ($userId) {
                $query->select('resourceable_id')
                    ->from('accesses')
                    ->where('resourceable_type', Sheet::class)
                    ->where('accessable_type', Band::class)
                    ->whereIn('accessable_id', function ($subquery) use ($userId) {
                        $subquery->select('band_id')
                            ->from('band_member')
                            ->where('member_id', $userId);
                    });
            })
            ->orderBy('title')
            ->get();

        return Inertia::render('Sheet/List', [
            'sheets' => $sheets,
            'bands' => $bands
        ]);
    }

    public function store(StoreSheetRequest $request)
    {
        $sheetData = $request->validated();

        $sheet = Sheet::make($sheetData);
        $sheet->user_id=auth()->id();
        $sheet->save();

        return to_route('sheets.edit', ['sheet' => $sheet]);
    }

    public function show(Sheet $sheet): Response
    {
        return Inertia::render('Sheet/Show', [
            'sheet' => $sheet
        ]);
    }

    public function pdf(Sheet $sheet): HttpResponse
    {
//        $this->authorize('pdf');

        $pdf = Pdf::loadView('sheet', [
            'sheet' => $sheet
        ]);

        return $pdf->stream($sheet->title . ' - ' . $sheet->artist . ' Sheet.pdf');
    }

    public function edit(Sheet $sheet): Response
    {
        return Inertia::render('Sheet/Edit', [
            'sheet' => $sheet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSheetRequest $request, Sheet $sheet): RedirectResponse
    {
        $newSheet = $request->validated();
        $sheet->update($newSheet);

//        SheetUpdated::dispatch($sheet);

        return to_route('sheets.edit', ['sheet' => $sheet]);
    }

    public function playback(Sheet $sheet): Response
    {
        $this->authorize('playback');

        return Inertia::render('Sheet/Playback', [
            'sheet' => $sheet
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sheet $sheet)
    {
        $sheet->delete();
        return to_route('sheets.index');
    }
}
