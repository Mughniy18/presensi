<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi Karyawan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb; /* Light background similar to Tabler */
            overflow-x: hidden; /* Prevent horizontal scroll when sidebar is off-screen */
        }
        .tabler-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        }
        .tabler-btn {
            border-radius: 0.375rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .tabler-btn-primary {
            background-color: #206bc4;
            color: #ffffff;
        }
        .tabler-btn-primary:hover {
            background-color: #1a5bbd;
        }
        .tabler-btn-outline-primary {
            border: 1px solid #206bc4;
            color: #206bc4;
            background-color: transparent;
        }
        .tabler-btn-outline-primary:hover {
            background-color: #e0f0ff;
        }
        .tabler-input {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            padding: 0.625rem 0.75rem;
            width: 100%;
            transition: border-color 0.2s ease-in-out;
        }
        .tabler-input:focus {
            border-color: #206bc4;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(32, 107, 196, 0.25);
        }
        .tabler-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #495057;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }
        .tabler-nav-link:hover {
            background-color: #e9ecef;
            color: #212529;
        }
        .tabler-nav-link.active {
            background-color: #206bc4;
            color: #ffffff;
        }
        .tabler-nav-link.active .tabler-nav-link-icon {
            color: #ffffff;
        }
        .tabler-nav-link-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
            color: #6c757d;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            position: relative;
        }
        .modal-close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal-close-btn:hover,
        .modal-close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Custom styles for calendar */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            text-align: center;
        }
        .calendar-day-header {
            font-weight: bold;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }
        .calendar-day {
            padding: 0.75rem 0.5rem;
            border-radius: 0.375rem;
            background-color: #ffffff;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .calendar-day:hover {
            background-color: #e9ecef;
        }
        .calendar-day.current-month {
            color: #212529;
        }
        .calendar-day.other-month {
            color: #adb5bd;
        }
        .calendar-day.today {
            background-color: #206bc4;
            color: #ffffff;
            font-weight: bold;
        }
        .calendar-day.has-agenda {
            border: 2px solid #206bc4;
        }
        .calendar-day.selected {
            background-color: #0d6efd;
            color: #ffffff;
        }
        .agenda-item {
            background-color: #e0f0ff;
            border-left: 4px solid #206bc4;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.375rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .agenda-item button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
        }
        .agenda-item button:hover {
            color: #c82333;
        }

        /* Responsive Sidebar Styles */
        .main-app-container {
            display: flex;
            min-height: 100vh;
            position: relative; /* Needed for overlay positioning */
        }

        .sidebar {
            width: 16rem; /* 256px */
            background-color: #ffffff;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
            padding: 1rem;
            flex-shrink: 0;
            transition: transform 0.3s ease-in-out;
            z-index: 50; /* Above main content */
            overflow-y: auto; /* Added for scrolling */
        }

        .content-area {
            flex-grow: 1;
            padding: 1.5rem; /* 24px */
            background-color: #f5f7fb;
            overflow-y: auto;
        }

        /* Mobile specific styles */
        @media (max-width: 767px) { /* Tailwind's 'md' breakpoint is 768px */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                transform: translateX(-100%); /* Hide sidebar by default */
            }

            .main-app-container.sidebar-open .sidebar {
                transform: translateX(0); /* Show sidebar when open */
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40; /* Below sidebar, above content */
                display: none; /* Hidden by default */
            }

            .main-app-container.sidebar-open .sidebar-overlay {
                display: block; /* Show overlay when sidebar is open */
            }

            .hamburger-menu-button {
                display: block; /* Show hamburger button on mobile */
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }
        }

        /* Desktop specific styles */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0); /* Always show sidebar on desktop */
            }
            .hamburger-menu-button {
                display: none; /* Hide hamburger button on desktop */
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Login Page -->
    <div id="login-page" class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="tabler-card w-full max-w-md p-8 shadow-lg">
            <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">Login Aplikasi Absensi</h2>
            <form id="login-form">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" class="tabler-input" placeholder="Masukkan username" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="tabler-input" placeholder="Masukkan password" required>
                </div>
                <div id="login-error" class="text-red-500 text-sm text-center mb-4 hidden">Username atau password salah.</div>
                <button type="submit" class="tabler-btn tabler-btn-primary w-full">Login</button>
            </form>
        </div>
    </div>

    <!-- Main Application Layout -->
    <div id="main-app" class="main-app-container hidden">
        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebar-overlay" class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="flex items-center justify-center mb-6">
                <h1 class="text-2xl font-bold text-blue-600">Absensi App</h1>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="#" data-page="dashboard" class="tabler-nav-link active">
                            <i class="fas fa-tachometer-alt tabler-nav-link-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li data-role-visibility="employee">
                        <a href="#" data-page="absensi" class="tabler-nav-link">
                            <i class="fas fa-camera tabler-nav-link-icon"></i>
                            <span>Absensi</span>
                        </a>
                    </li>
                    <li id="admin-menu-items" class="hidden" data-role-visibility="admin">
                        <a href="#" data-page="data-karyawan" class="tabler-nav-link">
                            <i class="fas fa-users tabler-nav-link-icon"></i>
                            <span>Data Karyawan</span>
                        </a>
                        <a href="#" data-page="master-data" class="tabler-nav-link">
                            <i class="fas fa-database tabler-nav-link-icon"></i>
                            <span>Master Data</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-page="kalender" class="tabler-nav-link">
                            <i class="fas fa-calendar-alt tabler-nav-link-icon"></i>
                            <span>Kalender Agenda</span>
                        </a>
                    </li>
                    <li data-role-visibility="employee">
                        <a href="#" data-page="izin-sakit" class="tabler-nav-link">
                            <i class="fas fa-file-alt tabler-nav-link-icon"></i>
                            <span>Izin / Sakit</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-page="rekap-absen" class="tabler-nav-link">
                            <i class="fas fa-clipboard-list tabler-nav-link-icon"></i>
                            <span>Rekap Absen</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto pt-4 border-t border-gray-200">
                <a href="#" id="logout-btn" class="tabler-nav-link text-red-600 hover:bg-red-50 hover:text-red-700">
                    <i class="fas fa-sign-out-alt tabler-nav-link-icon"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="content-area">
            <!-- Header -->
            <header class="bg-white tabler-card p-4 mb-6 flex justify-between items-center shadow-sm">
                <div class="header-content">
                    <!-- Hamburger Menu Button (visible on mobile) -->
                    <button id="hamburger-menu-btn" class="hamburger-menu-button text-gray-600 focus:outline-none mr-4">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <h2 id="page-title" class="text-xl font-semibold text-gray-800 flex-grow">Dashboard</h2>
                    <div class="flex items-center space-x-3">
                        <span id="user-display-name" class="text-gray-700 font-medium">Pengguna</span>
                        <i class="fas fa-user-circle text-2xl text-gray-500"></i>
                    </div>
                </div>
            </header>

            <!-- Page Content Containers -->
            <div id="dashboard-page" class="page-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <div id="total-employees-card" class="tabler-card p-5 flex items-center space-x-4">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Total Karyawan</div>
                            <div class="text-2xl font-bold text-gray-800"><span id="total-employees">0</span></div>
                        </div>
                    </div>
                    <div class="tabler-card p-5 flex items-center space-x-4">
                        <div class="p-3 bg-green-100 text-green-600 rounded-full">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Absen Hari Ini</div>
                            <div class="text-2xl font-bold text-gray-800"><span id="absent-today">0</span></div>
                        </div>
                    </div>
                    <div class="tabler-card p-5 flex items-center space-x-4">
                        <div class="p-3 bg-red-100 text-red-600 rounded-full">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Izin / Sakit Hari Ini</div>
                            <div class="text-2xl font-bold text-gray-800"><span id="leave-sick-today">0</span></div>
                        </div>
                    </div>
                </div>
                <!-- New card for pending leave requests on Dashboard (Admin only) -->
                <div id="pending-leave-card" class="tabler-card p-6 mb-6 hidden" data-role-visibility="admin">
                    <h3 class="text-lg font-semibold mb-4">Pengajuan Izin/Sakit Menunggu Persetujuan</h3>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-4xl font-bold text-red-600" id="pending-leave-count">0</span>
                        <span class="text-lg text-gray-600">Pengajuan Baru</span>
                    </div>
                    <a href="#" data-page="izin-sakit" class="tabler-btn tabler-btn-outline-primary w-full">Lihat & Setujui Pengajuan</a>
                </div>
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4">Grafik Absensi Bulanan</h3>
                    <div class="h-64 bg-gray-50 flex items-center justify-center rounded-md text-gray-400">
                        <canvas id="monthly-attendance-chart"></canvas>
                    </div>
                </div>
            </div>

            <div id="absensi-page" class="page-content hidden">
                <div class="tabler-card p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Ambil Absensi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ambil Foto (Pengenalan Wajah)</label>
                            <video id="camera-feed" class="w-full h-64 bg-gray-200 rounded-md mb-3" autoplay playsinline style="object-fit: cover;"></video>
                            <canvas id="photo-canvas" class="w-full h-64 bg-gray-200 rounded-md mb-3 hidden"></canvas>
                            <button id="capture-photo-btn" class="tabler-btn tabler-btn-primary w-full mb-2"><i class="fas fa-camera mr-2"></i> Ambil Foto</button>
                            <button id="retake-photo-btn" class="tabler-btn tabler-btn-outline-primary w-full hidden"><i class="fas fa-redo mr-2"></i> Ambil Ulang</button>
                            <div id="face-recognition-status" class="text-sm mt-2 text-gray-600">Status Pengenalan Wajah: Menunggu...</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi GPS</label>
                            <div id="map-container" class="w-full h-64 bg-gray-200 rounded-md mb-3 flex items-center justify-center text-gray-400 overflow-hidden">
                                <!-- Placeholder for Google Map iframe or image -->
                                <iframe id="google-map-iframe" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                            <div class="text-sm text-gray-600 mb-2">
                                Lokasi Saat Ini: <span id="current-location">Mencari lokasi...</span>
                            </div>
                            <div class="text-sm text-gray-600 mb-2">
                                Jarak ke Kantor: <span id="distance-to-office">Menghitung...</span>
                            </div>
                            <button id="get-location-btn" class="tabler-btn tabler-btn-primary w-full mb-2"><i class="fas fa-map-marker-alt mr-2"></i> Dapatkan Lokasi</button>
                            <div id="location-status" class="text-sm mt-2 text-gray-600">Status GPS: Menunggu...</div>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <div class="text-sm text-gray-700 mb-2">Waktu Masuk Kantor: <span class="font-semibold" id="display-checkin-time">08:00</span></div>
                        <div class="text-sm text-gray-700 mb-4">Waktu Pulang Kantor: <span class="font-semibold" id="display-checkout-time">17:00</span></div>
                        <button id="check-in-btn" class="tabler-btn tabler-btn-primary w-full md:w-1/2 lg:w-1/3 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-sign-in-alt mr-2"></i> Check-in
                        </button>
                        <button id="check-out-btn" class="tabler-btn tabler-btn-outline-primary w-full md:w-1/2 lg:w-1/3 mt-2 md:mt-0 md:ml-4 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-sign-out-alt mr-2"></i> Check-out
                        </button>
                    </div>
                </div>
            </div>

            <div id="data-karyawan-page" class="page-content hidden">
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4">Manajemen Data Karyawan</h3>
                    <div class="mb-4">
                        <button id="add-employee-btn" class="tabler-btn tabler-btn-primary"><i class="fas fa-plus mr-2"></i> Tambah Karyawan Baru</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap table-auto">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <th class="px-4 py-3 rounded-tl-md">Nama</th>
                                    <th class="px-4 py-3">Jabatan</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Username</th>
                                    <th class="px-4 py-3">Foto</th>
                                    <th class="px-4 py-3 rounded-tr-md">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="employee-list-body" class="divide-y divide-gray-200">
                                <!-- Employee data will be rendered here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="master-data-page" class="page-content hidden">
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4">Master Data (Jabatan, Lokasi & Waktu Kerja)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium mb-2">Daftar Jabatan</h4>
                            <div class="mb-3 flex">
                                <input type="text" id="new-position-name" class="tabler-input flex-1 mr-2" placeholder="Nama Jabatan Baru">
                                <button id="add-position-btn" class="tabler-btn tabler-btn-primary">Tambah</button>
                            </div>
                            <ul id="position-list" class="space-y-2">
                                <!-- Position data will be rendered here by JavaScript -->
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium mb-2">Daftar Lokasi Absensi</h4>
                            <div class="mb-3">
                                <input type="text" id="new-location-name" class="tabler-input mb-2" placeholder="Nama Lokasi (ex: Kantor Pusat)">
                                <input type="text" id="new-location-lat" class="tabler-input mb-2" placeholder="Latitude (ex: -6.2088)">
                                <input type="text" id="new-location-lon" class="tabler-input mb-2" placeholder="Longitude (ex: 106.8456)">
                                <input type="number" id="new-location-radius" class="tabler-input mb-2" placeholder="Radius (meter, ex: 50)">
                                <button id="add-location-btn" class="tabler-btn tabler-btn-primary w-full">Tambah Lokasi</button>
                            </div>
                            <ul id="location-list" class="space-y-2">
                                <!-- Location data will be rendered here by JavaScript -->
                            </ul>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h4 class="font-medium mb-2">Pengaturan Waktu Kerja</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="office-checkin-time-input" class="block text-sm font-medium text-gray-700 mb-1">Waktu Masuk Kantor Default</label>
                                <input type="time" id="office-checkin-time-input" class="tabler-input" value="08:00">
                            </div>
                            <div>
                                <label for="office-checkout-time-input" class="block text-sm font-medium text-gray-700 mb-1">Waktu Pulang Kantor Default</label>
                                <input type="time" id="office-checkout-time-input" class="tabler-input" value="17:00">
                            </div>
                        </div>
                        <button id="save-office-hours-btn" class="tabler-btn tabler-btn-primary mt-4 w-full md:w-auto">Simpan Waktu Kerja</button>
                    </div>
                </div>
            </div>

            <div id="kalender-page" class="page-content hidden">
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4">Kalender Agenda Kantor</h3>
                    <div class="flex justify-between items-center mb-4">
                        <button id="prev-month-btn" class="tabler-btn tabler-btn-outline-primary"><i class="fas fa-chevron-left"></i></button>
                        <h4 id="current-month-year" class="text-xl font-semibold"></h4>
                        <button id="next-month-btn" class="tabler-btn tabler-btn-outline-primary"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-grid mb-6">
                        <div class="calendar-day-header">Sen</div>
                        <div class="calendar-day-header">Sel</div>
                        <div class="calendar-day-header">Rab</div>
                        <div class="calendar-day-header">Kam</div>
                        <div class="calendar-day-header">Jum</div>
                        <div class="calendar-day-header">Sab</div>
                        <div class="calendar-day-header">Min</div>
                        <!-- Days will be generated by JavaScript -->
                    </div>
                    <div id="calendar-days-container" class="calendar-grid mb-6"></div>

                    <div id="add-agenda-section" class="mt-6">
                        <h4 class="font-medium mb-2">Tambah Agenda Baru</h4>
                        <div class="flex flex-col md:flex-row gap-2 mb-4">
                            <input type="date" id="agenda-date" class="tabler-input flex-1" required>
                            <input type="text" id="agenda-title" class="tabler-input flex-1" placeholder="Judul Agenda" required>
                            <button id="add-agenda-btn" class="tabler-btn tabler-btn-primary"><i class="fas fa-plus mr-2"></i> Tambah Agenda</button>
                        </div>
                        <h4 class="font-medium mb-2">Daftar Agenda</h4>
                        <ul id="agenda-list" class="space-y-2">
                            <!-- Agenda items will be listed here -->
                        </ul>
                    </div>
                </div>
            </div>

            <div id="izin-sakit-page" class="page-content hidden">
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4">Pengajuan Izin / Sakit</h3>

                    <!-- Employee View for Izin/Sakit -->
                    <div id="employee-izin-sakit-view" data-role-visibility="employee">
                        <h4 class="font-medium mb-2">Form Pengajuan Izin / Sakit</h4>
                        <form id="izin-sakit-form">
                            <div class="mb-4">
                                <label for="request-type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Pengajuan</label>
                                <select id="request-type" class="tabler-input" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="start-date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" id="start-date" class="tabler-input" required>
                            </div>
                            <div class="mb-4">
                                <label for="end-date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" id="end-date" class="tabler-input" required>
                            </div>
                            <div class="mb-4">
                                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                                <textarea id="reason" rows="4" class="tabler-input" placeholder="Jelaskan alasan pengajuan Anda..." required></textarea>
                            </div>
                            <div class="mb-6">
                                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Lampiran (Opsional)</label>
                                <input type="file" id="attachment" class="tabler-input border-none p-0">
                                <p class="text-xs text-gray-500 mt-1">Contoh: Surat dokter untuk sakit.</p>
                            </div>
                            <button type="submit" class="tabler-btn tabler-btn-primary w-full">Ajukan</button>
                        </form>

                        <h4 class="font-medium mt-8 mb-4">Riwayat Pengajuan Saya</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <th class="px-4 py-3 rounded-tl-md">Jenis</th>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Alasan</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3 rounded-tr-md">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-leave-list-body" class="divide-y divide-gray-200">
                                    <!-- Employee's leave requests will be rendered here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Admin View for Izin/Sakit -->
                    <div id="admin-izin-sakit-view" class="hidden" data-role-visibility="admin">
                        <h4 class="font-medium mb-2">Daftar Pengajuan Izin / Sakit (Menunggu Persetujuan)</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <th class="px-4 py-3 rounded-tl-md">Karyawan</th>
                                        <th class="px-4 py-3">Jenis</th>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Alasan</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3 rounded-tr-md">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-leave-list-body" class="divide-y divide-gray-200">
                                    <!-- Admin's view of leave requests will be rendered here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="rekap-absen-page" class="page-content hidden">
                <div class="tabler-card p-6">
                    <h3 class="text-lg font-semibold mb-4" id="rekap-absen-title">Rekap Absensi Karyawan</h3>

                    <div class="flex mb-4 space-x-2">
                        <button id="view-daily-rekap-btn" class="tabler-btn tabler-btn-primary">Rekap Harian</button>
                        <button id="view-monthly-rekap-btn" class="tabler-btn tabler-btn-outline-primary">Rekap Bulanan</button>
                    </div>

                    <!-- Daily Rekap Filters -->
                    <div id="daily-rekap-filters" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="filter-employee-daily" class="block text-sm font-medium text-gray-700 mb-1">Filter Karyawan</label>
                            <select id="filter-employee-daily" class="tabler-input">
                                <option value="">Semua Karyawan</option>
                                <!-- Employee options populated by JS -->
                            </select>
                        </div>
                        <div>
                            <label for="filter-start-date-daily" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" id="filter-start-date-daily" class="tabler-input">
                        </div>
                        <div>
                            <label for="filter-end-date-daily" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" id="filter-end-date-daily" class="tabler-input">
                        </div>
                    </div>

                    <!-- Monthly Rekap Filters -->
                    <div id="monthly-rekap-filters" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 hidden">
                        <div>
                            <label for="filter-employee-monthly" class="block text-sm font-medium text-gray-700 mb-1">Filter Karyawan</label>
                            <select id="filter-employee-monthly" class="tabler-input">
                                <option value="">Semua Karyawan</option>
                                <!-- Employee options populated by JS -->
                            </select>
                        </div>
                        <div>
                            <label for="filter-month-monthly" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                            <select id="filter-month-monthly" class="tabler-input">
                                <!-- Months populated by JS -->
                            </select>
                        </div>
                        <div>
                            <label for="filter-year-monthly" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <select id="filter-year-monthly" class="tabler-input">
                                <!-- Years populated by JS -->
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button id="apply-filter-btn" class="tabler-btn tabler-btn-primary"><i class="fas fa-filter mr-2"></i> Terapkan Filter</button>
                        <button id="reset-filter-btn" class="tabler-btn tabler-btn-outline-primary ml-2"><i class="fas fa-redo mr-2"></i> Reset Filter</button>
                        <button id="export-rekap-btn" class="tabler-btn tabler-btn-primary ml-2"><i class="fas fa-file-excel mr-2"></i> Ekspor ke CSV</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap table-auto">
                            <thead>
                                <tr id="rekap-absen-table-headers" class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <!-- Headers will be rendered by JavaScript based on view type -->
                                </tr>
                            </thead>
                            <tbody id="rekap-absen-list-body" class="divide-y divide-gray-200">
                                <!-- Rekap Absen data will be rendered here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Custom Modal for Messages -->
    <div id="custom-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close-btn">&times;</span>
            <h3 id="modal-title" class="text-lg font-semibold mb-3">Pesan</h3>
            <p id="modal-message" class="text-gray-700 mb-4"></p>
            <button id="modal-ok-btn" class="tabler-btn tabler-btn-primary">OK</button>
        </div>
    </div>

    <!-- Employee Input Modal -->
    <div id="employee-input-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close-btn" id="close-employee-modal">&times;</span>
            <h3 id="employee-modal-title" class="text-lg font-semibold mb-3">Tambah Karyawan Baru</h3>
            <form id="employee-form">
                <div class="mb-3">
                    <label for="employee-name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="employee-name" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="employee-position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <input type="text" id="employee-position" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="employee-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="employee-email" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="employee-username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="employee-username" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="employee-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="employee-password" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ambil Foto Karyawan</label>
                    <video id="employee-camera-feed" class="w-full h-48 bg-gray-200 rounded-md mb-3" autoplay playsinline style="object-fit: cover;"></video>
                    <canvas id="employee-photo-canvas" class="w-full h-48 bg-gray-200 rounded-md mb-3 hidden"></canvas>
                    <img id="employee-photo-preview" class="w-24 h-24 rounded-full mx-auto mb-3 hidden object-cover" alt="Foto Karyawan">
                    <button type="button" id="capture-employee-photo-btn" class="tabler-btn tabler-btn-outline-primary w-full mb-2"><i class="fas fa-camera mr-2"></i> Ambil Foto</button>
                    <button type="button" id="retake-employee-photo-btn" class="tabler-btn tabler-btn-outline-primary w-full hidden"><i class="fas fa-redo mr-2"></i> Ambil Ulang</button>
                    <input type="file" id="upload-employee-photo-input" accept="image/*" class="tabler-input border-none p-0 mt-2">
                    <p class="text-xs text-gray-500 mt-1">Atau unggah foto dari perangkat Anda.</p>
                </div>
                <button type="submit" class="tabler-btn tabler-btn-primary w-full">Simpan Karyawan</button>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close-btn" id="close-confirmation-modal">&times;</span>
            <h3 id="confirmation-modal-title" class="text-lg font-semibold mb-3">Konfirmasi</h3>
            <p id="confirmation-modal-message" class="text-gray-700 mb-4"></p>
            <div class="flex justify-end space-x-2">
                <button id="confirm-cancel-btn" class="tabler-btn tabler-btn-outline-primary">Batal</button>
                <button id="confirm-ok-btn" class="tabler-btn tabler-btn-primary">OK</button>
            </div>
        </div>
    </div>

    <!-- Edit Position Modal -->
    <div id="edit-position-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close-btn" id="close-position-modal">&times;</span>
            <h3 class="text-lg font-semibold mb-3">Edit Jabatan</h3>
            <form id="edit-position-form">
                <div class="mb-3">
                    <label for="edit-position-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Jabatan</label>
                    <input type="text" id="edit-position-name" class="tabler-input" required>
                </div>
                <button type="submit" class="tabler-btn tabler-btn-primary w-full">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <!-- Edit Location Modal -->
    <div id="edit-location-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close-btn" id="close-location-modal">&times;</span>
            <h3 class="text-lg font-semibold mb-3">Edit Lokasi</h3>
            <form id="edit-location-form">
                <div class="mb-3">
                    <label for="edit-location-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lokasi</label>
                    <input type="text" id="edit-location-name" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="edit-location-lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" id="edit-location-lat" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="edit-location-lon" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" id="edit-location-lon" class="tabler-input" required>
                </div>
                <div class="mb-3">
                    <label for="edit-location-radius" class="block text-sm font-medium text-gray-700 mb-1">Radius (meter)</label>
                    <input type="number" id="edit-location-radius" class="tabler-input" required>
                </div>
                <button type="submit" class="tabler-btn tabler-btn-primary w-full">Simpan Perubahan</button>
            </form>
        </div>
    </div>


    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script>
        // --- Global State ---
        let currentUser = null; // Stores logged-in user info (e.g., { username: 'admin', role: 'admin' })
        let currentView = 'dashboard'; // Tracks the currently active page
        let cameraStream = null; // To hold the camera video stream for absensi page
        let employeePhotoStream = null; // To hold the camera video stream for employee photo input
        let photoTaken = false; // Flag to check if photo is taken for absensi
        let employeePhotoTaken = false; // Flag to check if photo is taken for employee input
        let locationObtained = false; // Flag to check if location is obtained and valid
        let userCurrentLat = null; // User's current latitude
        let userCurrentLon = null; // User's current longitude
        let monthlyAttendanceChart = null; // To hold the Chart.js instance
        let currentRekapAbsenView = 'daily'; // 'daily' or 'monthly'

        // Office Time Settings (Can be updated by Admin)
        let officeCheckInTime = '08:00'; // HH:MM
        let officeCheckOutTime = '17:00'; // HH:MM

        // Company Location Settings (Example: Jakarta)
        const companyLatitude = -6.2088; // Latitude kantor
        const companyLongitude = 106.8456; // Longitude kantor
        const attendanceRadius = 100; // Radius toleransi presensi dalam meter

        // Calendar state
        let currentCalendarDate = new Date();
        let agendaData = [
            { date: '2024-07-25', title: 'Rapat Bulanan' },
            { date: '2024-07-28', title: 'Workshop Pengenalan Produk Baru' }
        ];

        // Dummy Data for Admin Pages
        let employees = [
            { id: 0, name: 'Admin User', position: 'Administrator', email: 'admin@example.com', username: 'admin', password: 'admin123', role: 'admin', photoData: null }, // Admin user
            { id: 1, name: 'Budi Santoso', position: 'Manager', email: 'budi.s@example.com', username: 'budi', password: 'password123', role: 'employee', photoData: null },
            { id: 2, name: 'Siti Aminah', position: 'Staff Administrasi', email: 'siti.a@example.com', username: 'siti', password: 'password123', role: 'employee', photoData: null },
            { id: 3, name: 'Joko Susilo', position: 'Developer', email: 'joko.s@example.com', username: 'joko', password: 'password123', role: 'employee', photoData: null },
            { id: 4, name: 'Ahmad Fauzi', position: 'Karyawan', email: 'karyawan@example.com', username: 'karyawan', password: 'karyawan123', role: 'employee', photoData: null } // Karyawan user
        ];
        let positions = ['Manager', 'Staff Administrasi', 'Developer', 'Analis', 'Karyawan', 'Administrator']; // Added Administrator
        let locations = [
            { id: 1, name: 'Kantor Pusat', lat: -6.2088, lon: 106.8456, radius: 50 },
            { id: 2, name: 'Cabang Jakarta', lat: -6.1754, lon: 106.8272, radius: 75 }
        ];
        let nextEmployeeId = employees.length > 0 ? Math.max(...employees.map(e => e.id)) + 1 : 1;
        let nextLocationId = locations.length > 0 ? Math.max(...locations.map(l => l.id)) + 1 : 1;

        // Dummy Attendance Records
        let attendanceRecords = [
            { id: 1, date: '2024-07-20', employeeId: 1, employeeName: 'Budi Santoso', checkIn: '07:55', checkOut: '17:05', status: 'Hadir', notes: '' },
            { id: 2, date: '2024-07-20', employeeId: 2, employeeName: 'Siti Aminah', checkIn: '08:00', checkOut: '17:00', status: 'Hadir', notes: '' },
            { id: 3, date: '2024-07-20', employeeId: 3, employeeName: 'Joko Susilo', checkIn: '08:10', checkOut: '17:00', status: 'Terlambat', notes: 'Terlambat 10 menit' },
            { id: 4, date: '2024-07-20', employeeId: 4, employeeName: 'Ahmad Fauzi', checkIn: '07:58', checkOut: '17:02', status: 'Hadir', notes: '' },
            { id: 5, date: '2024-07-21', employeeId: 1, employeeName: 'Budi Santoso', checkIn: '07:50', checkOut: '17:10', status: 'Hadir', notes: '' },
            { id: 6, date: '2024-07-21', employeeId: 2, employeeName: 'Siti Aminah', checkIn: '08:05', checkOut: '16:55', status: 'Terlambat', notes: 'Pulang lebih awal' },
            { id: 7, date: '2024-07-21', employeeId: 3, employeeName: 'Joko Susilo', checkIn: '07:59', checkOut: '17:01', status: 'Hadir', notes: '' },
            { id: 8, date: '2024-07-21', employeeId: 4, employeeName: 'Ahmad Fauzi', checkIn: '08:00', checkOut: '17:00', status: 'Hadir', notes: '' },
            { id: 9, date: '2024-07-22', employeeId: 1, employeeName: 'Budi Santoso', checkIn: '07:55', checkOut: '17:05', status: 'Hadir', notes: '' },
            { id: 10, date: '2024-07-22', employeeId: 2, employeeName: 'Siti Aminah', checkIn: '08:00', checkOut: '17:00', status: 'Hadir', notes: '' },
            { id: 11, date: '2024-07-22', employeeId: 3, employeeName: 'Joko Susilo', checkIn: '08:10', checkOut: '17:00', status: 'Terlambat', notes: 'Terlambat 10 menit' },
            { id: 12, date: '2024-07-22', employeeId: 4, employeeName: 'Ahmad Fauzi', checkIn: '07:58', checkOut: '17:02', status: 'Hadir', notes: '' },
            { id: 13, date: '2024-07-23', employeeId: 1, employeeName: 'Budi Santoso', checkIn: '07:50', checkOut: '17:10', status: 'Hadir', notes: '' },
            { id: 14, date: '2024-07-23', employeeId: 2, employeeName: 'Siti Aminah', checkIn: '08:05', checkOut: '16:55', status: 'Terlambat', notes: 'Pulang lebih awal' },
            { id: 15, date: '2024-07-23', employeeId: 3, employeeName: 'Joko Susilo', checkIn: '07:59', checkOut: '17:01', status: 'Hadir', notes: '' },
            { id: 16, date: '2024-07-23', employeeId: 4, employeeName: 'Ahmad Fauzi', checkIn: '08:00', checkOut: '17:00', status: 'Hadir', notes: '' },
            { id: 17, date: '2024-07-24', employeeId: 1, employeeName: 'Budi Santoso', checkIn: '07:55', checkOut: '17:05', status: 'Hadir', notes: '' },
            { id: 18, date: '2024-07-24', employeeId: 2, employeeName: 'Siti Aminah', checkIn: '08:00', checkOut: '17:00', status: 'Hadir', notes: '' },
            { id: 19, date: '2024-07-24', employeeId: 3, employeeName: 'Joko Susilo', checkIn: '08:10', checkOut: '17:00', status: 'Terlambat', notes: 'Terlambat 10 menit' },
            { id: 20, date: '2024-07-24', employeeId: 4, employeeName: 'Ahmad Fauzi', checkIn: '07:58', checkOut: '17:02', status: 'Hadir', notes: '' }
        ];
        let nextAttendanceId = attendanceRecords.length > 0 ? Math.max(...attendanceRecords.map(a => a.id)) + 1 : 1;

        // Dummy Leave/Sick Requests
        let leaveRequests = [
            { id: 1, employeeId: 4, employeeName: 'Ahmad Fauzi', type: 'izin', startDate: '2024-07-25', endDate: '2024-07-25', reason: 'Acara keluarga', status: 'Pending', attachment: null },
            { id: 2, employeeId: 2, employeeName: 'Siti Aminah', type: 'sakit', startDate: '2024-07-26', endDate: '2024-07-27', reason: 'Demam tinggi', status: 'Pending', attachment: 'surat_dokter_siti.pdf' },
            { id: 3, employeeId: 1, employeeName: 'Budi Santoso', type: 'cuti', startDate: '2024-08-01', endDate: '2024-08-05', reason: 'Liburan tahunan', status: 'Approved', attachment: null },
            { id: 4, employeeId: 4, employeeName: 'Ahmad Fauzi', type: 'izin', startDate: '2024-07-18', endDate: '2024-07-18', reason: 'Mengantar orang tua ke rumah sakit', status: 'Approved', attachment: null }
        ];
        let nextLeaveRequestId = leaveRequests.length > 0 ? Math.max(...leaveRequests.map(lr => lr.id)) + 1 : 1;


        // --- DOM Elements ---
        // Login Page Elements
        const loginPage = document.getElementById('login-page');
        const loginForm = document.getElementById('login-form');
        const loginError = document.getElementById('login-error');

        // Main App Layout Elements
        const mainApp = document.getElementById('main-app');
        const logoutBtn = document.getElementById('logout-btn');
        const navLinks = document.querySelectorAll('.tabler-nav-link[data-page]');
        const pageTitle = document.getElementById('page-title');
        const userDisplayName = document.getElementById('user-display-name');
        const adminMenuItems = document.getElementById('admin-menu-items'); // This is the <li> for admin menu items

        // Hamburger menu elements
        const hamburgerMenuBtn = document.getElementById('hamburger-menu-btn');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebar = document.querySelector('.sidebar');

        // Dashboard Page Elements
        const totalEmployeesCard = document.getElementById('total-employees-card'); // New: for hiding/showing
        const totalEmployeesSpan = document.getElementById('total-employees');
        const absentTodaySpan = document.getElementById('absent-today');
        const leaveSickTodaySpan = document.getElementById('leave-sick-today');
        const monthlyAttendanceChartCanvas = document.getElementById('monthly-attendance-chart');
        const pendingLeaveCard = document.getElementById('pending-leave-card'); // New dashboard card
        const pendingLeaveCountSpan = document.getElementById('pending-leave-count'); // New dashboard element

        // Absensi Page Elements
        const cameraFeed = document.getElementById('camera-feed');
        const photoCanvas = document.getElementById('photo-canvas');
        const capturePhotoBtn = document.getElementById('capture-photo-btn');
        const retakePhotoBtn = document.getElementById('retake-photo-btn');
        const faceRecognitionStatus = document.getElementById('face-recognition-status');
        const mapContainer = document.getElementById('map-container');
        const googleMapIframe = document.getElementById('google-map-iframe');
        const currentLocationSpan = document.getElementById('current-location');
        const distanceToOfficeSpan = document.getElementById('distance-to-office');
        const getLocationBtn = document.getElementById('get-location-btn');
        const locationStatus = document.getElementById('location-status');
        const checkInBtn = document.getElementById('check-in-btn');
        const checkOutBtn = document.getElementById('check-out-btn');
        const displayCheckinTime = document.getElementById('display-checkin-time'); // New element
        const displayCheckoutTime = document.getElementById('display-checkout-time'); // New element

        // Data Karyawan Page Elements
        const addEmployeeBtn = document.getElementById('add-employee-btn');
        const employeeListBody = document.getElementById('employee-list-body');

        // Master Data Page Elements
        const newPositionNameInput = document.getElementById('new-position-name');
        const addPositionBtn = document.getElementById('add-position-btn');
        const positionListUl = document.getElementById('position-list');
        const newLocationNameInput = document.getElementById('new-location-name');
        const newLocationLatInput = document.getElementById('new-location-lat');
        const newLocationLonInput = document.getElementById('new-location-lon');
        const newLocationRadiusInput = document.getElementById('new-location-radius');
        const addLocationBtn = document.getElementById('add-location-btn');
        const locationListUl = document.getElementById('location-list');
        const officeCheckinTimeInput = document.getElementById('office-checkin-time-input'); // New time input
        const officeCheckoutTimeInput = document.getElementById('office-checkout-time-input'); // New time input
        const saveOfficeHoursBtn = document.getElementById('save-office-hours-btn'); // New save button


        // Calendar Page Elements
        const prevMonthBtn = document.getElementById('prev-month-btn');
        const nextMonthBtn = document.getElementById('next-month-btn');
        const currentMonthYear = document.getElementById('current-month-year');
        const calendarDaysContainer = document.getElementById('calendar-days-container');
        const addAgendaSection = document.getElementById('add-agenda-section');
        const agendaDateInput = document.getElementById('agenda-date');
        const agendaTitleInput = document.getElementById('agenda-title');
        const addAgendaBtn = document.getElementById('add-agenda-btn');
        const agendaList = document.getElementById('agenda-list');

        // Izin/Sakit Page Elements
        const employeeIzinSakitView = document.getElementById('employee-izin-sakit-view');
        const adminIzinSakitView = document.getElementById('admin-izin-sakit-view');
        const izinSakitForm = document.getElementById('izin-sakit-form');
        const employeeLeaveListBody = document.getElementById('employee-leave-list-body');
        const adminLeaveListBody = document.getElementById('admin-leave-list-body');

        // Rekap Absen Page Elements
        const rekapAbsenTitle = document.getElementById('rekap-absen-title');
        const viewDailyRekapBtn = document.getElementById('view-daily-rekap-btn');
        const viewMonthlyRekapBtn = document.getElementById('view-monthly-rekap-btn');

        const dailyRekapFilters = document.getElementById('daily-rekap-filters');
        const filterEmployeeDailySelect = document.getElementById('filter-employee-daily');
        const filterStartDateDailyInput = document.getElementById('filter-start-date-daily');
        const filterEndDateDailyInput = document.getElementById('filter-end-date-daily');

        const monthlyRekapFilters = document.getElementById('monthly-rekap-filters');
        const filterEmployeeMonthlySelect = document.getElementById('filter-employee-monthly');
        const filterMonthMonthlySelect = document.getElementById('filter-month-monthly');
        const filterYearMonthlySelect = document.getElementById('filter-year-monthly');


        const applyFilterBtn = document.getElementById('apply-filter-btn');
        const resetFilterBtn = document.getElementById('reset-filter-btn');
        const exportRekapBtn = document.getElementById('export-rekap-btn'); // New export button
        const rekapAbsenTableHeaders = document.getElementById('rekap-absen-table-headers'); // New: for dynamic headers
        const rekapAbsenListBody = document.getElementById('rekap-absen-list-body');

        // Custom Modal Elements
        const customModal = document.getElementById('custom-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modal-message');
        const modalOkBtn = document.getElementById('modal-ok-btn');
        const modalCloseBtn = document.querySelector('.modal-close-btn');

        // Employee Input Modal Elements
        const employeeInputModal = document.getElementById('employee-input-modal');
        const closeEmployeeModalBtn = document.getElementById('close-employee-modal');
        const employeeModalTitle = document.getElementById('employee-modal-title');
        const employeeForm = document.getElementById('employee-form');
        const employeeNameInput = document.getElementById('employee-name');
        const employeePositionInput = document.getElementById('employee-position');
        const employeeEmailInput = document.getElementById('employee-email');
        const employeeUsernameInput = document.getElementById('employee-username'); // New username input
        const employeePasswordInput = document.getElementById('employee-password'); // New password input
        const employeeCameraFeed = document.getElementById('employee-camera-feed');
        const employeePhotoCanvas = document.getElementById('employee-photo-canvas');
        const employeePhotoPreview = document.getElementById('employee-photo-preview');
        const captureEmployeePhotoBtn = document.getElementById('capture-employee-photo-btn');
        const retakeEmployeePhotoBtn = document.getElementById('retake-employee-photo-btn');
        const uploadEmployeePhotoInput = document.getElementById('upload-employee-photo-input');
        let editingEmployeeId = null; // To store the ID of the employee being edited

        // Confirmation Modal Elements
        const confirmationModal = document.getElementById('confirmation-modal');
        const closeConfirmationModalBtn = document.getElementById('close-confirmation-modal');
        const confirmationModalTitle = document.getElementById('confirmation-modal-title');
        const confirmationModalMessage = document.getElementById('confirmation-modal-message');
        const confirmCancelBtn = document.getElementById('confirm-cancel-btn');
        const confirmOkBtn = document.getElementById('confirm-ok-btn');
        let confirmCallback = null; // Function to call when OK is clicked

        // Edit Position Modal Elements
        const editPositionModal = document.getElementById('edit-position-modal');
        const closePositionModalBtn = document.getElementById('close-position-modal');
        const editPositionForm = document.getElementById('edit-position-form');
        const editPositionNameInput = document.getElementById('edit-position-name');
        let editingPositionIndex = null;

        // Edit Location Modal Elements
        const editLocationModal = document.getElementById('edit-location-modal');
        const closeLocationModalBtn = document.getElementById('close-location-modal');
        const editLocationForm = document.getElementById('edit-location-form');
        const editLocationNameInput = document.getElementById('edit-location-name');
        const editLocationLatInput = document.getElementById('edit-location-lat');
        const editLocationLonInput = document.getElementById('edit-location-lon');
        const editLocationRadiusInput = document.getElementById('edit-location-radius');
        let editingLocationId = null;


        // --- Utility Functions ---

        /**
         * Menampilkan modal kustom dengan judul dan pesan.
         * @param {string} title - Judul modal.
         * @param {string} message - Pesan yang akan ditampilkan.
         */
        function showModal(title, message) {
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            customModal.style.display = 'flex'; // Menggunakan flex untuk memusatkan modal
        }

        /**
         * Menyembunyikan modal kustom.
         */
        function hideModal() {
            customModal.style.display = 'none';
        }

        /**
         * Menampilkan modal input karyawan.
         * @param {object|null} employee - Objek karyawan jika dalam mode edit, null jika tambah baru.
         */
        async function showEmployeeInputModal(employee = null) {
            employeeForm.reset();
            employeePhotoTaken = false;
            employeePhotoPreview.classList.add('hidden');
            employeePhotoCanvas.classList.add('hidden');
            captureEmployeePhotoBtn.classList.remove('hidden');
            retakeEmployeePhotoBtn.classList.add('hidden');
            uploadEmployeePhotoInput.value = ''; // Clear file input

            if (employee) {
                employeeModalTitle.textContent = 'Edit Karyawan';
                employeeNameInput.value = employee.name;
                employeePositionInput.value = employee.position;
                employeeEmailInput.value = employee.email;
                employeeUsernameInput.value = employee.username;
                employeePasswordInput.value = employee.password; // Populate password for editing
                editingEmployeeId = employee.id;
                if (employee.photoData) {
                    employeePhotoPreview.src = employee.photoData;
                    employeePhotoPreview.classList.remove('hidden');
                    captureEmployeePhotoBtn.classList.add('hidden');
                    retakeEmployeePhotoBtn.classList.remove('hidden');
                    employeePhotoTaken = true;
                }
            } else {
                employeeModalTitle.textContent = 'Tambah Karyawan Baru';
                editingEmployeeId = null;
            }

            // Start camera for employee photo input
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                employeeCameraFeed.srcObject = stream;
                employeePhotoStream = stream;
                employeeCameraFeed.classList.remove('hidden');
            } catch (err) {
                console.error("Error accessing camera for employee photo: ", err);
                showModal('Error Kamera', 'Tidak dapat mengakses kamera untuk input foto karyawan.');
                employeeCameraFeed.classList.add('hidden'); // Hide camera if not accessible
                captureEmployeePhotoBtn.classList.add('hidden'); // Hide capture button
            }

            employeeInputModal.style.display = 'flex';
        }

        /**
         * Menyembunyikan modal input karyawan.
         */
        function hideEmployeeInputModal() {
            employeeInputModal.style.display = 'none';
            editingEmployeeId = null;
            if (employeePhotoStream) {
                employeePhotoStream.getTracks().forEach(track => track.stop());
                employeeCameraFeed.srcObject = null;
                employeePhotoStream = null;
            }
        }

        /**
         * Menampilkan modal konfirmasi.
         * @param {string} title - Judul modal.
         * @param {string} message - Pesan konfirmasi.
         * @param {Function} callback - Fungsi yang akan dipanggil jika OK diklik.
         */
        function showConfirmationModal(title, message, callback) {
            confirmationModalTitle.textContent = title;
            confirmationModalMessage.textContent = message;
            confirmCallback = callback;
            confirmationModal.style.display = 'flex';
        }

        /**
         * Menyembunyikan modal konfirmasi.
         */
        function hideConfirmationModal() {
            confirmationModal.style.display = 'none';
            confirmCallback = null;
        }

        /**
         * Menampilkan modal edit jabatan.
         * @param {string} positionName - Nama jabatan yang akan diedit.
         * @param {number} index - Indeks jabatan dalam array.
         */
        function showEditPositionModal(positionName, index) {
            editPositionNameInput.value = positionName;
            editingPositionIndex = index;
            editPositionModal.style.display = 'flex';
        }

        /**
         * Menyembunyikan modal edit jabatan.
         */
        function hideEditPositionModal() {
            editPositionModal.style.display = 'none';
            editingPositionIndex = null;
        }

        /**
         * Menampilkan modal edit lokasi.
         * @param {object} location - Objek lokasi yang akan diedit.
         */
        function showEditLocationModal(location) {
            editLocationNameInput.value = location.name;
            editLocationLatInput.value = location.lat;
            editLocationLonInput.value = location.lon;
            editLocationRadiusInput.value = location.radius;
            editingLocationId = location.id;
            editLocationModal.style.display = 'flex';
        }

        /**
         * Menyembunyikan modal edit lokasi.
         */
        function hideEditLocationModal() {
            editLocationModal.style.display = 'none';
            editingLocationId = null;
        }

        /**
         * Mengaktifkan atau menonaktifkan visibilitas sidebar untuk perangkat seluler.
         */
        function toggleSidebar() {
            mainApp.classList.toggle('sidebar-open');
        }

        /**
         * Mengganti konten halaman yang aktif.
         * @param {string} pageId - ID dari div konten halaman yang akan ditampilkan.
         */
        function showPage(pageId) {
            if (!currentUser) {
                showModal('Akses Ditolak', 'Anda harus login untuk mengakses halaman ini.');
                return;
            }

            // Role-based access control
            if (currentUser.role === 'employee') {
                if (['data-karyawan', 'master-data'].includes(pageId)) {
                    showModal('Akses Ditolak', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
                    showPage('dashboard'); // Redirect to dashboard
                    return;
                }
            } else if (currentUser.role === 'admin') {
                if (['absensi'].includes(pageId)) {
                     showModal('Akses Ditolak', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
                     showPage('dashboard'); // Redirect to dashboard
                     return;
                }
            }

            // Hide all page contents
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.add('hidden');
            });
            // Show the requested page
            document.getElementById(`${pageId}-page`).classList.remove('hidden');
            pageTitle.textContent = document.querySelector(`[data-page="${pageId}"] span`).textContent;

            // Update active navigation link
            navLinks.forEach(link => {
                if (link.dataset.page === pageId) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            currentView = pageId; // Perbarui status tampilan saat ini

            // Tutup sidebar di perangkat seluler setelah navigasi
            if (window.innerWidth < 768) {
                toggleSidebar();
            }

            // Aksi spesifik saat navigasi ke halaman tertentu
            if (pageId === 'dashboard') {
                updateDashboardStats();
                renderMonthlyAttendanceChart();
                // Show/hide pending leave card based on admin role
                if (currentUser.role === 'admin') {
                    pendingLeaveCard.classList.remove('hidden');
                } else {
                    pendingLeaveCard.classList.add('hidden');
                }
            } else {
                // Destroy chart instance when leaving dashboard
                if (monthlyAttendanceChart) {
                    monthlyAttendanceChart.destroy();
                    monthlyAttendanceChart = null;
                }
            }
            if (pageId === 'absensi') {
                startCamera();
                updateAbsensiButtonState();
                displayCheckinTime.textContent = officeCheckInTime; // Update displayed time
                displayCheckoutTime.textContent = officeCheckOutTime; // Update displayed time
            } else {
                stopCamera(); // Hentikan kamera saat meninggalkan halaman absensi
            }
            if (pageId === 'kalender') {
                renderCalendar(currentCalendarDate);
                renderAgendaList();
                // Hide agenda input section for non-admin users
                if (addAgendaSection) { // Ensure addAgendaSection is not null
                    if (currentUser.role !== 'admin') {
                        addAgendaSection.classList.add('hidden');
                    } else {
                        addAgendaSection.classList.remove('hidden');
                    }
                }
            }
            if (pageId === 'data-karyawan') {
                renderEmployeesTable();
                updateDashboardStats(); // Update total employees count
            }
            if (pageId === 'master-data') {
                renderPositionsList();
                renderLocationsList();
                // Set initial values for time inputs
                officeCheckinTimeInput.value = officeCheckInTime;
                officeCheckoutTimeInput.value = officeCheckOutTime;
            }
            if (pageId === 'izin-sakit') {
                if (currentUser.role === 'admin') {
                    employeeIzinSakitView.classList.add('hidden');
                    adminIzinSakitView.classList.remove('hidden');
                    renderAdminLeaveRequests();
                } else {
                    employeeIzinSakitView.classList.remove('hidden');
                    adminIzinSakitView.classList.add('hidden');
                    renderEmployeeLeaveRequests();
                }
            }
            if (pageId === 'rekap-absen') {
                populateFilterEmployeeSelects(); // Call the new function
                switchRekapAbsenView(currentRekapAbsenView); // Render the current view
            }
        }

        /**
         * Memperbarui visibilitas item navigasi berdasarkan peran pengguna.
         */
        function updateNavigationVisibility() {
            document.querySelectorAll('[data-role-visibility]').forEach(item => {
                const requiredRole = item.dataset.roleVisibility;
                if (currentUser && (currentUser.role === requiredRole || requiredRole === undefined)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
            // Handle admin menu items li specifically
            if (currentUser && currentUser.role === 'admin') {
                adminMenuItems.classList.remove('hidden');
            } else {
                adminMenuItems.classList.add('hidden');
            }
        }

        // --- Dashboard Logic ---
        function updateDashboardStats() {
            const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD

            if (currentUser.role === 'admin') {
                totalEmployeesCard.classList.remove('hidden');
                const nonAdminEmployees = employees.filter(emp => emp.role !== 'admin');
                totalEmployeesSpan.textContent = nonAdminEmployees.length;

                const presentCount = attendanceRecords.filter(rec => rec.date === today && rec.status === 'Hadir').length;
                absentTodaySpan.textContent = presentCount;

                const pendingLeaveCount = leaveRequests.filter(req =>
                    req.status === 'Pending' &&
                    new Date(req.startDate) <= new Date(today) &&
                    new Date(req.endDate) >= new Date(today)
                ).length;
                leaveSickTodaySpan.textContent = pendingLeaveCount;
                pendingLeaveCountSpan.textContent = pendingLeaveCount;
                pendingLeaveCard.classList.remove('hidden');
            } else { // Employee role
                totalEmployeesCard.classList.add('hidden'); // Hide total employees for employee
                pendingLeaveCard.classList.add('hidden'); // Hide pending leave card for employee

                const employeeAttendance = attendanceRecords.find(rec => rec.employeeId === currentUser.id && rec.date === today);
                if (employeeAttendance && employeeAttendance.checkIn) {
                    absentTodaySpan.textContent = '1'; // User checked in
                } else {
                    absentTodaySpan.textContent = '0'; // User not checked in
                }

                const employeeLeave = leaveRequests.some(req =>
                    req.employeeId === currentUser.id &&
                    req.status === 'Approved' && // Only count approved leaves/sick for personal dashboard
                    new Date(req.startDate) <= new Date(today) &&
                    new Date(req.endDate) >= new Date(today)
                );
                leaveSickTodaySpan.textContent = employeeLeave ? '1' : '0';
            }
        }

        function generateMonthlyAttendanceData() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const currentMonthIndex = new Date().getMonth();
            const labels = [];
            const hadirData = [];
            const terlambatData = [];
            const izinSakitData = [];

            // Get data for the last 6 months including current
            for (let i = 5; i >= 0; i--) {
                const monthDate = new Date();
                monthDate.setMonth(currentMonthIndex - i);
                const yearMonth = monthDate.toISOString().slice(0, 7); // YYYY-MM

                labels.push(months[monthDate.getMonth()]);

                let monthHadir = 0;
                let monthTerlambat = 0;
                let monthIzinSakit = 0;

                // Filter attendance records for the current user if employee, else all users
                const recordsToConsider = currentUser.role === 'employee'
                    ? attendanceRecords.filter(rec => rec.employeeId === currentUser.id && rec.date.startsWith(yearMonth))
                    : attendanceRecords.filter(rec => rec.date.startsWith(yearMonth));

                recordsToConsider.forEach(rec => {
                    if (rec.status === 'Hadir') {
                        monthHadir++;
                    } else if (rec.status === 'Terlambat') {
                        monthTerlambat++;
                    }
                    // Count approved leave/sick requests for the month
                    const leaveForMonth = leaveRequests.some(req =>
                        req.employeeId === rec.employeeId &&
                        req.status === 'Approved' &&
                        new Date(req.startDate).toISOString().slice(0, 7) <= yearMonth &&
                        new Date(req.endDate).toISOString().slice(0, 7) >= yearMonth
                    );
                    if (leaveForMonth) {
                        monthIzinSakit++;
                    }
                });

                hadirData.push(monthHadir);
                terlambatData.push(monthTerlambat);
                izinSakitData.push(monthIzinSakit);
            }
            return { labels, hadirData, terlambatData, izinSakitData };
        }


        function renderMonthlyAttendanceChart() {
            if (monthlyAttendanceChart) {
                monthlyAttendanceChart.destroy(); // Destroy existing chart instance
            }

            const ctx = monthlyAttendanceChartCanvas.getContext('2d');
            const { labels, hadirData, terlambatData, izinSakitData } = generateMonthlyAttendanceData();

            monthlyAttendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Hadir',
                            data: hadirData,
                            backgroundColor: '#206bc4', // Primary blue
                            borderColor: '#206bc4',
                            borderWidth: 1
                        },
                        {
                            label: 'Terlambat',
                            data: terlambatData,
                            backgroundColor: '#f7941d', // Orange
                            borderColor: '#f7941d',
                            borderWidth: 1
                        },
                        {
                            label: 'Izin/Sakit',
                            data: izinSakitData,
                            backgroundColor: '#dc3545', // Red
                            borderColor: '#dc3545',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Karyawan'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Statistik Absensi Bulanan'
                        }
                    }
                }
            });
        }


        // --- Login/Logout Logic ---

        /**
         * Menangani proses login pengguna.
         * @param {Event} event - Event pengiriman formulir.
         */
        function handleLogin(event) {
            event.preventDefault();
            const usernameInput = document.getElementById('username').value;
            const passwordInput = document.getElementById('password').value;

            const foundUser = employees.find(emp => emp.username === usernameInput && emp.password === passwordInput);

            if (foundUser) {
                currentUser = {
                    id: foundUser.id,
                    username: foundUser.name, // Use name for display
                    role: foundUser.role
                };
                loginError.classList.add('hidden');
                loginPage.classList.add('hidden');
                mainApp.classList.remove('hidden');
                userDisplayName.textContent = currentUser.username;
                updateNavigationVisibility(); // Update navigation based on role
                showPage('dashboard'); // Halaman default setelah login
            } else {
                loginError.classList.remove('hidden');
            }
        }

        /**
         * Menangani proses logout pengguna.
         */
        function handleLogout(event) {
            event.preventDefault();
            currentUser = null;
            loginPage.classList.remove('hidden');
            mainApp.classList.add('hidden');
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
            loginError.classList.add('hidden');
            stopCamera(); // Pastikan kamera dihentikan saat logout
            updateNavigationVisibility(); // Reset navigation visibility
            showModal('Logout Berhasil', 'Anda telah berhasil logout dari aplikasi.');
        }

        // --- Absensi Page Logic ---

        /**
         * Memulai feed kamera.
         */
        async function startCamera() {
            if (cameraStream) return; // Kamera sudah berjalan
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                cameraFeed.srcObject = stream;
                cameraStream = stream;
                cameraFeed.classList.remove('hidden');
                photoCanvas.classList.add('hidden');
                capturePhotoBtn.classList.remove('hidden');
                retakePhotoBtn.classList.add('hidden');
                photoTaken = false;
                faceRecognitionStatus.textContent = 'Status Pengenalan Wajah: Kamera aktif.';
                updateAbsensiButtonState();
            } catch (err) {
                console.error("Error accessing camera: ", err);
                let errorMessage = 'Tidak dapat mengakses kamera. Pastikan browser Anda mengizinkan akses kamera dan tidak ada aplikasi lain yang menggunakannya.';
                if (err.name === 'NotAllowedError') {
                    errorMessage = 'Akses kamera ditolak. Harap izinkan akses kamera di pengaturan browser Anda.';
                } else if (err.name === 'NotFoundError') {
                    errorMessage = 'Tidak ada kamera yang ditemukan di perangkat Anda.';
                } else if (err.name === 'NotReadableError') {
                    errorMessage = 'Kamera sedang digunakan oleh aplikasi lain atau tidak dapat diakses.';
                } else if (err.name === 'OverconstrainedError') {
                    errorMessage = 'Kamera tidak dapat memenuhi batasan yang diminta (misalnya, resolusi).';
                } else if (err.name === 'AbortError' || err.name === 'TimeoutError') {
                    errorMessage = 'Akses kamera memakan waktu terlalu lama atau dibatalkan.';
                }
                showModal('Error Kamera', errorMessage);
                faceRecognitionStatus.textContent = `Status Pengenalan Wajah: Gagal mengakses kamera. (${err.name})`;
            }
        }

        /**
         * Menghentikan feed kamera.
         */
        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraFeed.srcObject = null;
                cameraStream = null;
            }
        }

        /**
         * Mengambil foto dari feed kamera dan mensimulasikan pengenalan wajah.
         */
        function capturePhoto() {
            if (!cameraStream) {
                showModal('Error', 'Kamera belum aktif.');
                return;
            }
            const context = photoCanvas.getContext('2d');
            photoCanvas.width = cameraFeed.videoWidth;
            photoCanvas.height = cameraFeed.videoHeight;
            context.drawImage(cameraFeed, 0, 0, photoCanvas.width, photoCanvas.height);

            cameraFeed.classList.add('hidden');
            photoCanvas.classList.remove('hidden');
            capturePhotoBtn.classList.add('hidden');
            retakePhotoBtn.classList.remove('hidden');
            photoTaken = true;
            faceRecognitionStatus.textContent = 'Status Pengenalan Wajah: Foto diambil. Memproses...';

            // Simulate face recognition process
            setTimeout(() => {
                let statusMessage = '';
                let isFaceRecognized = Math.random() > 0.2; // 80% chance of general face detection success

                if (isFaceRecognized) {
                    statusMessage = 'Wajah terdeteksi. ';
                    if (currentUser && currentUser.role === 'employee') {
                        // Simulate face matching against stored employee photo
                        const employeeData = employees.find(emp => emp.id === currentUser.id);
                        if (employeeData && employeeData.photoData) {
                            const isMatch = Math.random() > 0.3; // 70% chance of matching if photo exists
                            if (isMatch) {
                                statusMessage += 'Wajah cocok dengan data karyawan!';
                                isFaceRecognized = true; // Overall success
                            } else {
                                statusMessage += 'Wajah tidak cocok dengan data karyawan. Coba lagi.';
                                isFaceRecognized = false; // Overall failure
                            }
                        } else {
                            statusMessage += 'Tidak ada foto karyawan yang tersimpan untuk pencocokan. Harap hubungi admin.';
                            isFaceRecognized = false; // Cannot match if no photo
                        }
                    } else {
                        // For admin or other roles, just general detection
                        statusMessage += 'Wajah dikenali (mode demo).';
                    }
                } else {
                    statusMessage = 'Wajah tidak terdeteksi. Coba lagi.';
                }

                faceRecognitionStatus.textContent = `Status Pengenalan Wajah: ${statusMessage}`;
                photoTaken = isFaceRecognized; // Only set photoTaken to true if face is recognized AND matched
                if (!isFaceRecognized) {
                    retakePhotoBtn.click(); // Automatically prompt to retake if not recognized/matched
                }
                updateAbsensiButtonState();
            }, 2000); // Simulate processing time
        }

        /**
         * Mengambil ulang foto.
         */
        function retakePhoto() {
            photoCanvas.classList.add('hidden');
            cameraFeed.classList.remove('hidden');
            capturePhotoBtn.classList.remove('hidden');
            retakePhotoBtn.classList.add('hidden');
            photoTaken = false;
            faceRecognitionStatus.textContent = 'Status Pengenalan Wajah: Menunggu...';
            updateAbsensiButtonState();
        }

        /**
         * Menghitung jarak antara dua titik geografis menggunakan rumus Haversine.
         * @param {number} lat1 - Latitude titik 1.
         * @param {number} lon1 - Longitude titik 1.
         * @param {number} lat2 - Latitude titik 2.
         * @param {number} lon2 - Longitude titik 2.
         * @returns {number} Jarak dalam meter.
         */
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // meter
            const φ1 = lat1 * Math.PI / 180; // φ, λ dalam radian
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const d = R * c; // dalam meter
            return d;
        }

        /**
         * Mendapatkan lokasi GPS saat ini.
         *
         * Catatan: Kesalahan dalam mendapatkan lokasi (geolocation) sering terjadi karena:
         * 1. Pengguna menolak izin lokasi.
         * 2. Browser berjalan di lingkungan yang tidak aman (HTTP, bukan HTTPS).
         * 3. Pengaturan browser memblokir lokasi.
         * 4. Perangkat tidak memiliki GPS atau GPS dinonaktifkan.
         * 5. Masalah koneksi jaringan atau sinyal GPS yang lemah.
         */
        function getLocation() {
            locationStatus.textContent = 'Status GPS: Mencari lokasi...';
            distanceToOfficeSpan.textContent = 'Menghitung...';
            locationObtained = false; // Reset status
            updateAbsensiButtonState(); // Update buttons immediately

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userCurrentLat = position.coords.latitude;
                        userCurrentLon = position.coords.longitude;
                        currentLocationSpan.textContent = `Lat: ${userCurrentLat.toFixed(6)}, Lon: ${userCurrentLon.toFixed(6)}`;
                        
                        const distance = calculateDistance(userCurrentLat, userCurrentLon, companyLatitude, companyLongitude);
                        distanceToOfficeSpan.textContent = `${distance.toFixed(2)} meter`;

                        if (distance <= attendanceRadius) {
                            locationStatus.textContent = 'Status GPS: Lokasi ditemukan. (Berada dalam radius kantor)';
                            locationStatus.style.color = 'green';
                            locationObtained = true; // Lokasi valid
                        } else {
                            locationStatus.textContent = 'Status GPS: Lokasi ditemukan. (DI LUAR radius kantor)';
                            locationStatus.style.color = 'red';
                            locationObtained = false; // Lokasi tidak valid
                            showModal('Peringatan Lokasi', 'Anda berada di luar radius kantor. Absensi tidak dapat dilakukan.');
                        }

                        updateAbsensiButtonState();

                        // Perbarui iframe Google Map dengan lokasi saat ini dan lokasi perusahaan
                        // PENTING: Anda memerlukan Google Maps API Key yang valid untuk peta yang berfungsi penuh.
                        // Ganti 'YOUR_API_KEY' dengan Google Maps API Key Anda.
                        // Untuk demonstrasi, kita akan menggunakan peta statis atau embed dasar.
                        const apiKey = ''; // Biarkan kosong jika tidak ada API key yang valid
                        const mapUrl = `https://www.google.com/maps/embed/v1/directions?key=${apiKey}&origin=${userCurrentLat},${userCurrentLon}&destination=${companyLatitude},${companyLongitude}&mode=walking`;
                        // Atau hanya tampilkan lokasi saat ini:
                        // const mapUrl = `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=${userCurrentLat},${userCurrentLon}&zoom=15&maptype=roadmap`;
                        googleMapIframe.src = mapUrl;
                        mapContainer.classList.remove('text-gray-400', 'items-center', 'justify-center');
                    },
                    (error) => {
                        // Log error details for debugging
                        console.error("Error getting location: ", error);
                        console.error("Error code: ", error.code);
                        console.error("Error message: ", error.message);

                        let errorMessage = '';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = 'Akses lokasi ditolak. Harap izinkan akses lokasi di pengaturan browser Anda.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage = 'Permintaan untuk mendapatkan lokasi pengguna habis waktu.';
                                break;
                            case error.UNKNOWN_ERROR:
                                errorMessage = 'Terjadi kesalahan tidak dikenal saat mendapatkan lokasi.';
                                break;
                            default:
                                errorMessage = 'Tidak dapat mendapatkan lokasi Anda. Pastikan layanan lokasi diaktifkan dan diizinkan oleh browser.';
                        }
                        locationStatus.textContent = 'Status GPS: Gagal mendapatkan lokasi. ' + errorMessage;
                        locationStatus.style.color = 'red';
                        showModal('Error GPS', errorMessage);
                        locationObtained = false;
                        updateAbsensiButtonState();
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                locationStatus.textContent = 'Status GPS: Geolocation tidak didukung oleh browser ini.';
                locationStatus.style.color = 'red';
                showModal('Error', 'Browser Anda tidak mendukung Geolocation.');
                locationObtained = false;
                updateAbsensiButtonState();
            }
        }

        /**
         * Memperbarui status tombol Check-in/Check-out.
         */
        function updateAbsensiButtonState() {
            const isFaceRecognizedAndMatched = photoTaken && faceRecognitionStatus.textContent.includes('Wajah cocok'); // Check for specific success message
            // `locationObtained` now directly reflects if location is valid AND within radius
            const isLocationValid = locationObtained; 

            checkInBtn.disabled = !(isFaceRecognizedAndMatched && isLocationValid);
            checkOutBtn.disabled = !(isFaceRecognizedAndMatched && isLocationValid);
        }

        /**
         * Menangani aksi Check-in.
         */
        function handleCheckIn() {
            const now = new Date();
            const todayDateString = now.toISOString().slice(0, 10);
            const currentTimeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            const currentTimeMinutes = now.getHours() * 60 + now.getMinutes();
            const checkInMinutes = parseTime(officeCheckInTime);

            if (!photoTaken || !locationObtained || !faceRecognitionStatus.textContent.includes('Wajah cocok')) {
                showModal('Peringatan', 'Harap ambil foto dan dapatkan lokasi terlebih dahulu, serta pastikan wajah dikenali dan cocok dengan data karyawan, dan berada di area kantor.');
                return;
            }

            // Check if already checked in today
            const alreadyCheckedIn = attendanceRecords.some(record =>
                record.employeeId === currentUser.id && record.date === todayDateString && record.checkIn
            );

            if (alreadyCheckedIn) {
                showModal('Peringatan', 'Anda sudah check-in hari ini.');
                return;
            }

            let status = 'Hadir';
            let notes = '';
            if (currentTimeMinutes > checkInMinutes + 15) { // Izinkan grace period 15 menit
                status = 'Terlambat';
                notes = `Terlambat ${formatMinutesToHoursMinutes(currentTimeMinutes - checkInMinutes)}`;
            }

            const newRecord = {
                id: nextAttendanceId++,
                date: todayDateString,
                employeeId: currentUser.id,
                employeeName: currentUser.username,
                checkIn: currentTimeString,
                checkOut: null,
                status: status,
                notes: notes
            };
            attendanceRecords.push(newRecord);
            showModal('Absensi Berhasil', `Check-in berhasil pada ${currentTimeString} di lokasi ${currentLocationSpan.textContent}. Status: ${status}.`);
            resetAbsensiState();
            updateDashboardStats(); // Update dashboard after check-in
        }

        /**
         * Menangani aksi Check-out.
         */
        function handleCheckOut() {
            const now = new Date();
            const todayDateString = now.toISOString().slice(0, 10);
            const currentTimeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            const currentTimeMinutes = now.getHours() * 60 + now.getMinutes();
            const checkOutMinutes = parseTime(officeCheckOutTime);

            if (!photoTaken || !locationObtained || !faceRecognitionStatus.textContent.includes('Wajah cocok')) {
                showModal('Peringatan', 'Harap ambil foto dan dapatkan lokasi terlebih dahulu, serta pastikan wajah dikenali dan cocok dengan data karyawan, dan berada di area kantor.');
                return;
            }

            // Find today's check-in record for the current user
            const todayRecordIndex = attendanceRecords.findIndex(record =>
                record.employeeId === currentUser.id && record.date === todayDateString && record.checkIn && !record.checkOut
            );

            if (todayRecordIndex === -1) {
                showModal('Peringatan', 'Anda belum check-in hari ini atau sudah check-out.');
                return;
            }

            let record = attendanceRecords[todayRecordIndex];
            record.checkOut = currentTimeString;

            if (currentTimeMinutes < checkOutMinutes - 15) { // Izinkan keberangkatan awal 15 menit
                record.notes += (record.notes ? '; ' : '') + `Pulang lebih awal ${formatMinutesToHoursMinutes(checkOutMinutes - currentTimeMinutes)}`;
                record.status = 'Pulang Awal'; // New status for early departure
            }

            showModal('Absensi Berhasil', `Check-out berhasil pada ${currentTimeString} di lokasi ${currentLocationSpan.textContent}.`);
            resetAbsensiState();
            updateDashboardStats(); // Update dashboard after check-out
        }

        /**
         * Mereset status halaman absensi setelah check-in/out berhasil.
         */
        function resetAbsensiState() {
            photoTaken = false;
            locationObtained = false;
            userCurrentLat = null;
            userCurrentLon = null;
            faceRecognitionStatus.textContent = 'Status Pengenalan Wajah: Menunggu...';
            currentLocationSpan.textContent = 'Mencari lokasi...';
            distanceToOfficeSpan.textContent = 'Menghitung...';
            locationStatus.textContent = 'Status GPS: Menunggu...';
            locationStatus.style.color = ''; // Reset warna
            googleMapIframe.src = ''; // Hapus peta
            mapContainer.classList.add('text-gray-400', 'items-center', 'justify-center');
            updateAbsensiButtonState();
            retakePhotoBtn.click(); // Kembali ke tampilan kamera
        }

        // --- Data Karyawan (Admin) Logic ---

        /**
         * Merender tabel karyawan.
         */
        function renderEmployeesTable() {
            employeeListBody.innerHTML = '';
            // Filter out the 'Admin User' from the employee list display
            const displayEmployees = employees.filter(emp => emp.role !== 'admin');

            if (displayEmployees.length === 0) {
                employeeListBody.innerHTML = '<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data karyawan.</td></tr>';
                return;
            }
            displayEmployees.forEach(emp => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                row.innerHTML = `
                    <td class="px-4 py-3">${emp.name}</td>
                    <td class="px-4 py-3">${emp.position}</td>
                    <td class="px-4 py-3">${emp.email}</td>
                    <td class="px-4 py-3">${emp.username}</td>
                    <td class="px-4 py-3">
                        ${emp.photoData ? `<img src="${emp.photoData}" alt="Foto" class="w-12 h-12 object-cover rounded-full">` : '<span class="text-gray-400">Tidak ada foto</span>'}
                    </td>
                    <td class="px-4 py-3">
                        <button class="text-blue-600 hover:text-blue-800 mr-2 edit-employee-btn" data-id="${emp.id}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800 delete-employee-btn" data-id="${emp.id}"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                employeeListBody.appendChild(row);
            });

            // Add event listeners for edit and delete buttons
            employeeListBody.querySelectorAll('.edit-employee-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    const employeeToEdit = employees.find(emp => emp.id === id);
                    if (employeeToEdit) {
                        showEmployeeInputModal(employeeToEdit);
                    }
                });
            });

            employeeListBody.querySelectorAll('.delete-employee-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    showConfirmationModal('Hapus Karyawan', 'Apakah Anda yakin ingin menghapus karyawan ini?', () => {
                        employees = employees.filter(emp => emp.id !== id);
                        // Also remove any attendance or leave records for this employee (for dummy data consistency)
                        attendanceRecords = attendanceRecords.filter(rec => rec.employeeId !== id);
                        leaveRequests = leaveRequests.filter(req => req.employeeId !== id);

                        renderEmployeesTable();
                        updateDashboardStats(); // Update count for displayed employees on dashboard
                        showModal('Sukses', 'Karyawan berhasil dihapus.');
                    });
                });
            });
            totalEmployeesSpan.textContent = displayEmployees.length; // Update count for displayed employees
        }

        /**
         * Mengambil foto karyawan dari feed kamera di modal.
         */
        function captureEmployeePhoto() {
            if (!employeePhotoStream) {
                showModal('Error', 'Kamera belum aktif untuk input foto karyawan.');
                return;
            }
            const context = employeePhotoCanvas.getContext('2d');
            employeePhotoCanvas.width = employeeCameraFeed.videoWidth;
            employeePhotoCanvas.height = employeeCameraFeed.videoHeight;
            context.drawImage(employeeCameraFeed, 0, 0, employeePhotoCanvas.width, employeePhotoCanvas.height);

            employeeCameraFeed.classList.add('hidden');
            employeePhotoCanvas.classList.remove('hidden');
            employeePhotoPreview.classList.add('hidden'); // Hide preview if canvas is shown
            captureEmployeePhotoBtn.classList.add('hidden');
            retakeEmployeePhotoBtn.classList.remove('hidden');
            employeePhotoTaken = true;
            uploadEmployeePhotoInput.value = ''; // Clear file input if photo is captured
        }

        /**
         * Mengambil ulang foto karyawan di modal.
         */
        function retakeEmployeePhoto() {
            employeePhotoCanvas.classList.add('hidden');
            employeePhotoPreview.classList.add('hidden');
            employeeCameraFeed.classList.remove('hidden');
            captureEmployeePhotoBtn.classList.remove('hidden');
            retakeEmployeePhotoBtn.classList.add('hidden');
            employeePhotoTaken = false;
            uploadEmployeePhotoInput.value = ''; // Clear file input
        }

        /**
         * Menangani unggahan foto karyawan dari file.
         * @param {Event} event - Event perubahan input file.
         */
        function uploadEmployeePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    employeePhotoPreview.src = e.target.result;
                    employeePhotoPreview.classList.remove('hidden');
                    employeePhotoCanvas.classList.add('hidden');
                    employeeCameraFeed.classList.add('hidden');
                    captureEmployeePhotoBtn.classList.add('hidden');
                    retakeEmployeePhotoBtn.classList.remove('hidden');
                    employeePhotoTaken = true;
                    if (employeePhotoStream) { // Stop camera if file is uploaded
                        employeePhotoStream.getTracks().forEach(track => track.stop());
                        employeeCameraFeed.srcObject = null;
                        employeePhotoStream = null;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        /**
         * Menangani penambahan atau pengeditan karyawan.
         * @param {Event} event - Event pengiriman formulir.
         */
        function handleEmployeeFormSubmit(event) {
            event.preventDefault();
            const name = employeeNameInput.value.trim();
            const position = employeePositionInput.value.trim();
            const email = employeeEmailInput.value.trim();
            const username = employeeUsernameInput.value.trim();
            const password = employeePasswordInput.value.trim();
            let photoData = null;

            if (employeePhotoTaken) {
                if (!employeePhotoCanvas.classList.contains('hidden')) {
                    photoData = employeePhotoCanvas.toDataURL('image/png');
                } else if (!employeePhotoPreview.classList.contains('hidden')) {
                    photoData = employeePhotoPreview.src;
                }
            }

            if (name && position && email && username && password) {
                // Check for duplicate username (excluding the current employee if editing)
                const isUsernameTaken = employees.some(emp => emp.username === username && emp.id !== editingEmployeeId);
                if (isUsernameTaken) {
                    showModal('Peringatan', 'Username sudah digunakan. Harap pilih username lain.');
                    return;
                }

                if (editingEmployeeId !== null) {
                    // Edit existing employee
                    employees = employees.map(emp =>
                        emp.id === editingEmployeeId ? { ...emp, name, position, email, username, password, photoData } : emp
                    );
                    // Update employee name in attendance and leave records if changed
                    attendanceRecords.forEach(rec => {
                        if (rec.employeeId === editingEmployeeId) rec.employeeName = name;
                    });
                    leaveRequests.forEach(req => {
                        if (req.employeeId === editingEmployeeId) req.employeeName = name;
                    });
                    showModal('Sukses', 'Data karyawan berhasil diperbarui.');
                } else {
                    // Add new employee
                    const newEmployee = { id: nextEmployeeId++, name, position, email, username, password, role: 'employee', photoData };
                    employees.push(newEmployee);
                    showModal('Sukses', 'Karyawan baru berhasil ditambahkan.');
                }
                renderEmployeesTable();
                hideEmployeeInputModal();
            } else {
                showModal('Peringatan', 'Harap lengkapi semua kolom (Nama, Jabatan, Email, Username, Password).');
            }
        }

        // --- Master Data (Admin) Logic ---

        /**
         * Merender daftar jabatan.
         */
        function renderPositionsList() {
            positionListUl.innerHTML = '';
            if (positions.length === 0) {
                positionListUl.innerHTML = '<li class="text-gray-500">Tidak ada data jabatan.</li>';
                return;
            }
            positions.forEach((pos, index) => {
                const li = document.createElement('li');
                li.classList.add('flex', 'justify-between', 'items-center', 'bg-gray-50', 'p-2', 'rounded-md');
                li.innerHTML = `
                    <span>${pos}</span>
                    <div>
                        <button class="text-blue-600 hover:text-blue-800 mr-2 edit-position-btn" data-index="${index}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800 delete-position-btn" data-index="${index}"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                positionListUl.appendChild(li);
            });

            positionListUl.querySelectorAll('.edit-position-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const index = parseInt(event.currentTarget.dataset.index);
                    showEditPositionModal(positions[index], index);
                });
            });

            positionListUl.querySelectorAll('.delete-position-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const index = parseInt(event.currentTarget.dataset.index);
                    showConfirmationModal('Hapus Jabatan', 'Apakah Anda yakin ingin menghapus jabatan ini?', () => {
                        positions.splice(index, 1);
                        renderPositionsList();
                        showModal('Sukses', 'Jabatan berhasil dihapus.');
                    });
                });
            });
        }

        /**
         * Menangani penambahan jabatan baru.
         */
        function handleAddPosition() {
            const newPos = newPositionNameInput.value.trim();
            if (newPos && !positions.includes(newPos)) {
                positions.push(newPos);
                newPositionNameInput.value = '';
                renderPositionsList();
                showModal('Sukses', 'Jabatan berhasil ditambahkan.');
            } else if (newPos) {
                showModal('Peringatan', 'Jabatan ini sudah ada.');
            } else {
                showModal('Peringatan', 'Nama jabatan tidak boleh kosong.');
            }
        }

        /**
         * Menangani pengeditan jabatan.
         * @param {Event} event - Event pengiriman formulir.
         */
        function handleEditPositionSubmit(event) {
            event.preventDefault();
            const updatedName = editPositionNameInput.value.trim();
            if (updatedName && editingPositionIndex !== null) {
                // Check if the updated name already exists and is not the current item being edited
                if (positions.includes(updatedName) && positions.indexOf(updatedName) !== editingPositionIndex) {
                    showModal('Peringatan', 'Jabatan ini sudah ada.');
                    return;
                }
                positions[editingPositionIndex] = updatedName;
                renderPositionsList();
                hideEditPositionModal();
                showModal('Sukses', 'Jabatan berhasil diperbarui.');
            } else {
                showModal('Peringatan', 'Nama jabatan tidak boleh kosong.');
            }
        }

        /**
         * Merender daftar lokasi.
         */
        function renderLocationsList() {
            locationListUl.innerHTML = '';
            if (locations.length === 0) {
                locationListUl.innerHTML = '<li class="text-gray-500">Tidak ada data lokasi.</li>';
                return;
            }
            locations.forEach((loc, index) => {
                const li = document.createElement('li');
                li.classList.add('bg-gray-50', 'p-2', 'rounded-md', 'flex', 'justify-between', 'items-center');
                li.innerHTML = `
                    <div>
                        <div class="font-semibold">${loc.name}</div>
                        <div class="text-sm text-gray-600">Lat: ${loc.lat}, Lon: ${loc.lon}, Radius: ${loc.radius}m</div>
                    </div>
                    <div>
                        <button class="text-blue-600 hover:text-blue-800 mr-2 edit-location-btn" data-id="${loc.id}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800 delete-location-btn" data-id="${loc.id}"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                locationListUl.appendChild(li);
            });

            locationListUl.querySelectorAll('.edit-location-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    const locationToEdit = locations.find(loc => loc.id === id);
                    if (locationToEdit) {
                        showEditLocationModal(locationToEdit);
                    }
                });
            });

            locationListUl.querySelectorAll('.delete-location-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    showConfirmationModal('Hapus Lokasi', 'Apakah Anda yakin ingin menghapus lokasi ini?', () => {
                        locations = locations.filter(loc => loc.id !== id);
                        renderLocationsList();
                        showModal('Sukses', 'Lokasi berhasil dihapus.');
                    });
                });
            });
        }

        /**
         * Menangani penambahan lokasi baru.
         */
        function handleAddLocation() {
            const name = newLocationNameInput.value.trim();
            const lat = parseFloat(newLocationLatInput.value);
            const lon = parseFloat(newLocationLonInput.value);
            const radius = parseInt(newLocationRadiusInput.value);

            if (name && !isNaN(lat) && !isNaN(lon) && !isNaN(radius) && radius > 0) {
                // Check for duplicate location names
                if (locations.some(loc => loc.name === name)) {
                    showModal('Peringatan', 'Nama lokasi ini sudah ada.');
                    return;
                }
                const newLocation = { id: nextLocationId++, name, lat, lon, radius };
                locations.push(newLocation);
                newLocationNameInput.value = '';
                newLocationLatInput.value = '';
                newLocationLonInput.value = '';
                newLocationRadiusInput.value = '';
                renderLocationsList();
                showModal('Sukses', 'Lokasi berhasil ditambahkan.');
            } else {
                showModal('Peringatan', 'Harap lengkapi semua kolom lokasi dengan nilai yang valid.');
            }
        }

        /**
         * Menangani pengeditan lokasi.
         * @param {Event} event - Event pengiriman formulir.
         */
        function handleEditLocationSubmit(event) {
            event.preventDefault();
            const name = editLocationNameInput.value.trim();
            const lat = parseFloat(editLocationLatInput.value);
            const lon = parseFloat(editLocationLonInput.value);
            const radius = parseInt(editLocationRadiusInput.value);

            if (name && !isNaN(lat) && !isNaN(lon) && !isNaN(radius) && radius > 0 && editingLocationId !== null) {
                // Check for duplicate location names, excluding the current item being edited
                if (locations.some(loc => loc.name === name && loc.id !== editingLocationId)) {
                    showModal('Peringatan', 'Nama lokasi ini sudah ada.');
                    return;
                }

                locations = locations.map(loc =>
                    loc.id === editingLocationId ? { ...loc, name, lat, lon, radius } : loc
                );
                renderLocationsList();
                hideEditLocationModal();
                showModal('Sukses', 'Data lokasi berhasil diperbarui.');
            } else {
                showModal('Peringatan', 'Harap lengkapi semua kolom lokasi dengan nilai yang valid.');
            }
        }

        /**
         * Menangani penyimpanan waktu masuk dan pulang kantor default oleh admin.
         */
        function handleSaveOfficeHours() {
            const newCheckInTime = officeCheckinTimeInput.value;
            const newCheckOutTime = officeCheckoutTimeInput.value;

            if (newCheckInTime && newCheckOutTime) {
                officeCheckInTime = newCheckInTime;
                officeCheckOutTime = newCheckOutTime;
                showModal('Sukses', `Waktu kerja default berhasil diperbarui menjadi Masuk: ${officeCheckInTime}, Pulang: ${officeCheckOutTime}.`);
                // Update the displayed times on the absensi page if it's currently active
                if (currentView === 'absensi') {
                    displayCheckinTime.textContent = officeCheckInTime;
                    displayCheckoutTime.textContent = officeCheckOutTime;
                }
            } else {
                showModal('Peringatan', 'Harap isi kedua waktu masuk dan pulang kantor.');
            }
        }


        // --- Kalender Page Logic ---

        /**
         * Merender kalender untuk tanggal yang diberikan.
         * @param {Date} date - Tanggal untuk merender kalender.
         */
        function renderCalendar(date) {
            currentCalendarDate = date;
            const year = date.getFullYear();
            const month = date.getMonth(); // 0-indexed

            currentMonthYear.textContent = new Date(year, month).toLocaleString('id-ID', { month: 'long', year: 'numeric' });

            calendarDaysContainer.innerHTML = ''; // Hapus hari-hari sebelumnya

            // Dapatkan hari pertama bulan dan hari terakhir bulan
            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);

            // Dapatkan hari dalam seminggu untuk hari pertama (0=Minggu, 1=Senin, ..., 6=Sabtu)
            // Sesuaikan agar Senin menjadi hari pertama (0=Senin)
            let startDay = firstDayOfMonth.getDay();
            if (startDay === 0) startDay = 6; // Minggu menjadi 6
            else startDay--; // Senin menjadi 0, Selasa 1, dst.

            // Tambahkan sel kosong untuk hari-hari sebelum hari pertama bulan
            for (let i = 0; i < startDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day', 'other-month');
                calendarDaysContainer.appendChild(emptyDay);
            }

            // Tambahkan hari-hari dalam bulan
            for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day', 'current-month');
                dayElement.textContent = day;
                dayElement.dataset.date = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                const fullDate = new Date(year, month, day);
                const today = new Date();
                if (fullDate.toDateString() === today.toDateString()) {
                    dayElement.classList.add('today');
                }

                // Periksa item agenda pada tanggal ini
                const hasAgenda = agendaData.some(agenda => agenda.date === dayElement.dataset.date);
                if (hasAgenda) {
                    dayElement.classList.add('has-agenda');
                }

                dayElement.addEventListener('click', () => {
                    // Sorot hari yang dipilih
                    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                    dayElement.classList.add('selected');
                    agendaDateInput.value = dayElement.dataset.date;
                });

                calendarDaysContainer.appendChild(dayElement);
            }
        }

        /**
         * Merender daftar item agenda.
         */
        function renderAgendaList() {
            agendaList.innerHTML = '';
            if (agendaData.length === 0) {
                const li = document.createElement('li');
                li.textContent = 'Tidak ada agenda.';
                li.classList.add('text-gray-500');
                agendaList.appendChild(li);
                return;
            }

            // Urutkan agenda berdasarkan tanggal
            agendaData.sort((a, b) => new Date(a.date) - new Date(b.date));

            agendaData.forEach((agenda, index) => {
                const li = document.createElement('li');
                li.classList.add('agenda-item');
                let deleteButtonHtml = '';
                if (currentUser && currentUser.role === 'admin') {
                    deleteButtonHtml = `<button data-index="${index}"><i class="fas fa-trash"></i></button>`;
                }
                li.innerHTML = `
                    <span>${agenda.date}: ${agenda.title}</span>
                    ${deleteButtonHtml}
                `;
                agendaList.appendChild(li);
            });

            // Tambahkan event listener untuk tombol hapus (hanya jika admin)
            if (currentUser && currentUser.role === 'admin') {
                agendaList.querySelectorAll('.agenda-item button').forEach(button => {
                    button.addEventListener('click', (event) => {
                        const indexToDelete = parseInt(event.currentTarget.dataset.index);
                        deleteAgenda(indexToDelete);
                    });
                });
            }
        }

        /**
         * Menambahkan item agenda baru.
         */
        function addAgenda() {
            // Pastikan hanya admin yang bisa menambahkan agenda
            if (currentUser.role !== 'admin') {
                showModal('Akses Ditolak', 'Hanya admin yang dapat menambahkan agenda.');
                return;
            }

            const date = agendaDateInput.value;
            const title = agendaTitleInput.value.trim();

            if (date && title) {
                agendaData.push({ date, title });
                agendaDateInput.value = '';
                agendaTitleInput.value = '';
                renderAgendaList();
                renderCalendar(currentCalendarDate); // Render ulang kalender untuk menampilkan agenda baru
                showModal('Sukses', 'Agenda berhasil ditambahkan.');
            } else {
                showModal('Peringatan', 'Harap isi tanggal dan judul agenda.');
            }
        }

        /**
         * Menghapus item agenda.
         * @param {number} index - Indeks item agenda yang akan dihapus.
         */
        function deleteAgenda(index) {
            // Pastikan hanya admin yang bisa menghapus agenda
            if (currentUser.role !== 'admin') {
                showModal('Akses Ditolak', 'Hanya admin yang dapat menghapus agenda.');
                return;
            }
            agendaData.splice(index, 1);
            renderAgendaList();
            renderCalendar(currentCalendarDate); // Render ulang kalender
            showModal('Sukses', 'Agenda berhasil dihapus.');
        }

        // --- Izin/Sakit Page Logic ---
        /**
         * Merender daftar pengajuan izin/sakit untuk karyawan yang login.
         */
        function renderEmployeeLeaveRequests() {
            employeeLeaveListBody.innerHTML = '';
            const employeeRequests = leaveRequests.filter(req => req.employeeId === currentUser.id);

            if (employeeRequests.length === 0) {
                employeeLeaveListBody.innerHTML = '<tr><td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada riwayat pengajuan izin/sakit.</td></tr>';
                return;
            }

            employeeRequests.forEach(req => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                let statusClass = '';
                if (req.status === 'Pending') statusClass = 'bg-yellow-100 text-yellow-800';
                else if (req.status === 'Approved') statusClass = 'bg-green-100 text-green-800';
                else if (req.status === 'Rejected') statusClass = 'bg-red-100 text-red-800';

                row.innerHTML = `
                    <td class="px-4 py-3">${req.type}</td>
                    <td class="px-4 py-3">${req.startDate} s/d ${req.endDate}</td>
                    <td class="px-4 py-3">${req.reason}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-full ${statusClass}">${req.status}</span></td>
                    <td class="px-4 py-3">
                        ${req.attachment ? `<a href="#" class="text-blue-600 hover:text-blue-800 mr-2" onclick="showModal('Lampiran', 'Simulasi unduh lampiran: ${req.attachment}')"><i class="fas fa-paperclip"></i></a>` : ''}
                    </td>
                `;
                employeeLeaveListBody.appendChild(row);
            });
        }

        /**
         * Merender daftar pengajuan izin/sakit untuk admin.
         */
        function renderAdminLeaveRequests() {
            adminLeaveListBody.innerHTML = '';
            const pendingRequests = leaveRequests.filter(req => req.status === 'Pending');

            if (pendingRequests.length === 0) {
                adminLeaveListBody.innerHTML = '<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada pengajuan izin/sakit yang menunggu persetujuan.</td></tr>';
                return;
            }

            pendingRequests.forEach(req => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                let statusClass = 'bg-yellow-100 text-yellow-800'; // Always pending for this view

                row.innerHTML = `
                    <td class="px-4 py-3">${req.employeeName}</td>
                    <td class="px-4 py-3">${req.type}</td>
                    <td class="px-4 py-3">${req.startDate} s/d ${req.endDate}</td>
                    <td class="px-4 py-3">${req.reason}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-full ${statusClass}">${req.status}</span></td>
                    <td class="px-4 py-3">
                        <button class="text-green-600 hover:text-green-800 mr-2 approve-request-btn" data-id="${req.id}"><i class="fas fa-check"></i> Setujui</button>
                        <button class="text-red-600 hover:text-red-800 reject-request-btn" data-id="${req.id}"><i class="fas fa-times"></i> Tolak</button>
                        ${req.attachment ? `<a href="#" class="text-blue-600 hover:text-blue-800 ml-2" onclick="showModal('Lampiran', 'Simulasi unduh lampiran: ${req.attachment}')"><i class="fas fa-paperclip"></i></a>` : ''}
                    </td>
                `;
                adminLeaveListBody.appendChild(row);
            });

            // Re-attach event listeners every time the table is rendered
            adminLeaveListBody.querySelectorAll('.approve-request-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    approveLeaveRequest(id);
                });
            });

            adminLeaveListBody.querySelectorAll('.reject-request-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = parseInt(event.currentTarget.dataset.id);
                    rejectLeaveRequest(id);
                });
            });
        }

        /**
         * Menyetujui pengajuan izin/sakit.
         * @param {number} id - ID pengajuan.
         */
        function approveLeaveRequest(id) {
            const requestIndex = leaveRequests.findIndex(req => req.id === id);
            if (requestIndex !== -1) {
                leaveRequests[requestIndex].status = 'Approved';
                showModal('Persetujuan', `Pengajuan izin/sakit dari ${leaveRequests[requestIndex].employeeName} telah disetujui.`);
                renderAdminLeaveRequests(); // Re-render admin view to reflect changes
                updateDashboardStats(); // Update dashboard stats
            }
        }

        /**
         * Menolak pengajuan izin/sakit.
         * @param {number} id - ID pengajuan.
         */
        function rejectLeaveRequest(id) {
            const requestIndex = leaveRequests.findIndex(req => req.id === id);
            if (requestIndex !== -1) {
                leaveRequests[requestIndex].status = 'Rejected';
                showModal('Penolakan', `Pengajuan izin/sakit dari ${leaveRequests[requestIndex].employeeName} telah ditolak.`);
                renderAdminLeaveRequests(); // Re-render admin view to reflect changes
                updateDashboardStats(); // Update dashboard stats
            }
        }

        /**
         * Menangani pengiriman formulir izin/sakit.
         * @param {Event} event - Event pengiriman formulir.
         */
        function handleIzinSakitSubmit(event) {
            event.preventDefault();
            const type = document.getElementById('request-type').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const reason = document.getElementById('reason').value;
            const attachmentInput = document.getElementById('attachment');
            const attachment = attachmentInput.files[0] ? attachmentInput.files[0].name : null;

            if (type && startDate && endDate && reason) {
                const newRequest = {
                    id: nextLeaveRequestId++,
                    employeeId: currentUser.id,
                    employeeName: currentUser.username,
                    type,
                    startDate,
                    endDate,
                    reason,
                    status: 'Pending',
                    attachment
                };
                leaveRequests.push(newRequest);
                showModal('Pengajuan Terkirim', `Pengajuan ${type} Anda telah dikirim dan menunggu persetujuan Admin.`);

                izinSakitForm.reset(); // Kosongkan formulir
                renderEmployeeLeaveRequests(); // Update employee's own list
                updateDashboardStats(); // Update dashboard stats
            } else {
                showModal('Peringatan', 'Harap lengkapi semua kolom yang wajib diisi.');
            }
        }

        // --- Rekap Absen Page Logic ---

        /**
         * Mengisi dropdown filter karyawan untuk kedua tampilan.
         */
        function populateFilterEmployeeSelects() {
            const employeeOptions = employees.filter(emp => emp.role !== 'admin').map(emp => `<option value="${emp.id}">${emp.name}</option>`).join('');
            filterEmployeeDailySelect.innerHTML = '<option value="">Semua Karyawan</option>' + employeeOptions;
            filterEmployeeMonthlySelect.innerHTML = '<option value="">Semua Karyawan</option>' + employeeOptions;

            // Populate month and year for monthly filter
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            filterMonthMonthlySelect.innerHTML = months.map((month, index) => `<option value="${index + 1}">${month}</option>`).join('');
            const currentYear = new Date().getFullYear();
            let yearOptions = '';
            for (let i = currentYear - 5; i <= currentYear + 1; i++) {
                yearOptions += `<option value="${i}" ${i === currentYear ? 'selected' : ''}>${i}</option>`;
            }
            filterYearMonthlySelect.innerHTML = yearOptions;

            // Set default month to current month
            filterMonthMonthlySelect.value = new Date().getMonth() + 1;
        }

        /**
         * Mengkonversi string waktu (HH:MM) menjadi total menit.
         * @param {string} timeString - Waktu dalam format HH:MM.
         * @returns {number} Total menit.
         */
        function parseTime(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            return hours * 60 + minutes;
        }

        /**
         * Mengkonversi total menit menjadi format jam dan menit.
         * @param {number} totalMinutes - Total menit.
         * @returns {string} Format jam dan menit (e.g., "1 Jam 30 Menit").
         */
        function formatMinutesToHoursMinutes(totalMinutes) {
            if (totalMinutes < 0) totalMinutes = 0; // Ensure no negative values
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            return `${hours} Jam ${minutes} Menit`;
        }

        /**
         * Mengganti tampilan rekap absensi antara harian dan bulanan.
         * @param {string} viewType - 'daily' atau 'monthly'.
         */
        function switchRekapAbsenView(viewType) {
            currentRekapAbsenView = viewType;

            if (viewType === 'daily') {
                rekapAbsenTitle.textContent = 'Rekap Presensi Harian';
                dailyRekapFilters.classList.remove('hidden');
                monthlyRekapFilters.classList.add('hidden');
                viewDailyRekapBtn.classList.add('tabler-btn-primary');
                viewDailyRekapBtn.classList.remove('tabler-btn-outline-primary');
                viewMonthlyRekapBtn.classList.add('tabler-btn-outline-primary');
                viewMonthlyRekapBtn.classList.remove('tabler-btn-primary');
                renderRekapAbsenTableDaily();
            } else { // monthly
                rekapAbsenTitle.textContent = 'Rekap Presensi Bulanan';
                dailyRekapFilters.classList.add('hidden');
                monthlyRekapFilters.classList.remove('hidden');
                viewMonthlyRekapBtn.classList.add('tabler-btn-primary');
                viewMonthlyRekapBtn.classList.remove('tabler-btn-outline-primary');
                viewDailyRekapBtn.classList.add('tabler-btn-outline-primary');
                viewDailyRekapBtn.classList.remove('tabler-btn-primary');
                renderRekapAbsenTableMonthly();
            }
        }

        /**
         * Merender tabel rekap absensi untuk tampilan harian.
         */
        function renderRekapAbsenTableDaily() {
            rekapAbsenTableHeaders.innerHTML = `
                <th class="px-4 py-3 rounded-tl-md">No.</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Jam Masuk</th>
                <th class="px-4 py-3">Jam Pulang</th>
                <th class="px-4 py-3">Total Jam</th>
                <th class="px-4 py-3 rounded-tr-md">Total Terlambat</th>
            `;
            rekapAbsenListBody.innerHTML = '';

            let filteredRecords = [...attendanceRecords];

            const selectedEmployeeId = filterEmployeeDailySelect.value;
            const startDate = filterStartDateDailyInput.value;
            const endDate = filterEndDateDailyInput.value;

            if (selectedEmployeeId) {
                filteredRecords = filteredRecords.filter(rec => rec.employeeId === parseInt(selectedEmployeeId));
            }
            if (startDate) {
                filteredRecords = filteredRecords.filter(rec => new Date(rec.date) >= new Date(startDate));
            }
            if (endDate) {
                filteredRecords = filteredRecords.filter(rec => new Date(rec.date) <= new Date(endDate));
            }

            // Sort by date ascending for daily view
            filteredRecords.sort((a, b) => new Date(a.date) - new Date(b.date));

            if (filteredRecords.length === 0) {
                rekapAbsenListBody.innerHTML = '<tr><td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data absensi harian yang ditemukan.</td></tr>';
                return;
            }

            filteredRecords.forEach((rec, index) => {
                const checkInTime = parseTime(rec.checkIn || '00:00');
                const checkOutTime = parseTime(rec.checkOut || '00:00');
                const officeCheckInMinutes = parseTime(officeCheckInTime);
                const officeCheckOutMinutes = parseTime(officeCheckOutTime);

                let totalHoursMinutes = 'N/A';
                if (rec.checkIn && rec.checkOut) {
                    const durationMinutes = checkOutTime - checkInTime;
                    totalHoursMinutes = formatMinutesToHoursMinutes(durationMinutes);
                }

                let totalLateMinutes = 0;
                if (rec.checkIn && checkInTime > officeCheckInMinutes) {
                    totalLateMinutes = checkInTime - officeCheckInMinutes;
                }
                const totalLateFormatted = formatMinutesToHoursMinutes(totalLateMinutes);

                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                row.innerHTML = `
                    <td class="px-4 py-3">${index + 1}</td>
                    <td class="px-4 py-3">${rec.employeeName}</td>
                    <td class="px-4 py-3">${rec.date}</td>
                    <td class="px-4 py-3">${rec.checkIn || '-'}</td>
                    <td class="px-4 py-3">${rec.checkOut || '-'}</td>
                    <td class="px-4 py-3">${totalHoursMinutes}</td>
                    <td class="px-4 py-3">${totalLateFormatted}</td>
                `;
                rekapAbsenListBody.appendChild(row);
            });
        }

        /**
         * Merender tabel rekap absensi untuk tampilan bulanan.
         */
        function renderRekapAbsenTableMonthly() {
            rekapAbsenTableHeaders.innerHTML = `
                <th class="px-4 py-3 rounded-tl-md">Tanggal</th>
                <th class="px-4 py-3">Karyawan</th>
                <th class="px-4 py-3">Check-in</th>
                <th class="px-4 py-3">Check-out</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 rounded-tr-md">Catatan</th>
            `;
            rekapAbsenListBody.innerHTML = '';

            let filteredRecords = [...attendanceRecords];

            const selectedEmployeeId = filterEmployeeMonthlySelect.value;
            const selectedMonth = filterMonthMonthlySelect.value; // 1-12
            const selectedYear = filterYearMonthlySelect.value;

            if (selectedEmployeeId) {
                filteredRecords = filteredRecords.filter(rec => rec.employeeId === parseInt(selectedEmployeeId));
            }

            if (selectedMonth && selectedYear) {
                const monthString = String(selectedMonth).padStart(2, '0');
                const yearMonthFilter = `${selectedYear}-${monthString}`;
                filteredRecords = filteredRecords.filter(rec => rec.date.startsWith(yearMonthFilter));
            }

            // Sort by date descending for monthly view (consistent with original rekap)
            filteredRecords.sort((a, b) => new Date(b.date) - new Date(a.date));

            if (filteredRecords.length === 0) {
                rekapAbsenListBody.innerHTML = '<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data absensi bulanan yang ditemukan.</td></tr>';
                return;
            }

            filteredRecords.forEach(rec => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                let statusClass = '';
                if (rec.status === 'Hadir') statusClass = 'bg-green-100 text-green-800';
                else if (rec.status === 'Terlambat') statusClass = 'bg-yellow-100 text-yellow-800';
                else if (rec.status === 'Pulang Awal') statusClass = 'bg-orange-100 text-orange-800';
                else statusClass = 'bg-gray-100 text-gray-800'; // Default for other statuses

                row.innerHTML = `
                    <td class="px-4 py-3">${rec.date}</td>
                    <td class="px-4 py-3">${rec.employeeName}</td>
                    <td class="px-4 py-3">${rec.checkIn || '-'}</td>
                    <td class="px-4 py-3">${rec.checkOut || '-'}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs font-medium rounded-full ${statusClass}">${rec.status}</span></td>
                    <td class="px-4 py-3">${rec.notes || '-'}</td>
                `;
                rekapAbsenListBody.appendChild(row);
            });
        }

        /**
         * Menerapkan filter pada data absensi dan merender ulang tabel berdasarkan tampilan aktif.
         */
        function applyFilterRekapAbsen() {
            if (currentRekapAbsenView === 'daily') {
                renderRekapAbsenTableDaily();
            } else {
                renderRekapAbsenTableMonthly();
            }
        }

        /**
         * Mereset filter absensi dan merender ulang tabel berdasarkan tampilan aktif.
         */
        function resetFilterRekapAbsen() {
            // Reset daily filters
            filterEmployeeDailySelect.value = '';
            filterStartDateDailyInput.value = '';
            filterEndDateDailyInput.value = '';

            // Reset monthly filters
            filterEmployeeMonthlySelect.value = '';
            filterMonthMonthlySelect.value = new Date().getMonth() + 1; // Set back to current month
            filterYearMonthlySelect.value = new Date().getFullYear(); // Set back to current year

            applyFilterRekapAbsen(); // Re-apply filters with reset values
        }

        /**
         * Mengkonversi data absensi yang difilter menjadi format CSV dan mengunduhnya.
         */
        function exportRekapAbsenToCSV() {
            const currentHeaders = Array.from(rekapAbsenTableHeaders.children).map(th => th.textContent.trim());
            const rows = rekapAbsenListBody.querySelectorAll('tr');

            if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td').colSpan > 1)) {
                showModal('Ekspor Gagal', 'Tidak ada data absensi untuk diekspor.');
                return;
            }

            let csvContent = currentHeaders.join(',') + '\n';

            rows.forEach(row => {
                const rowData = [];
                row.querySelectorAll('td').forEach((cell, index) => {
                    // Special handling for status span if it exists
                    const span = cell.querySelector('span');
                    if (span) {
                        rowData.push(`"${span.textContent.trim()}"`);
                    } else {
                        rowData.push(`"${cell.textContent.trim()}"`);
                    }
                });
                csvContent += rowData.join(',') + '\n';
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            if (link.download !== undefined) { // Feature detection for download attribute
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `rekap_absensi_${currentRekapAbsenView}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                showModal('Ekspor Berhasil', 'Data rekap absensi telah berhasil diekspor ke file CSV.');
            } else {
                showModal('Ekspor Gagal', 'Browser Anda tidak mendukung fitur unduh file secara langsung.');
            }
        }


        // --- Event Listeners ---
        document.addEventListener('DOMContentLoaded', () => {
            // Initial load setup
            loginPage.classList.remove('hidden');
            mainApp.classList.add('hidden');
            updateAbsensiButtonState(); // Initialize button states

            // Login/Logout
            loginForm.addEventListener('submit', handleLogin);
            logoutBtn.addEventListener('click', handleLogout);

            // Navigation
            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    showPage(this.dataset.page);
                });
            });

            // Hamburger menu
            hamburgerMenuBtn.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);

            // Absensi Page
            capturePhotoBtn.addEventListener('click', capturePhoto);
            retakePhotoBtn.addEventListener('click', retakePhoto);
            getLocationBtn.addEventListener('click', getLocation);
            checkInBtn.addEventListener('click', handleCheckIn);
            checkOutBtn.addEventListener('click', handleCheckOut);

            // Data Karyawan Page (Admin)
            addEmployeeBtn.addEventListener('click', () => showEmployeeInputModal());
            employeeForm.addEventListener('submit', handleEmployeeFormSubmit);
            closeEmployeeModalBtn.addEventListener('click', hideEmployeeInputModal);
            captureEmployeePhotoBtn.addEventListener('click', captureEmployeePhoto);
            retakeEmployeePhotoBtn.addEventListener('click', retakeEmployeePhoto);
            uploadEmployeePhotoInput.addEventListener('change', uploadEmployeePhoto);


            // Master Data Page (Admin)
            addPositionBtn.addEventListener('click', handleAddPosition);
            editPositionForm.addEventListener('submit', handleEditPositionSubmit);
            closePositionModalBtn.addEventListener('click', hideEditPositionModal);

            addLocationBtn.addEventListener('click', handleAddLocation);
            editLocationForm.addEventListener('submit', handleEditLocationSubmit);
            closeLocationModalBtn.addEventListener('click', hideEditLocationModal);
            saveOfficeHoursBtn.addEventListener('click', handleSaveOfficeHours); // Event listener for new save button


            // Calendar Page
            prevMonthBtn.addEventListener('click', () => {
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
                renderCalendar(currentCalendarDate);
            });
            nextMonthBtn.addEventListener('click', () => {
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
                renderCalendar(currentCalendarDate);
            });
            if (addAgendaBtn) {
                addAgendaBtn.addEventListener('click', addAgenda);
            } else {
                console.error("Error: Element with ID 'add-agenda-btn' not found. Agenda adding functionality might be limited.");
            }


            // Izin/Sakit Page
            izinSakitForm.addEventListener('submit', handleIzinSakitSubmit);

            // Rekap Absen Page
            viewDailyRekapBtn.addEventListener('click', () => switchRekapAbsenView('daily'));
            viewMonthlyRekapBtn.addEventListener('click', () => switchRekapAbsenView('monthly'));
            applyFilterBtn.addEventListener('click', applyFilterRekapAbsen);
            resetFilterBtn.addEventListener('click', resetFilterRekapAbsen);
            exportRekapBtn.addEventListener('click', exportRekapAbsenToCSV); // Event listener for new export button


            // Custom Modal
            modalOkBtn.addEventListener('click', hideModal);
            modalCloseBtn.addEventListener('click', hideModal);
            window.addEventListener('click', (event) => {
                if (event.target === customModal) {
                    hideModal();
                }
            });

            // Confirmation Modal
            confirmOkBtn.addEventListener('click', () => {
                if (confirmCallback) {
                    confirmCallback();
                }
                hideConfirmationModal();
            });
            confirmCancelBtn.addEventListener('click', hideConfirmationModal);
            closeConfirmationModalBtn.addEventListener('click', hideConfirmationModal);
        });
    </script>
</body>
</html>
