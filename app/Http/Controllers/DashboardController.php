<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $invitations = $user->invitations()->with('invitable')->get();

        return Inertia::render('Dashboard', [
            'invitations' => $invitations,
        ]);
    }
}
