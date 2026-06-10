<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'wa'       => 'nullable|string|max:20',
            'bio'      => 'nullable|string',
            'role'     => 'required|in:administrator,editor,penulis,viewer',
            'status'   => 'required|in:aktif,non-aktif,suspended',
            'avatar_color' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.']);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => "required|string|max:50|unique:users,username,{$user->id}",
            'email'    => "required|email|unique:users,email,{$user->id}",
            'wa'       => 'nullable|string|max:20',
            'bio'      => 'nullable|string',
            'role'     => 'required|in:administrator,editor,penulis,viewer',
            'status'   => 'required|in:aktif,non-aktif,suspended',
            'avatar_color' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui.']);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus akun sendiri.'], 422);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa mengubah status akun sendiri.'], 422);
        }
        $user->update(['status' => $user->status === 'aktif' ? 'non-aktif' : 'aktif']);
        return response()->json(['success' => true, 'status' => $user->status]);
    }
}
