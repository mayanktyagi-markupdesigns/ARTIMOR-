<header>
    <!-- Top Header -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="addcol">
                <div class="fs-5 fw-bold sitecolor">{{ __('front.visit_us_daily') }}</div>
                <p>
                    {!! get_setting('visit-us-daily', '') !!}
                </p>
            </div>
            <div class="logo-text">
                <a href="{{ route('home') }}">
                    <img width="60" src="{{ asset('assets/front/img/logo.png')}}" alt="" />
                </a>
            </div>
            <div class="addcol">
                <div class="fs-5 fw-bold sitecolor">{{ __('front.connect_with_us') }}</div>
                <p><a href="{{ get_setting('phone', '') }}">{{ get_setting('phone', '') }}</a></p>
                <p><a href="mailto:{{ get_setting('mail', '') }}">{{ get_setting('mail', '') }}</a></p>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-lg-none fw-bold" href="#">Artimar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <!-- Left Links -->
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">{{ __('front.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://artimar.be/contact-opnemen" target="_blank">{{ __('front.contact_us') }}</a></li>
                </ul>
                <!-- Right Icons -->
                <ul class="navbar-nav">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('login') }}"><i class="fa fa-user"></i></a>
                    </li> -->
                    <li class="nav-item">
                        @auth
                        <!-- Agar user login hai -->
                        <a class="nav-link" href="{{ route('my.account') }}"><i class="fa fa-user"></i></a>
                        @else
                        <!-- Agar user login nahi hai -->
                        <a class="nav-link" href="{{ url('login') }}"><i class="fa fa-user"></i></a>
                        @endauth
                    </li>

                    <li class="nav-item dropdown">
                        @php
                            $supportedLocales = config('locales.supported', []);
                            $currentLocale = app()->getLocale();
                            $currentLocaleShort = strtoupper($supportedLocales[$currentLocale]['short'] ?? $currentLocale);
                        @endphp
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="languageDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-globe"></i>
                            <span>{{ $currentLocaleShort }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            @foreach ($supportedLocales as $localeCode => $locale)
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $currentLocale === $localeCode ? 'active' : '' }}"
                                        href="{{ route('language.switch', ['locale' => $localeCode, 'redirect' => request()->fullUrl()]) }}">
                                        <span>{{ $locale['label'] }}</span>
                                        <span class="badge bg-light text-dark border">{{ strtoupper($locale['short']) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link" href="#"><i class="fa fa-search" id="openSearch"-->
                    <!--            style="cursor: pointer;"></i></a>-->
                    <!--</li>-->
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Steps Section -->
<div class="main-pg">   
   
    <div class="section-cl top-step-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5 text-center">
                    <h2 class="page-title">Calculate Material Price</h2>
                    <p class="tagline">Choose Your Material Via The Overview Below</p>
                </div>
            </div>
            <!-- <div class="steps">
                <div class="step active">
                    <div class="icon"><span>01</span>
                        <img src="{{ asset('assets/front/img/01.png') }}" width="28" height="28">
                    </div>
                    <p>Material Price</p>
                </div>
                <div class="step">
                    <div class="icon"><span>02</span>
                        <img src="{{ asset('assets/front/img/02.png') }}" width="28" height="28">
                    </div>
                    <p>Type of</p>
                </div>
                <div class="step">
                    <div class="icon"><span>03</span>
                        <img src="{{ asset('assets/front/img/03.png') }}" width="28" height="28">
                    </div>
                    <p>Choose Layout</p>
                </div>
                <div class="step">
                    <div class="icon"><span>04</span>
                        <img src="{{ asset('assets/front/img/04.png') }}" width="28" height="28">
                    </div>
                    <p>Dimensions</p>
                </div>
                <div class="step">
                    <div class="icon"><span>05</span>
                        <img src="{{ asset('assets/front/img/05.png') }}" width="28" height="28">
                    </div>
                    <p>Edge Finishing</p>
                </div>
                <div class="step">
                    <div class="icon"><span>06</span>
                        <img src="{{ asset('assets/front/img/06.png') }}" width="28" height="28">
                    </div>
                    <p>Back Wall</p>
                </div>
                <div class="step">
                    <div class="icon"><span>07</span>
                        <img src="{{ asset('assets/front/img/07.png') }}" width="28" height="28">
                    </div>
                    <p>Sink</p>
                </div>
                <div class="step">
                    <div class="icon"><span>08</span>
                        <img src="{{ asset('assets/front/img/08.png') }}" width="28" height="28">
                    </div>
                    <p>Cut Outs</p>
                </div>
                <div class="step">
                    <div class="icon"><span>09</span>
                        <img src="{{ asset('assets/front/img/09.png') }}" width="28" height="28">
                    </div>
                    <p>Overview</p>
                </div>
            </div> -->