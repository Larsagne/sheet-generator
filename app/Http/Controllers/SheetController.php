<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Cpdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $sheets = $user->sheets()->without('parts')->get();

        return Inertia::render('Sheet/List', [
            'sheets' => $sheets
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Sheet/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sheet $sheet)
    {
        $pdf = Pdf::loadView('sheet', [
            'sheet' => $sheet
        ]);


        return $pdf->stream($sheet->title . ' - ' . $sheet->artist . ' Sheet.pdf');
    }

    public function edit(Sheet $sheet): \Inertia\Response
    {
        return Inertia::render('Sheet/Edit', [
            'sheet' => $sheet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sheet $sheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sheet $sheet)
    {
        //
    }
}
