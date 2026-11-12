@extends('layouts.guest.landing')

@section('styles')
    <style>
        /* Landing page — reuses Spark Admin design tokens from main.css */
        .landing-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bs-body-bg);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Geometric background decoration (same language as the login page) */
        .landing-bg-shape {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--brand-lime-translucent) 0%, rgba(180, 241, 5, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            animation: landing-float 10s ease-in-out infinite;
        }

        .landing-bg-shape-1 {
            top: -50px;
            left: -50px;
        }

        .landing-bg-shape-2 {
            bottom: -100px;
            right: -50px;
            width: 400px;
            height: 400px;
            animation-delay: -5s;
        }

        @keyframes landing-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(24px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .landing-bg-shape {
                animation: none;
            }
        }

        .landing-card {
            background-color: var(--card-background);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xxl);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: var(--shadow-lg);
            z-index: 1;
            position: relative;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .landing-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px rgba(11, 19, 15, 0.12);
        }

        .landing-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--brand-forest-dark);
            text-decoration: none;
            margin-bottom: 2rem;
        }

        .landing-brand i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: var(--radius-lg);
            background-color: var(--brand-forest-dark);
            color: var(--brand-lime);
            font-size: 1.25rem;
        }

        .landing-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background-color: var(--brand-lime-translucent);
            color: var(--brand-forest-medium);
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .landing-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.75rem;
        }

        .landing-subtitle {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-muted-green);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .landing-actions .btn-landing {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            border: none;
            border-radius: var(--radius-lg);
            background-color: var(--brand-lime);
            color: var(--brand-forest-dark);
            font-family: var(--bs-body-font-family);
            font-size: 0.925rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s ease;
        }

        .landing-actions .btn-landing:hover,
        .landing-actions .btn-landing:focus-visible {
            background-color: var(--brand-lime-hover);
            color: var(--brand-forest-dark);
            transform: translateY(-1px);
        }

        .landing-footer {
            margin-top: 2rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted-green);
        }
    </style>
@endsection

@section('content')
    <!-- ==========================================
         START: Landing Placeholder Card
         ========================================== -->
    <div class="landing-wrapper">
        <!-- Glowing background shapes for modern visual appearance -->
        <div class="landing-bg-shape landing-bg-shape-1"></div>
        <div class="landing-bg-shape landing-bg-shape-2"></div>

        <!-- Main centered card -->
        <div class="landing-card">
            <!-- Brand Identity -->
            <a href="{{ url('/') }}" class="landing-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>{{ config('app.name', 'Law Practice Management') }}</span>
            </a>

            <div class="landing-icon">
                <i class="bi bi-cone-striped"></i>
            </div>

            <h1 class="landing-title">No landing page yet</h1>

            <p class="landing-subtitle">
                Our public website is still on its way. In the meantime, sign in to access
                {{ config('app.name', 'the system') }}.
            </p>

            <div class="landing-actions">
                @auth
                    <a href="{{ route('timesheet') }}" class="btn-landing">
                        <span>Go to Dashboard</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-landing">
                        <span>Sign In</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endauth
            </div>

            <p class="landing-footer">&copy; {{ date('Y') }} {{ config('app.name', 'Law Practice Management') }}. All rights reserved.</p>
        </div>
    </div>
    <!-- END: Landing Placeholder Card -->
@endsection
