<?php
require_once '_header.php';

// Get counts
$totalServices  = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM services WHERE is_active=1"))[0] : 8;
$totalPortfolio = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM portfolio"))[0] : 6;
$totalGallery   = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM gallery WHERE is_active=1"))[0] : 8;
$totalMessages  = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM contact_messages"))[0] : 0;
$unreadMessages = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM contact_messages WHERE is_read=0"))[0] : 0;
$totalClients   = $conn ? mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM clients WHERE is_active=1"))[0] : 8;

// Recent messages
$recentMessages = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
    while ($row = mysqli_fetch_assoc($res)) $recentMessages[] = $row;
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Dashboard';
    document.getElementById('pageBreadcrumb').textContent = 'Overview';
</script>

<!-- Stats Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0e7ff; color:#6366f1;">
                <i class="fas fa-concierge-bell"></i>
            </div>
            <div class="stat-number"><?= $totalServices ?></div>
            <div class="stat-label">Services</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5; color:#10b981;">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-number"><?= $totalPortfolio ?></div>
            <div class="stat-label">Projects</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7; color:#f59e0b;">
                <i class="fas fa-photo-video"></i>
            </div>
            <div class="stat-number"><?= $totalGallery ?></div>
            <div class="stat-label">Gallery Items</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe; color:#3b82f6;">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-number"><?= $totalClients ?></div>
            <div class="stat-label">Clients</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce7f3; color:#ec4899;">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-number"><?= $totalMessages ?></div>
            <div class="stat-label">Total Messages</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2; color:#ef4444;">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-number"><?= $unreadMessages ?></div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
</div>

<!-- Quick Actions + Recent Messages -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Quick Actions</div>
            </div>
            <div class="p-3">
                <div class="d-grid gap-2">
                    <a href="hero.php" class="btn-primary-custom" style="justify-content: center; padding: 12px;">
                        <i class="fas fa-images"></i> Manage Hero Slides
                    </a>
                    <a href="services.php?action=add" class="btn-primary-custom" style="background: linear-gradient(135deg,#10b981,#059669); justify-content: center; padding: 12px;">
                        <i class="fas fa-plus"></i> Add New Service
                    </a>
                    <a href="portfolio.php?action=add" class="btn-primary-custom" style="background: linear-gradient(135deg,#f59e0b,#d97706); justify-content: center; padding: 12px;">
                        <i class="fas fa-plus"></i> Add Portfolio Item
                    </a>
                    <a href="gallery.php?action=add" class="btn-primary-custom" style="background: linear-gradient(135deg,#ec4899,#db2777); justify-content: center; padding: 12px;">
                        <i class="fas fa-camera"></i> Add Gallery Photo
                    </a>
                    <a href="contacts.php" class="btn-primary-custom" style="background: linear-gradient(135deg,#3b82f6,#1d4ed8); justify-content: center; padding: 12px;">
                        <i class="fas fa-envelope"></i> View Messages
                    </a>
                    <a href="settings.php" class="btn-primary-custom" style="background: linear-gradient(135deg,#6b7280,#374151); justify-content: center; padding: 12px;">
                        <i class="fas fa-cog"></i> Site Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Recent Messages</div>
                <a href="contacts.php" class="btn-primary-custom" style="padding: 7px 14px; font-size: 12px;">
                    <i class="fas fa-list"></i> View All
                </a>
            </div>
            <?php if (empty($recentMessages)): ?>
            <div class="p-5 text-center text-muted">
                <i class="fas fa-inbox" style="font-size: 36px; opacity: 0.3; margin-bottom: 12px; display: block;"></i>
                No messages yet
            </div>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentMessages as $msg): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($msg['name']) ?></strong><br>
                            <small style="color:#6b7280;"><?= htmlspecialchars($msg['email']) ?></small>
                        </td>
                        <td><?= htmlspecialchars(substr($msg['subject'] ?? 'No Subject', 0, 40)) ?></td>
                        <td style="white-space:nowrap; color:#6b7280; font-size:12px;"><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                        <td>
                            <?php if ($msg['is_read']): ?>
                                <span class="badge-active">Read</span>
                            <?php else: ?>
                                <span class="badge-unread">Unread</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '_footer.php'; ?>
