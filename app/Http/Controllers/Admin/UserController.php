<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{

    /*
     * Mostra tutti gli utenti registrati (clienti e admin)
     */
    public function create(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        if ($request->filled('admin')) {
            $admin = $request->input('admin');
            if ($admin == 'true') {
                $query->where('role', 'admin');
            }
        }

        return Inertia::render('dashboard/Users', [
            'users' => UserResource::collection(
                $query->paginate(10)->withQueryString()
            ),
            'filters' => [
                'search' => $request->input('search'),
                'admin' => $request->input('admin'),
            ],
        ]);
    }

    /*
     * Inserimento account di amministratori
     */
    public function store(StoreAdminRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('utenti');
    }
}
