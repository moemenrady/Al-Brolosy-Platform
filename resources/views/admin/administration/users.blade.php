@extends('layouts.admin')

@section('content')
<style>
    .users-page {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
    }
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .page-title {
        font-size: clamp(1.3rem, 2vw, 1.8rem);
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .table-responsive {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow-x: auto;
    }
    .lux-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        text-align: right;
    }
    .lux-table th {
        background: rgba(228, 220, 199, 0.03);
        color: var(--text-muted);
        padding: 1rem;
        font-weight: 600;
        border-bottom: 1px solid var(--glass-border);
    }
    .lux-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        color: var(--text-main);
        vertical-align: middle;
    }
    .btn-lux {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        white-space: nowrap;
    }
    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
    .role-badge {
        display: inline-block;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .role-admin { background: rgba(180, 0, 0, 0.15); color: #f87171; border: 1px solid rgba(180, 0, 0, 0.3); }
    .role-sales { background: rgba(215, 182, 74, 0.15); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.3); }
    .role-manager { background: rgba(14, 165, 233, 0.15); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.3); }
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gold);
        color: #000;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px); z-index: 9999; display: none;
        align-items: center; justify-content: center; padding: 1rem;
    }
    .modal-card {
        background: var(--bg-card); border: 1px solid var(--glass-border);
        border-radius: 16px; width: 100%; max-width: 550px; padding: 2rem;
    }
    .form-control-lux {
        width: 100%; background: rgba(228, 220, 199, 0.05); border: 1px solid var(--glass-border);
        color: var(--text-main); padding: 0.65rem 0.9rem; border-radius: 8px; font-family: inherit;
        font-size: 0.9rem; outline: none; margin-top: 0.3rem;
    }
    .form-control-lux:focus { border-color: var(--gold); }
</style>

<div class="users-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-users-gear" style="color:var(--gold);"></i>
            <span>إدارة موظفي ومسؤولي المنصة (Staff & Users)</span>
        </div>
        <div>
            <button onclick="openUserModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-user-plus"></i> إضافة مستخدم جديد
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    {{-- جدول المستخدمين --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور / الصلاحية</th>
                    <th>المتابعات المسجلة</th>
                    <th>تاريخ الانضمام</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="user-avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                                <div>
                                    <div style="font-weight:700; color:var(--text-main);">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span style="font-size:0.7rem; color:var(--gold);">(أنت)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $user->role ?? 'staff' }}">
                                @if($user->role == 'admin')
                                    مدير النظام (Admin)
                                @elseif($user->role == 'sales')
                                    مسؤول مبيعات (Sales)
                                @elseif($user->role == 'manager')
                                    مشرف مبيعات (Manager)
                                @else
                                    {{ $user->role ?? 'موظف' }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:700; color:var(--gold);">
                                {{ $user->client_histories_count }} متابعة
                            </span>
                        </td>
                        <td style="color:var(--text-muted); font-size:0.8rem;">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editUserModal({{ $user->toJson() }})" class="btn-lux btn-lux-gold" style="padding:0.35rem 0.65rem; font-size:0.75rem;" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display:inline;" onsubmit="return confirm('حذف هذا المستخدم نهائياً؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-lux btn-lux-primary" style="padding:0.35rem 0.6rem; font-size:0.75rem;" title="حذف">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا يوجد مستخدمون مسجلون.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $users->links() }}
    </div>
</div>

{{-- مودال إضافة وتعديل مستخدم --}}
<div class="modal-overlay" id="userModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:0.8rem; border-bottom:1px solid var(--glass-border);">
            <h3 id="userModalTitle" style="color:var(--text-main); font-weight:700;">إضافة مستخدم جديد</h3>
            <button onclick="closeUserModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">✕</button>
        </div>

        <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div id="userMethodField"></div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">الاسم بالكامل *</label>
                <input type="text" name="name" id="user_name" required placeholder="مثال: أحمد عبد الله" class="form-control-lux">
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">البريد الإلكتروني *</label>
                <input type="email" name="email" id="user_email" required placeholder="user@albrolosy.com" class="form-control-lux">
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">كلمة المرور <span id="passHelp" style="font-size:0.75rem; color:var(--text-muted);">(اتركها فارغة إذا لم ترغب بالتغيير)</span></label>
                <input type="password" name="password" id="user_password" placeholder="••••••••" class="form-control-lux">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">الدور الوظيفي والصلاحيات *</label>
                <select name="role" id="user_role" required class="form-control-lux">
                    <option value="sales">مسؤول مبيعات (Sales)</option>
                    <option value="admin">مدير النظام (Admin كامل الصلاحيات)</option>
                    <option value="manager">مشرف مبيعات (Manager)</option>
                    <option value="staff">موظف عام (Staff)</option>
                </select>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeUserModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ المستخدم</button>
            </div>
        </form>
    </div>
</div>

<script>
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');
    const userMethodField = document.getElementById('userMethodField');
    const passHelp = document.getElementById('passHelp');
    const userPassword = document.getElementById('userPassword');

    function openUserModal() {
        userForm.reset();
        userForm.action = "{{ route('admin.users.store') }}";
        userMethodField.innerHTML = '';
        userModalTitle.innerText = "إضافة مستخدم جديد";
        document.getElementById('user_password').required = true;
        passHelp.style.display = 'none';
        userModal.style.display = 'flex';
    }

    function editUserModal(user) {
        userForm.action = `/admin/users/${user.id}`;
        userMethodField.innerHTML = `@method('PUT')`;
        userModalTitle.innerText = `تعديل المستخدم: ${user.name}`;
        
        document.getElementById('user_name').value = user.name;
        document.getElementById('user_email').value = user.email;
        document.getElementById('user_role').value = user.role || 'sales';
        document.getElementById('user_password').value = '';
        document.getElementById('user_password').required = false;
        passHelp.style.display = 'inline';

        userModal.style.display = 'flex';
    }

    function closeUserModal() {
        userModal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target === userModal) closeUserModal();
    }
</script>
@endsection
