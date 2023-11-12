<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSheetRequest;
use App\Models\Part;
use App\Models\Sequence;
use App\Models\Sheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $sheets = $user->sheets()->without('parts')->get();

        return Inertia::render('Sheet/List', [
            'sheets' => $sheets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSheetRequest $request)
    {
        $sheetData = $request->validated();

        $sheet = Sheet::make($sheetData);
        $sheet->user_id=auth()->id();
        $sheet->save();

        return to_route('sheets.edit', ['sheet' => $sheet]);
    }

    /**
     * Display the specified resource.
     */
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
