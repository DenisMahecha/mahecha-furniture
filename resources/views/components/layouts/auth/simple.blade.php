<!DOCTYPE html>
<html lang="sw">
    <head>
        @php($title = 'Ingia | Mahecha Furniture')
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="auth-page">
        <main class="auth-layout">
            <section class="auth-showcase">
                <div class="auth-showcase-image"></div>
                <div class="auth-showcase-overlay"></div>
                <div class="auth-showcase-content">
                    <a href="{{ route('home') }}" class="auth-brand" wire:navigate aria-label="Rudi Mahecha Furniture">
                        <span class="auth-brand-mark" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M10 35V12h5l9 12 9-12h5v23h-6V22l-8 10-8-10v13z" /></svg></span>
                        <span><strong>Mahecha</strong><small>FURNITURE <i>·</i> IFAKARA</small></span>
                    </a>
                    <div class="auth-showcase-copy">
                        <p class="auth-kicker"><span></span> Karibu nyumbani</p>
                        <h1>Fenicha nzuri.<br><em>Maisha mazuri.</em></h1>
                        <p>Simamia catalog yako, bei na oda za wateja kwa urahisi.</p>
                    </div>
                    <div class="auth-showcase-foot"><span>MAHECHA FURNITURE</span><span>EST. 2024 · IFAKARA</span></div>
                </div>
            </section>
            <section class="auth-panel">
                <div class="auth-panel-inner">
                    <div class="auth-mobile-brand"><a href="{{ route('home') }}" class="auth-brand" wire:navigate><span class="auth-brand-mark" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M10 35V12h5l9 12 9-12h5v23h-6V22l-8 10-8-10v13z" /></svg></span><span><strong>Mahecha</strong><small>FURNITURE <i>·</i> IFAKARA</small></span></a></div>
                    <div class="auth-form-wrap">{{ $slot }}</div>
                    <p class="auth-panel-footer">© {{ date('Y') }} Mahecha Furniture <span>·</span> Ifakara, Tanzania</p>
                </div>
            </section>
        </main>
        @fluxScripts
    </body>
</html>
