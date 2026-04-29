@extends('layouts.app')

@section('content')
<style>
    body { background: #0a0b14 !important; font-family: 'Inter', sans-serif; }
    .min-h-screen { background: #0a0b14 !important; }

    :root {
        --primary: #06b6d4;
        --primary-light: #22d3ee;
        --accent2: #6366f1;
        --accent: #a855f7;
        --bg: #0a0b14;
        --glass-border: rgba(255,255,255,0.1);
        --text: #f1f5f9;
        --muted: #94a3b8;
    }

    .login-page {
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem; position: relative; overflow: hidden;
        background: var(--bg);
    }

    .orb { position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.3; animation: drift 12s ease-in-out infinite alternate; z-index: 0; pointer-events: none; }
    .orb1 { width: 380px; height: 380px; background: var(--primary); top: -100px; right: -80px; }
    .orb2 { width: 300px; height: 300px; background: var(--accent2); bottom: -80px; left: -60px; animation-delay: -5s; }
    .orb3 { width: 200px; height: 200px; background: var(--accent); top: 40%; left: 20%; animation-delay: -9s; }
    @keyframes drift { from { transform: translateY(0) scale(1); } to { transform: translateY(28px) scale(1.07); } }

    .login-page::before {
        content: '';
        position: fixed; inset: 0; z-index: 0;
        background:
            radial-gradient(ellipse 70% 55% at 85% 10%, rgba(6,182,212,0.2) 0%, transparent 60%),
            radial-gradient(ellipse 55% 45% at 15% 85%, rgba(99,102,241,0.18) 0%, transparent 60%);
    }

    .login-container {
        position: relative; z-index: 1;
        width: 100%; max-width: 440px;
        animation: fadeUp .6s ease both;
    }
    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        color: var(--muted); font-size: .85rem; text-decoration: none;
        margin-bottom: 2rem; transition: color .2s;
    }
    .back-link:hover { color: var(--text); }

    .login-header { text-align: center; margin-bottom: 2rem; }
    .login-icon {
        width: 68px; height: 68px; border-radius: 20px; margin: 0 auto 1.2rem;
        background: linear-gradient(135deg, var(--primary), var(--accent2));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 8px 32px rgba(6,182,212,0.35);
    }
    .login-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text); letter-spacing: -0.5px; margin-bottom: .4rem; }
    .login-header p { color: var(--muted); font-size: .92rem; }

    .login-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px; padding: 2.25rem;
        box-shadow: 0 24px 64px rgba(0,0,0,0.4);
    }

    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block; font-size: .82rem; font-weight: 600;
        color: var(--muted); margin-bottom: .5rem;
        text-transform: uppercase; letter-spacing: .05em;
    }
    .input-wrap { position: relative; }
    .input-icon {
        position: absolute; top: 50%; left: 1rem; transform: translateY(-50%);
        color: var(--muted); font-size: 1rem; pointer-events: none;
    }
    .form-input {
        width: 100%; padding: .85rem 1rem .85rem 2.75rem;
        background: rgba(255,255,255,0.06); border: 1px solid var(--glass-border);
        border-radius: 10px; color: var(--text); font-size: .95rem;
        outline: none; transition: border-color .2s, box-shadow .2s;
        font-family: 'Inter', sans-serif;
    }
    .form-input::placeholder { color: rgba(148,163,184,0.5); }
    .form-input:focus { border-color: var(--primary-light); box-shadow: 0 0 0 3px rgba(6,182,212,0.15); }

    .field-error { color: #f87171; font-size: .8rem; margin-top: .4rem; display: flex; align-items: center; gap: .3rem; }
    .alert-error {
        background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
        border-radius: 10px; padding: .9rem 1rem; margin-top: 1rem;
        color: #fca5a5; font-size: .87rem; display: flex; align-items: center; gap: .5rem;
    }
    .alert-success {
        background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25);
        border-radius: 10px; padding: .9rem 1rem; margin-top: 1rem;
        color: #6ee7b7; font-size: .87rem; display: flex; align-items: center; gap: .5rem;
    }

    .btn-submit {
        width: 100%; padding: .9rem; border-radius: 10px; border: none; cursor: pointer;
        background: linear-gradient(135deg, var(--primary), var(--accent2));
        color: white; font-size: .95rem; font-weight: 700;
        letter-spacing: .02em; margin-top: .5rem;
        transition: opacity .2s, transform .2s, box-shadow .2s;
        box-shadow: 0 4px 20px rgba(6,182,212,0.3);
        font-family: 'Inter', sans-serif;
    }
    .btn-submit:hover { opacity: .88; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(6,182,212,0.4); }
    .btn-submit:active { transform: translateY(0); }

    .card-footer { text-align: center; margin-top: 1.5rem; color: var(--muted); font-size: .85rem; }
    .card-footer a { color: var(--primary-light); font-weight: 600; text-decoration: none; }
    .card-footer a:hover { color: white; }

    .security-badge {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        margin-top: 1.75rem; color: var(--muted); font-size: .78rem;
    }
    .security-badge span { color: #34d399; font-size: .9rem; }
</style>

<div class="login-page">
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>

    <div class="login-container">
        <a href="{{ url('/') }}" class="back-link">← Back to Home</a>

        <div class="login-header">
            <div class="login-icon">👤</div>
            <h1>Employee Portal</h1>
            <p>Sign in to access your HR dashboard</p>
        </div>

        <div class="login-card">
            <form method="POST" action="{{ route('employee.login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Work Email</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input
                            id="email" type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your work email"
                            required autofocus autocomplete="email"
                            class="form-input">
                    </div>
                    @error('email')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input
                            id="password" type="password" name="password"
                            placeholder="Enter your password"
                            required autocomplete="current-password"
                            class="form-input">
                    </div>
                    @error('password')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">Sign In to My Portal</button>

                <!-- Messages -->
                @if(session('error'))
                    <div class="alert-error">⚠ {{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert-success">✓ {{ session('success') }}</div>
                @endif

                @error('ip')
                    <div class="alert-error">⚠ {{ $message }}</div>
                @enderror
            </form>

            <div class="card-footer">
                Administrator? <a href="{{ route('admin.login') }}">Admin Login</a>
            </div>
        </div>

        <div class="security-badge">
            <span>🔐</span> Secure employee access · OHA-HRMS
        </div>
    </div>
</div>
@endsection