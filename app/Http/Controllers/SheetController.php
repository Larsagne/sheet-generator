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
        dd($request->validated());
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
        $this->authorize('pdf');

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
    public function update(Request $request, Sheet $sheet): RedirectResponse
    {
        $newSheet = $request->get('sheet');

        // set base attributes
        $sheet->update($newSheet);

        // remove, add, update and rearrange parts
        $this->setParts($newSheet['parts'], $sheet);

        return to_route('sheets.index');
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
        //
    }

    private function setParts(array $parts, Sheet $sheet): void
    {
        $parts = $this->sort($parts);

        $partIds = array_map(fn($part) => $this->handlePart($part, $sheet), $parts);
        $oldParts = $sheet->parts()->whereNotIn('id', $partIds);
        Part::destroy($oldParts->pluck('id'));
    }

    private function handlePart(array $part, Sheet $sheet): string
    {
        if (isset($part['id'])) {
            $partModel = Part::find($part['id']);
            $partModel->update($part);
        } else {
            $partModel = $sheet->parts()->create($part);
        }

        $this->setSequences($part['sequences'], $partModel);

        return $partModel->id;
    }

    private function setSequences(array $sequences, Part $part): void
    {
        $sequences = $this->sort($sequences);

        $sequenceIds = array_map(fn($sequence) => $this->handleSequence($sequence, $part), $sequences);
        $oldSequences = $part->sequences()->whereNotIn('id', $sequenceIds);
        Sequence::destroy($oldSequences->pluck('id'));
    }


    private function handleSequence(array $sequence, Part $part): string
    {
        if (isset($sequence['id'])) {
            $sequenceModel = Sequence::find($sequence['id']);
            $sequenceModel->update($sequence);
        } else {
            $sequenceModel = $part->sequences()->create($sequence);
        }

        return $sequenceModel->id;
    }

    /**
     * This method is used to set the position attributes of parts and sequences
     */
    private function sort(array $entities): array
    {
        $sortedEntities = [];
        foreach ($entities as $position => $entity) {
            $entity['position'] = $position;
            $sortedEntities[] = $entity;
        }

        return $sortedEntities;
    }
}
