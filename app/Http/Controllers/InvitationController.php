<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Band;
use App\Models\Invitation;
use App\Models\Sheet;
use App\Models\Show;
use App\Notifications\InvitationCreated;
use Illuminate\Http\RedirectResponse;
use Notification;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Invitation::class);
    }

    public function store(StoreInvitationRequest $request): RedirectResponse
    {
        $entityId = $request->invitable_id;
        $entityType = $request->invitable_type;
        $email = $request->email;

        $invitation = Invitation::where('email', $email)->where('invitable_id', $entityId)->first();

        if (!$invitation) {
            $invitation = Invitation::create([
                'email' => $request->email,
                'token' => bin2hex(random_bytes(16)),
                'invitable_id' => $entityId,
                'invitable_type' => $entityType,
                'invited_by' => auth()->id()
            ]);
        }

        Notification::route('mail', $invitation->email)
            ->notify((new InvitationCreated($invitation))->locale('de'));

        return back()->with('success', true);
    }

    public function acceptInvitation(Invitation $invitation)
    {
        $this->authorize('accept');

        match ($invitation->invitable_type) {
            Band::class => $this->addToBand(Band::find($invitation->invitable_id)),
            Sheet::class => $this->addToSheet($invitation->invitable_id),
            Show::class => $this->addToShow($invitation->invitable_id),
        };
    }

    public function destroy(Invitation $invitation)
    {
        $invitation->delete();
        return back()->with('success', true);
    }

    private function addToBand(Band $band)
    {
        dd($band->toArray());
    }
}
