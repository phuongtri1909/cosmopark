<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SMTPSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $adminEmail = $this->getAdminEmail();
        
        return view('admin.pages.accounts.index', compact('users', 'adminEmail'));
    }

    public function create()
    {
        $adminEmail = $this->getAdminEmail();
        return view('admin.pages.accounts.create', compact('adminEmail'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'user';
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản đã được tạo thành công.');
    }

    public function edit(User $account)
    {
        $adminEmail = $this->getAdminEmail();
        $currentUser = auth()->user();
        
        if (!$this->canEditUser($currentUser, $account, $adminEmail)) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa tài khoản này.');
        }

        return view('admin.pages.accounts.edit', compact('account', 'adminEmail'));
    }

    public function update(Request $request, User $account)
    {
        $currentUser = auth()->user();
        $adminEmail = $this->getAdminEmail();
        
        if (!$this->canEditUser($currentUser, $account, $adminEmail)) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa tài khoản này.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $account->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('avatar')) {
            if ($account->avatar) {
                Storage::disk('public')->delete($account->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $account->update($data);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản đã được cập nhật thành công.');
    }

    public function destroy(User $account)
    {
        $currentUser = auth()->user();
        $adminEmail = $this->getAdminEmail();
        
        if (!$this->canDeleteUser($currentUser, $account, $adminEmail)) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không có quyền xóa tài khoản này.');
        }

        if ($account->id === $currentUser->id) {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Bạn không thể xóa chính tài khoản của mình.');
        }

        if ($account->avatar) {
            Storage::disk('public')->delete($account->avatar);
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Tài khoản đã được xóa thành công.');
    }

    private function getAdminEmail()
    {
        $smtpSetting = SMTPSetting::first();
        return $smtpSetting ? $smtpSetting->admin_email : null;
    }

    private function canEditUser($currentUser, $targetUser, $adminEmail)
    {
        if ($currentUser->email === $adminEmail) {
            return true;
        }
        
        return $targetUser->email !== $adminEmail;
    }

    private function canDeleteUser($currentUser, $targetUser, $adminEmail)
    {
        if ($currentUser->email === $adminEmail) {
            return true;
        }
        
        return $targetUser->email !== $adminEmail;
    }
}
