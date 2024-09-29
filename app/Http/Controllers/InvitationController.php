<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Band;
use App\Models\Invitation;
use App\Models\Sheet;
use App\Models\Show;
use App\Notifications\InvitationCreated;
use Notification;

class InvitationController extends Controller
{
    public function store(StoreInvitationRequest $request)
    {
        $entityId = $request->invitable_id;
        $entityType = $request->invitable_type;
        $entity = $entityType::find($entityId);
        $email = $request->email;

        $invitation = Invitation::where('email', $email)->where('invitable_id', $entityId)->first();

        if (!$invitation) {
            $invitation = Invitation::create([
                'email' => $request->email,
                'token' => bin2hex(random_bytes(16)),
                'invitable_id' => $entityId,
                'invitable_type' => $entityType,
            ]);
        }

        // Todo: send mail (again) to the user
        // Each invitable entity should define a mailable that is used for the invitation mail
        // Possible invitables: bands, sheets, shows

        // Users (registred or not registred) can be invited to bands, sheets and sets
        // After accepting an invitation to a band, the user is added to the band
        // After accepting an invitation for a sheet or a show, access is granted for the respective resource

        // If access is granted to a band, a sheet or a show, but there is no existing user
        Notification::route('mail', $invitation->email)
            ->notify((new InvitationCreated($invitation))->locale('de'));

        return redirect()->back()->with('success', true);
    }

    public function acceptInvitation(Invitation $invitation)
    {
        match ($invitation->invitable_type) {
            Band::class => $this->addToBand($invitation->invitable_id),
            Sheet::class => $this->addToSheet($invitation->invitable_id),
            Show::class => $this->addToShow($invitation->invitable_id),
        };
    }

    public function destroy(Invitation $invitation)
    {
        $invitation->delete();
        return redirect()->back()->with('success', true);
    }

    private function addToBand(string $email)
    {

    }
}
