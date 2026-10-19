@extends('layouts.app')

@section('content')
<style>
    .page-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.07);
        border: 1px solid #edf2f7;
        margin-top: 20px;
    }

    .filter-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: end;
        margin-top: 16px;
    }

    .filter-group {
        display: grid;
        gap: 6px;
    }

    .filter-group label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .filter-group input {
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 12px;
        padding: 11px 13px;
        font-size: 14px;
        outline: none;
        min-width: 240px;
    }

    .btn-primary-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-neutral-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        text-decoration: none;
    }

    .alert-box {
        margin-top: 16px;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 14px;
        line-height: 1.7;
    }

    .alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .table-wrap {
        overflow-x: auto;
        margin-top: 18px;
    }

    .user-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .user-table thead th {
        background: #f8fafc;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .user-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #111827;
        text-align: center;
    }

    .user-table tbody tr:hover {
        background: #fbfdff;
    }

    .status-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-aktif {
        background: #dcfce7;
        color: #166534;
    }

    .status-nonaktif {
        background: #fee2e2;
        color: #991b1b;
    }

    .reset-form {
        display: grid;
        gap: 8px;
    }

    .reset-form input {
        width: 100%;
        min-width: 180px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 10px 12px;
    }

    .table-footer {
        margin-top: 18px;
        display: flex;
        justify-content: flex-end;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        width: 100%;
        min-width: 180px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 10px 42px 10px 12px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .toggle-password:hover {
        background: #f3f4f6;
        color: #2563eb;
    }

    .toggle-password svg {
        width: 18px;
        height: 18px;
    }
</style>

<div class="page-card">
    <span class="badge">Hak Akses: Admin</span>
    <h1 class="page-title">Reset Password User</h1>
    <p class="text-muted">
        Gunakan halaman ini untuk membantu user yang lupa password.
    </p>

    @if(session('success'))
        <div class="alert-box alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-box alert-error">
            <strong style="display:block; margin-bottom:8px;">Terdapat kesalahan:</strong>
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.user.reset.index') }}" class="filter-form">
        <div class="filter-group">
            <label for="keyword">Cari User</label>
            <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" placeholder="Username atau nama user">
        </div>

        <button type="submit" class="btn-primary-soft">Cari</button>
        <a href="{{ route('admin.user.reset.index') }}" class="btn-neutral-soft">Reset</a>
    </form>

    <div class="table-wrap">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Reset Password</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    @php
                        $nama = match($user->role) {
                            'admin' => $user->admin->nama_admin ?? '-',
                            'supir' => $user->supir->nama_supir ?? '-',
                            'petinggi' => $user->petinggi->nama_petinggi ?? '-',
                            default => '-',
                        };
                    @endphp
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $nama }}</td>
                        <td>
                            <span class="status-badge status-{{ $user->status_aktif }}">
                                {{ ucfirst($user->status_aktif) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.user.reset.password', $user->user_id) }}" class="reset-form">
                                @csrf
                                @method('PUT')
                                <div class="password-wrapper">
                                    <input type="password" name="password_baru" id="password_baru_{{ $user->user_id }}" placeholder="Password baru" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru_{{ $user->user_id }}', this)" title="Lihat Password">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="password-wrapper">
                                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation_{{ $user->user_id }}" placeholder="Konfirmasi password" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru_confirmation_{{ $user->user_id }}', this)" title="Lihat Password">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>                                
                                <button type="submit" class="btn-primary-soft">Reset</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        {{ $users->links() }}
    </div>
</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            button.title = 'Sembunyikan Password';
        } else {
            input.type = 'password';
            button.title = 'Lihat Password';
        }
    }
</script>
@endsection