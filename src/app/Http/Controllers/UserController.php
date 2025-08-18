<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role')->where('id', '<>', Auth::id());

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->filled('role_name')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->role_name . '%');
            });
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'role_id'               => 'required|exists:roles,id',
            'address'               => 'nullable|string|max:255',
            'phone'                 => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
            'role_id'        => $validated['role_id'],
            'address'        => $validated['address'] ?? null,
            'phone'          => $validated['phone'] ?? null,
            'remember_token' => Str::random(60),
        ]);

        flash()->success(__('messages.created_successfully', [
            'resource' => ucfirst(__('users.singular'))
        ]));

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'              => 'nullable|string|min:8|confirmed',
            'role_id'               => 'required|exists:roles,id',
            'address'               => 'nullable|string|max:255',
            'phone'                 => 'nullable|string|max:20',
        ]);

        $data = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role_id' => $validated['role_id'],
            'address' => $validated['address'] ?? null,
            'phone'   => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        flash()->success(__('messages.updated_successfully', [
            'resource' => ucfirst(__('users.singular'))
        ]));

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        flash()->success(__('messages.deleted_successfully', [
            'resource' => __('users.singular')
        ]));

        return redirect()->route('admin.users.index');
    }
}
