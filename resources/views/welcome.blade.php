<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OHA-HRMS — Human Resource Management System</title>
    <meta name="description" content="OHA-HRMS: A powerful, modern Human Resources Management System for streamlined workforce operations.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --accent: #06b6d4;
            --accent2: #a855f7;
            --bg: #0a0b14;
            --bg2: #0f1023;
            --glass: rgba(255,255,255,0.05);
            --glass-border: rgba(255,255,255,0.1);
            --text: #f1f5f9;
            --muted: #94a3b8;
            --card-bg: rgba(255,255,255,0.04);
        }

        html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); overflow-x: hidden; }

        /* ── Background ── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(99,102,241,0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(168,85,247,0.2) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(6,182,212,0.1) 0%, transparent 60%);
        }

        /* ── Orbs ── */
        .orb { position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.35; animation: drift 12s ease-in-out infinite alternate; z-index: 0; }
        .orb1 { width: 420px; height: 420px; background: var(--primary); top: -100px; left: -80px; animation-delay: 0s; }
        .orb2 { width: 350px; height: 350px; background: var(--accent2); bottom: -80px; right: -60px; animation-delay: -4s; }
        .orb3 { width: 250px; height: 250px; background: var(--accent); top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: -8s; }
        @keyframes drift { from { transform: translateY(0) scale(1); } to { transform: translateY(30px) scale(1.08); } }

        /* ── Layout ── */
        .wrapper { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Navbar ── */
        nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 2.5rem;
            background: rgba(10,11,20,0.6);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: .75rem; }
        .nav-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .9rem; color: white; letter-spacing: -0.5px;
        }
        .nav-title { font-weight: 700; font-size: 1.1rem; letter-spacing: -0.3px; }
        .nav-title span { color: var(--primary-light); }
        .nav-links { display: flex; gap: .75rem; }
        .btn-ghost {
            padding: .5rem 1.2rem; border-radius: 8px; font-size: .875rem; font-weight: 500;
            border: 1px solid var(--glass-border); color: var(--muted);
            background: transparent; cursor: pointer; text-decoration: none;
            transition: all .2s;
        }
        .btn-ghost:hover { border-color: var(--primary-light); color: var(--text); background: rgba(99,102,241,0.1); }
        .btn-primary {
            padding: .5rem 1.4rem; border-radius: 8px; font-size: .875rem; font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--accent2));
            color: white; border: none; cursor: pointer; text-decoration: none;
            transition: opacity .2s, transform .2s; display: inline-block;
        }
        .btn-primary:hover { opacity: .85; transform: translateY(-1px); }

        /* ── Hero ── */
        .hero {
            flex: 1; display: flex; flex-direction: column; align-items: center;
            text-align: center; padding: 5rem 2rem 3rem;
            animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp { from { opacity:0; transform: translateY(24px); } to { opacity:1; transform: translateY(0); } }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .35rem 1rem; border-radius: 100px;
            background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3);
            font-size: .78rem; font-weight: 600; color: var(--primary-light);
            margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: .06em;
        }
        .hero-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--accent); display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.3;} }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 800;
            line-height: 1.1; letter-spacing: -1.5px;
            background: linear-gradient(135deg, #f1f5f9 30%, var(--primary-light) 70%, var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            max-width: 800px; margin-bottom: 1.25rem;
        }
        .hero p {
            font-size: 1.1rem; color: var(--muted); max-width: 560px;
            line-height: 1.7; margin-bottom: 2.5rem;
        }
        .hero-cta { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 4rem; }
        .btn-large {
            padding: .8rem 2rem; border-radius: 10px; font-size: 1rem; font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--accent2));
            color: white; border: none; cursor: pointer; text-decoration: none;
            transition: all .25s; box-shadow: 0 4px 24px rgba(99,102,241,0.35);
        }
        .btn-large:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(99,102,241,0.45); }
        .btn-outline-large {
            padding: .8rem 2rem; border-radius: 10px; font-size: 1rem; font-weight: 600;
            border: 1px solid var(--glass-border); color: var(--text);
            background: var(--glass); backdrop-filter: blur(8px);
            cursor: pointer; text-decoration: none; transition: all .25s;
        }
        .btn-outline-large:hover { border-color: var(--primary-light); background: rgba(99,102,241,0.1); }

        /* ── Stats ── */
        .stats {
            display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;
            margin-bottom: 4rem; animation: fadeUp .7s .15s ease both;
        }
        .stat-card {
            background: var(--card-bg); border: 1px solid var(--glass-border);
            backdrop-filter: blur(12px); border-radius: 16px;
            padding: 1.25rem 2rem; text-align: center; min-width: 140px;
            transition: transform .2s, border-color .2s;
        }
        .stat-card:hover { transform: translateY(-3px); border-color: rgba(99,102,241,0.4); }
        .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--primary-light); line-height: 1; }
        .stat-label { font-size: .78rem; color: var(--muted); margin-top: .3rem; font-weight: 500; text-transform: uppercase; letter-spacing: .05em; }

        /* ── Features Grid ── */
        .section { padding: 0 2rem 4rem; animation: fadeUp .7s .3s ease both; }
        .section-title { text-align: center; font-size: 1.5rem; font-weight: 700; margin-bottom: .5rem; }
        .section-sub { text-align: center; color: var(--muted); font-size: .95rem; margin-bottom: 2.5rem; }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem; max-width: 1100px; margin: 0 auto;
        }
        .feature-card {
            background: var(--card-bg); border: 1px solid var(--glass-border);
            backdrop-filter: blur(12px); border-radius: 16px; padding: 1.75rem;
            transition: transform .25s, border-color .25s, box-shadow .25s;
            cursor: default;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            border-color: rgba(99,102,241,0.35);
            box-shadow: 0 8px 32px rgba(99,102,241,0.12);
        }
        .feature-icon {
            width: 48px; height: 48px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; font-size: 1.4rem;
            margin-bottom: 1rem;
        }
        .feature-card h3 { font-size: 1rem; font-weight: 600; margin-bottom: .4rem; }
        .feature-card p { font-size: .85rem; color: var(--muted); line-height: 1.6; }

        /* ── Login Section ── */
        .login-section {
            padding: 0 2rem 5rem; display: flex; gap: 1.5rem;
            justify-content: center; flex-wrap: wrap;
            animation: fadeUp .7s .45s ease both;
        }
        .login-card {
            background: var(--card-bg); border: 1px solid var(--glass-border);
            backdrop-filter: blur(16px); border-radius: 20px; padding: 2.5rem 2rem;
            width: 100%; max-width: 320px; text-align: center;
            transition: transform .25s, box-shadow .25s;
        }
        .login-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.3); }
        .login-card-icon {
            width: 64px; height: 64px; border-radius: 50%; margin: 0 auto 1.2rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.6rem;
        }
        .login-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: .4rem; }
        .login-card p { font-size: .85rem; color: var(--muted); margin-bottom: 1.5rem; line-height: 1.5; }
        .login-card .btn-login {
            display: block; width: 100%; padding: .75rem; border-radius: 10px;
            font-size: .9rem; font-weight: 600; text-decoration: none;
            text-align: center; transition: all .2s;
        }
        .btn-admin { background: linear-gradient(135deg, var(--primary), var(--accent2)); color: white; border: none; }
        .btn-admin:hover { opacity: .85; }
        .btn-emp { background: transparent; color: var(--primary-light); border: 1px solid rgba(99,102,241,0.4); }
        .btn-emp:hover { background: rgba(99,102,241,0.1); }

        /* ── Footer ── */
        footer {
            text-align: center; padding: 1.5rem;
            border-top: 1px solid var(--glass-border);
            color: var(--muted); font-size: .8rem;
        }
        footer span { color: var(--primary-light); font-weight: 600; }
    </style>
