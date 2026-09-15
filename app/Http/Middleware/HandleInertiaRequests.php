<?php

namespace App\Http\Middleware;

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
        return [
            ...parent::share($request),

            'auth' => [
                'user' => $request->user()
                    ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'roles' => $request->user()
                            ->roles()
                            ->pluck('slug')
                            ->values(),
                        'permissions' => [
                            'employee.view' => $request->user()->hasPermission('employee.view'),
                            'employee.create' => $request->user()->hasPermission('employee.create'),
                            'employee.update' => $request->user()->hasPermission('employee.update'),
                            'employee.delete' => $request->user()->hasPermission('employee.delete'),

                            'department.view' => $request->user()->hasPermission('department.view'),
                            'department.create' => $request->user()->hasPermission('department.create'),
                            'department.update' => $request->user()->hasPermission('department.update'),
                            'department.delete' => $request->user()->hasPermission('department.delete'),

                            'position.view' => $request->user()->hasPermission('position.view'),
                            'position.create' => $request->user()->hasPermission('position.create'),
                            'position.update' => $request->user()->hasPermission('position.update'),
                            'position.delete' => $request->user()->hasPermission('position.delete'),
                        ],
                    ]
                    : null,
            ],

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}