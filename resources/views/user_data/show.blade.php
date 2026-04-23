@extends('layouts.dashboard-layout')

@section('container')

<div class="erp-page">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Menu User Data</li>
                </ol>
            </nav>

    @if (session('success'))
        <div class="erp-alert erp-alert-success">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            {!! session('success') !!}
            <button class="erp-alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @elseif (session('editSuccess'))
        <div class="erp-alert erp-alert-warning">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M8 2L14 13H2L8 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 7v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="8" cy="11.5" r="0.5" fill="currentColor"/></svg>
            {!! session('editSuccess') !!}
            <button class="erp-alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @elseif (session('delete'))
        <div class="erp-alert erp-alert-danger">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 5.5l5 5M10.5 5.5l-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            Data telah dihapus
            <button class="erp-alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif
    <div class="erp-page-header">
        <div>
            <h1 class="erp-page-title">Detail Users</h1>
            <p class="erp-page-subtitle">Account Information & System Access</p>
        </div>
        <div class="erp-action-bar">
            <a href="{{ route('userData.index') }}" class="erp-btn">Back </a>
            <a href="{{ route('userData.edit-user', $data_user->id) }}" class="erp-btn erp-btn-primary">Edit data</a>
        </div>
    </div>

    <div class="erp-layout">
        <div class="erp-col-left">
            <div class="erp-card erp-avatar-card">
                <div class="erp-avatar">
                    @if ($data_user->image)
                        <img src="{{ asset('storage/user_images/' . $data_user->image) }}" alt="{{ $data_user->username }}">
                    @else
                        {{ strtoupper(substr($data_user->username, 0, 2)) }}
                    @endif
                </div>
                <div class="erp-avatar-name">{{ $data_user->username }}</div>
                <div class="erp-avatar-role">{{ $data_user->posisi ?? '-' }}</div>
                <span class="erp-badge erp-badge-success">
                    <span class="erp-dot"></span> Active
                </span>
                <div class="erp-divider"></div>
                <div class="erp-meta-item">
                    <span class="erp-meta-label">User ID</span>
                    <span class="erp-meta-value erp-mono">#{{ str_pad($data_user->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="erp-meta-item">
                    <span class="erp-meta-label">Joined</span>
                    <span class="erp-meta-value">{{ $data_user->created_at->format('d M Y') }}</span>
                </div>
                <div class="erp-meta-item" style="margin-bottom:0">
                    <span class="erp-meta-label">Updated Latest</span>
                    <span class="erp-meta-value">{{ $data_user->updated_at->format('d M Y') }}</span>
                </div>
            </div>

            {{-- <div class="erp-card">
                <div class="erp-section-title">Akses modul</div>
                <div class="erp-tag-row">
                    @php
                        $moduleMap = [
                            'admin'     => ['Dashboard', 'User Mgmt', 'Inventory', 'Laporan', 'Proyek', 'Material'],
                            'manager'   => ['Dashboard', 'Inventory', 'Laporan', 'Proyek'],
                            'operator'  => ['Dashboard', 'Inventory'],
                        ];
                        $role = strtolower($data_user->role ?? 'operator');
                        $modules = $moduleMap[$role] ?? ['Dashboard'];
                    @endphp
                    @foreach ($modules as $module)
                        <span class="erp-tag">{{ $module }}</span>
                    @endforeach
                </div>
            </div> --}}

        </div>
        <div class="erp-col-right">
            <div class="erp-card">
                <div class="erp-section-title">Information Account</div>
                <div class="erp-info-grid">
                    <div class="erp-field">
                        <span class="erp-field-label">Full Name</span>
                        <span class="erp-field-value">{{ $data_user->username }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">Email</span>
                        <span class="erp-field-value erp-mono">{{ $data_user->email }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">Role</span>
                        <span class="erp-field-value">
                            @php
                                $roleBadge = match(strtolower($data_user->role ?? '')) {
                                    'admin'    => 'erp-badge-info',
                                    'manager'  => 'erp-badge-warning',
                                    'operator' => 'erp-badge-neutral',
                                    default    => 'erp-badge-neutral',
                                };
                            @endphp
                            <span class="erp-badge {{ $roleBadge }}">{{ ucfirst($data_user->role ?? '-') }}</span>
                        </span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">Position</span>
                        <span class="erp-field-value">{{ $data_user->posisi ?? '-' }}</span>
                    </div>
                    <div class="erp-field" style="border-bottom:none">
                        <span class="erp-field-label">Date Joined</span>
                        <span class="erp-field-value">{{ $data_user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="erp-field" style="border-bottom:none">
                        <span class="erp-field-label">Account Status</span>
                        <span class="erp-field-value">
                            <span class="erp-badge erp-badge-success">Active</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="erp-card">
                <div class="erp-section-title">Security &amp; Session</div>
                <div class="erp-info-grid">
                    <div class="erp-field" style="border-bottom:none">
                        <span class="erp-field-label">Password</span>
                        <span class="erp-field-value erp-mono" style="letter-spacing:3px; color: var(--erp-text-muted)">••••••••</span>
                    </div>
                    <div class="erp-field" style="border-bottom:none">
                        <span class="erp-field-label">Updated Latest</span>
                        <span class="erp-field-value">{{ $data_user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ─── Variables ─────────────────────────────── */
    :root {
        --erp-border: rgba(0,0,0,0.09);
        --erp-border-md: rgba(0,0,0,0.14);
        --erp-bg: #ffffff;
        --erp-bg-surface: #f8f8f7;
        --erp-bg-info: #e6f1fb;
        --erp-bg-success: #eaf3de;
        --erp-bg-warning: #faeeda;
        --erp-bg-danger: #fcebeb;
        --erp-bg-neutral: #f1efe8;
        --erp-text: #1a1a19;
        --erp-text-muted: #6b6b68;
        --erp-text-hint: #9b9b98;
        --erp-text-info: #185fa5;
        --erp-text-success: #3b6d11;
        --erp-text-warning: #854f0b;
        --erp-text-danger: #a32d2d;
        --erp-radius: 8px;
        --erp-radius-lg: 12px;
    }

    /* ─── Page ───────────────────────────────────── */
    .erp-page {
        padding: 1.5rem 0 2.5rem;
        font-family: inherit;
    }

    /* ─── Breadcrumb ──────────────────────────────── */
    .erp-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--erp-text-muted);
        margin-bottom: 1.25rem;
    }
    .erp-breadcrumb a {
        color: var(--erp-text-muted);
        text-decoration: none;
    }
    .erp-breadcrumb a:hover { color: var(--erp-text); }
    .erp-breadcrumb .sep { color: var(--erp-border-md); }

    /* ─── Alerts ─────────────────────────────────── */
    .erp-alert {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        padding: 10px 14px;
        border-radius: var(--erp-radius);
        margin-bottom: 1.25rem;
        position: relative;
        border: 0.5px solid transparent;
    }
    .erp-alert-success { background: var(--erp-bg-success); color: var(--erp-text-success); border-color: #c0dd97; }
    .erp-alert-warning { background: var(--erp-bg-warning); color: var(--erp-text-warning); border-color: #fac775; }
    .erp-alert-danger  { background: var(--erp-bg-danger);  color: var(--erp-text-danger);  border-color: #f7c1c1; }
    .erp-alert-close {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        color: inherit;
        opacity: 0.6;
        padding: 0;
    }
    .erp-alert-close:hover { opacity: 1; }

    /* ─── Page Header ─────────────────────────────── */
    .erp-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .erp-page-title {
        font-size: 15px;
        font-weight: 500;
        color: var(--erp-text);
        margin: 0;
    }
    .erp-page-subtitle {
        font-size: 12px;
        color: var(--erp-text-muted);
        margin: 3px 0 0;
    }

    /* ─── Buttons ─────────────────────────────────── */
    .erp-action-bar { display: flex; gap: 8px; }
    .erp-btn {
        font-size: 12px;
        padding: 6px 16px;
        border-radius: var(--erp-radius);
        border: 0.5px solid var(--erp-border-md);
        background: transparent;
        color: var(--erp-text);
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.15s;
    }
    .erp-btn:hover { background: var(--erp-bg-surface); color: var(--erp-text); }
    .erp-btn-primary {
        background: var(--erp-bg-info);
        color: var(--erp-text-info);
        border-color: transparent;
        font-weight: 500;
    }
    .erp-btn-primary:hover { opacity: 0.85; color: var(--erp-text-info); }

    /* ─── Layout ──────────────────────────────────── */
    .erp-layout {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        gap: 16px;
        align-items: start;
    }
    .erp-col-left, .erp-col-right {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* ─── Card ────────────────────────────────────── */
    .erp-card {
        background: var(--erp-bg);
        border: 0.5px solid var(--erp-border);
        border-radius: var(--erp-radius-lg);
        padding: 1.1rem 1.25rem;
    }

    /* ─── Avatar ─────────────────────────────────── */
    .erp-avatar-card { text-align: center; }
    .erp-avatar {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: var(--erp-bg-info);
        color: var(--erp-text-info);
        font-size: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border: 0.5px solid var(--erp-border);
        overflow: hidden;
    }
    .erp-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .erp-avatar-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--erp-text);
    }
    .erp-avatar-role {
        font-size: 11px;
        color: var(--erp-text-muted);
        margin-top: 2px;
    }

    /* ─── Badges ─────────────────────────────────── */
    .erp-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        padding: 3px 9px;
        border-radius: var(--erp-radius);
        margin-top: 8px;
        font-weight: 400;
    }
    .erp-badge-success { background: var(--erp-bg-success); color: var(--erp-text-success); }
    .erp-badge-info    { background: var(--erp-bg-info);    color: var(--erp-text-info); }
    .erp-badge-warning { background: var(--erp-bg-warning); color: var(--erp-text-warning); }
    .erp-badge-danger  { background: var(--erp-bg-danger);  color: var(--erp-text-danger); }
    .erp-badge-neutral { background: var(--erp-bg-neutral); color: var(--erp-text-muted); }
    .erp-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--erp-text-success);
        display: inline-block;
    }

    /* ─── Divider ─────────────────────────────────── */
    .erp-divider {
        height: 0.5px;
        background: var(--erp-border);
        margin: 12px 0;
    }

    /* ─── Meta (left card list) ───────────────────── */
    .erp-meta-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin-bottom: 9px;
        text-align: left;
    }
    .erp-meta-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--erp-text-hint);
    }
    .erp-meta-value {
        font-size: 12px;
        color: var(--erp-text-muted);
    }

    /* ─── Section Title ───────────────────────────── */
    .erp-section-title {
        font-size: 10px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--erp-text-hint);
        margin-bottom: 14px;
    }

    /* ─── Info Grid ───────────────────────────────── */
    .erp-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 24px;
    }
    .erp-field {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 10px 0;
        border-bottom: 0.5px solid var(--erp-border);
    }
    .erp-field-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--erp-text-hint);
    }
    .erp-field-value {
        font-size: 13px;
        color: var(--erp-text);
    }

    /* ─── Mono ───────────────────────────────────── */
    .erp-mono {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 11.5px !important;
        color: var(--erp-text-muted) !important;
    }

    /* ─── Tags ───────────────────────────────────── */
    .erp-tag-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .erp-tag {
        font-size: 11px;
        padding: 3px 9px;
        border-radius: var(--erp-radius);
        background: var(--erp-bg-surface);
        color: var(--erp-text-muted);
        border: 0.5px solid var(--erp-border);
    }

    /* ─── Responsive ─────────────────────────────── */
    @media (max-width: 768px) {
        .erp-layout {
            grid-template-columns: 1fr;
        }
        .erp-page-header {
            flex-direction: column;
            gap: 12px;
        }
        .erp-info-grid {
            grid-template-columns: 1fr;
        }
        .erp-field {
            border-bottom: 0.5px solid var(--erp-border) !important;
        }
    }
</style>
@endpush
@push('scripts')
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                console.log('Preloader found. It will hide after 3 seconds...');
                setTimeout(function() {
                    preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                    console.log('Preloader hidden.');
                }, 1500); // Durasi 3000 ms = 3 detik
            } else {
                console.error('Preloader element not found!');
            }
        });
    </script>
@endpush