</head>
<body>
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>

<div class="wrapper">

    <!-- Navbar -->
    <nav>
        <div class="nav-brand">
            <div class="nav-logo">HR</div>
            <div class="nav-title">OHA<span>-HRMS</span></div>
        </div>
        <div class="nav-links">
            <a href="{{ route('employee.login') }}" class="btn-ghost">Employee Login</a>
            <a href="{{ route('admin.login') }}" class="btn-primary">Admin Login</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-badge">✦ Next-Gen HR Platform</div>
        <h1>Streamline Your<br>Entire Workforce</h1>
        <p>OHA-HRMS empowers HR teams with intelligent tools for employee management, payroll, attendance, and more — all in one unified platform.</p>
        <div class="hero-cta">
            <a href="{{ route('admin.login') }}" class="btn-large">🔐 Admin Portal</a>
            <a href="{{ route('employee.login') }}" class="btn-outline-large">👤 Employee Login</a>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-label">Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">99.9%</div>
                <div class="stat-label">Uptime</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12+</div>
                <div class="stat-label">HR Modules</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="section">
        <div class="section-title">Everything HR Needs</div>
        <div class="section-sub">Comprehensive modules designed to manage your entire employee lifecycle</div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(99,102,241,0.15);">👥</div>
                <h3>Employee Management</h3>
                <p>Maintain rich employee profiles, org charts, and department hierarchies from one place.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(6,182,212,0.15);">📅</div>
                <h3>Attendance & Leave</h3>
                <p>Track daily attendance, manage leave requests, and generate accurate reports effortlessly.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(168,85,247,0.15);">💰</div>
                <h3>Payroll & Salary</h3>
                <p>Automate payroll calculations, salary slips, and statutory compliance with ease.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(245,158,11,0.15);">📄</div>
                <h3>Document & Letters</h3>
                <p>Generate offer letters, appointment letters, and HR documents in seconds.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(34,197,94,0.15);">🔒</div>
                <h3>Role-Based Access</h3>
                <p>Granular permissions ensure the right people see the right data at all times.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(239,68,68,0.15);">📊</div>
                <h3>HR Analytics</h3>
                <p>Insightful dashboards and reports to drive data-informed HR decisions.</p>
            </div>
        </div>
    </section>

    <!-- Login Cards -->
    <section class="login-section">
        <div class="login-card">
            <div class="login-card-icon" style="background:rgba(99,102,241,0.15);">🛡️</div>
            <h3>Administrator</h3>
            <p>Manage employees, configure payroll, review reports, and control all HR operations.</p>
            <a href="{{ route('admin.login') }}" class="btn-login btn-admin">Login as Admin</a>
        </div>
        <div class="login-card">
            <div class="login-card-icon" style="background:rgba(6,182,212,0.15);">👤</div>
            <h3>Employee</h3>
            <p>Access your profile, apply for leaves, view payslips, and stay updated with company news.</p>
            <a href="{{ route('employee.login') }}" class="btn-login btn-emp">Login as Employee</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} <span>OHA-HRMS</span> &mdash; Organization Human Resources Management System. All rights reserved.
    </footer>

</div>
</body>
</html>
