<?php
require_once '../config.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — MantraTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --sidebar-width: 260px;
            --header-height: 64px;
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
        }

        /* ─── Sidebar ──────────────────────────────── */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #1e1b4b;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-brand-text span {
            color: #a5b4fc;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.35);
            padding: 8px 12px 6px;
            margin-top: 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar-link .icon {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        /* ─── Main Content ─────────────────────────── */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            position: sticky;
            top: 0;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 50;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title {
            font-size: 17px;
            font-weight: 600;
            color: var(--text-main);
        }

        .page-breadcrumb {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .view-site-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .view-site-btn:hover {
            background: var(--primary);
            color: white;
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .dropdown-menu {
            min-width: 180px;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 6px;
            font-size: 14px;
            padding: 8px 12px;
        }

        .admin-content {
            flex: 1;
            padding: 28px;
        }

        /* ─── Cards & Stats ────────────────────────── */
        .stat-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border);
            transition: box-shadow 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ─── Data Tables ──────────────────────────── */
        .admin-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .admin-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-main);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table thead th {
            background: var(--bg-main);
            padding: 12px 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .admin-table tbody td {
            padding: 14px 20px;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover td {
            background: #f9fafb;
        }

        /* ─── Buttons ──────────────────────────────── */
        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #5558e3, #7c3aed);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-sm-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-edit {
            background: #eff6ff;
            color: #3b82f6;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #fef2f2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .btn-toggle {
            background: #f0fdf4;
            color: #10b981;
        }

        .btn-toggle:hover {
            background: #10b981;
            color: white;
        }

        /* ─── Badges ───────────────────────────────── */
        .badge-active {
            background: #d1fae5;
            color: #065f46;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-inactive {
            background: #f3f4f6;
            color: #6b7280;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-unread {
            background: #fef3c7;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* ─── Forms ────────────────────────────────── */
        .form-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 28px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* ─── Alerts ───────────────────────────────── */
        .alert-success-custom {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .alert-error-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        /* ─── Responsive ───────────────────────────── */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon"><i class="fas fa-code"></i></div>
            <div class="sidebar-brand-text">Mantra<span>Tech</span></div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Overview</div>
            <a href="index.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-th-large icon"></i> Dashboard
            </a>

            <div class="sidebar-section-label">Content</div>
            <a href="hero.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'hero.php' ? 'active' : '' ?>">
                <i class="fas fa-images icon"></i> Hero Slides
            </a>
            <a href="services.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : '' ?>">
                <i class="fas fa-concierge-bell icon"></i> Services
            </a>
            <a href="portfolio.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'portfolio.php' ? 'active' : '' ?>">
                <i class="fas fa-briefcase icon"></i> Portfolio
            </a>
            <a href="gallery.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'gallery.php' ? 'active' : '' ?>">
                <i class="fas fa-photo-video icon"></i> Gallery
            </a>
            <a href="clients.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'clients.php' ? 'active' : '' ?>">
                <i class="fas fa-handshake icon"></i> Clients
            </a>
            <a href="technologies.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'technologies.php' ? 'active' : '' ?>">
                <i class="fas fa-microchip icon"></i> Technologies
            </a>

            <div class="sidebar-section-label">Communication</div>
            <a href="contacts.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'contacts.php' ? 'active' : '' ?>">
                <i class="fas fa-envelope icon"></i> Messages
                <?php
                if ($conn) {
                    $unread = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM contact_messages WHERE is_read=0"));
                    if ($unread && $unread[0] > 0) echo '<span class="sidebar-badge">'.$unread[0].'</span>';
                }
                ?>
            </a>

            <div class="sidebar-section-label">Settings</div>
            <a href="settings.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : '' ?>">
                <i class="fas fa-cog icon"></i> Site Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-link" style="color: #f87171;">
                <i class="fas fa-sign-out-alt icon"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="admin-header-left">
                <button id="sidebarToggle" class="d-lg-none btn btn-sm btn-light">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <div class="page-title" id="pageTitle">Dashboard</div>
                    <div class="page-breadcrumb">
                        <span>MantraTech</span>
                        <i class="fas fa-chevron-right" style="font-size:9px;"></i>
                        <span id="pageBreadcrumb">Admin Panel</span>
                    </div>
                </div>
            </div>
            <div class="admin-header-right">
                <a href="../index.php" target="_blank" class="view-site-btn">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
                <div class="dropdown">
                    <div class="admin-avatar dropdown-toggle" data-bs-toggle="dropdown" style="cursor:pointer;">
                        A
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted" style="font-size:12px;">Signed in as <strong>admin</strong></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page content will be here -->
        <div class="admin-content">
