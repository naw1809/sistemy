<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistemy Dashboard')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ filemtime(public_path('css/dashboard.css')) }}">
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo-details">
            <i class='bx bx-book-bookmark icon'></i>
            <div class="logo_name">Sistemy</div>
        </div>
        <ul class="nav-list">
            <li>
                <a href="{{ url('/') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bast.index') }}" class="{{ request()->routeIs('bast.*') && !request()->routeIs('bast.history') ? 'active' : '' }}">
                    <i class='bx bx-folder'></i>
                    <span class="links_name">Data BAST</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bast.history') }}" class="{{ request()->routeIs('bast.history') ? 'active' : '' }}">
                    <i class='bx bx-history'></i>
                    <span class="links_name">Riwayat BAST</span>
                </a>
            </li>
            <li>
                
                <a href="{{ route('minuta.index') }}" class="{{ request()->routeIs('minuta.*') ? 'active' : '' }}">
                    <i class='bx bx-file-blank'></i>
                    <span class="links_name">Data Minuta</span>
                </a>
            </li>
            <li class="profile" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="profile-details" style="display: flex; align-items: center; gap: 12px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=BE123C&color=fff" alt="profileImg">
                    <div class="name_job" style="display: flex; flex-direction: column;">
                        <div class="name" style="max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ auth()->user()->name }}</div>
                        <div class="job">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #BE123C; font-size: 20px; display: flex; align-items: center; justify-content: center; padding: 6px; border-radius: 8px; transition: var(--transition); background: rgba(190, 18, 60, 0.1);" title="Keluar">
                    <i class='bx bx-log-out'></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay"></div>

    <!-- Main Content -->
    <section class="home-section">
        <div class="topbar">
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">@yield('page_title', 'Dashboard')</span>
            </div>
        </div>
        
        <div class="home-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class='bx bxs-check-circle'></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class='bx bxs-error-circle'></i> Please fix the errors in the form.
                </div>
            @endif

            @yield('content')
        </div>
    </section>

    <!-- Scripts -->
    <script>
        const sidebar = document.querySelector(".sidebar");
        const sidebarBtn = document.querySelector(".sidebarBtn");
        const overlay = document.querySelector(".sidebar-overlay");

        // Terapkan status tersimpan dari localStorage
        if (localStorage.getItem("sidebar-collapsed") === "true") {
            sidebar.classList.add("active");
        }

        if (sidebarBtn) {
            sidebarBtn.onclick = function() {
                sidebar.classList.toggle("active");
                localStorage.setItem("sidebar-collapsed", sidebar.classList.contains("active"));
            };
        }

        if (overlay) {
            overlay.onclick = function() {
                sidebar.classList.remove("mobile-open");
                overlay.classList.remove("active");
            };
        }
    </script>
    @stack('scripts')
</body>
</html>
