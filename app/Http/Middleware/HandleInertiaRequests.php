<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $email = $request->session()->get('email');
        $id = $request->session()->get('id');

        $user = User::where('email', $email)
            ->where('id', $id)
            ->select('is_logged_in')
            ->first();

        return array_merge(parent::share($request), [
            'flash' => [
                'message' => fn () => $request->session()->pull('message'),
                'status' => fn () => $request->session()->pull('status'),
                'error' => fn () => $request->session()->pull('error'),
            ],
            'is_logged_in' => $user->is_logged_in ?? false,
        ]);
    }
}
