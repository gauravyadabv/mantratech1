<?php
require_once '_header.php';

$message = '';
$error = '';

// Save settings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $fields = [
        'company_name', 'company_slogan', 'company_email', 'company_phone',
        'company_address', 'company_facebook', 'company_twitter',
        'company_linkedin', 'company_instagram', 'company_github',
        'about_text_1', 'about_text_2'
    ];

    foreach ($fields as $field) {
        $val = mysqli_real_escape_string($conn, $_POST[$field] ?? '');
        mysqli_query($conn, "INSERT INTO site_settings (setting_key, setting_value) VALUES ('$field','$val')
                             ON DUPLICATE KEY UPDATE setting_value='$val'");
    }

    $message = 'Settings saved successfully.';
}

// Load current settings
$settings = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM site_settings");
    while ($row = mysqli_fetch_assoc($res)) $settings[$row['setting_key']] = $row['setting_value'];
}

function s($settings, $key, $default = '') {
    return htmlspecialchars($settings[$key] ?? $default);
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Site Settings';
    document.getElementById('pageBreadcrumb').textContent = 'Settings';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
<div class="row g-4">
    <!-- Company Info -->
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-building me-2" style="color:#6366f1;"></i>Company Information</div>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="<?= s($settings, 'company_name', 'MantraTech') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Slogan</label>
                        <input type="text" name="company_slogan" class="form-control" value="<?= s($settings, 'company_slogan', 'We deliver what you need') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="company_email" class="form-control" value="<?= s($settings, 'company_email', 'info@mantratech.com') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="company_phone" class="form-control" value="<?= s($settings, 'company_phone', '+977 9800000000') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Office Address</label>
                        <input type="text" name="company_address" class="form-control" value="<?= s($settings, 'company_address', 'Kathmandu, Nepal') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- About Text -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-file-alt me-2" style="color:#10b981;"></i>About Section Text</div>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">About Paragraph 1</label>
                        <textarea name="about_text_1" class="form-control" rows="4"><?= s($settings, 'about_text_1') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">About Paragraph 2</label>
                        <textarea name="about_text_2" class="form-control" rows="4"><?= s($settings, 'about_text_2') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Links -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-share-alt me-2" style="color:#ec4899;"></i>Social Media Links</div>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fab fa-facebook" style="color:#1877f2;"></i> Facebook URL</label>
                        <input type="url" name="company_facebook" class="form-control" value="<?= s($settings, 'company_facebook', '#') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fab fa-twitter" style="color:#1da1f2;"></i> Twitter URL</label>
                        <input type="url" name="company_twitter" class="form-control" value="<?= s($settings, 'company_twitter', '#') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fab fa-linkedin" style="color:#0a66c2;"></i> LinkedIn URL</label>
                        <input type="url" name="company_linkedin" class="form-control" value="<?= s($settings, 'company_linkedin', '#') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fab fa-instagram" style="color:#e1306c;"></i> Instagram URL</label>
                        <input type="url" name="company_instagram" class="form-control" value="<?= s($settings, 'company_instagram', '#') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fab fa-github" style="color:#333;"></i> GitHub URL</label>
                        <input type="url" name="company_github" class="form-control" value="<?= s($settings, 'company_github', '#') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar shortcuts -->
    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <div class="admin-card-title">Quick Links</div>
            </div>
            <div class="p-3 d-grid gap-2">
                <a href="hero.php" class="btn-primary-custom" style="justify-content:center; padding:10px;">
                    <i class="fas fa-images"></i> Manage Hero Slides
                </a>
                <a href="services.php" class="btn-primary-custom" style="background:linear-gradient(135deg,#10b981,#059669); justify-content:center; padding:10px;">
                    <i class="fas fa-concierge-bell"></i> Manage Services
                </a>
                <a href="portfolio.php" class="btn-primary-custom" style="background:linear-gradient(135deg,#f59e0b,#d97706); justify-content:center; padding:10px;">
                    <i class="fas fa-briefcase"></i> Manage Portfolio
                </a>
                <a href="contacts.php" class="btn-primary-custom" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8); justify-content:center; padding:10px;">
                    <i class="fas fa-envelope"></i> View Messages
                </a>
                <a href="../index.php" target="_blank" class="btn-primary-custom" style="background:linear-gradient(135deg,#6b7280,#374151); justify-content:center; padding:10px;">
                    <i class="fas fa-external-link-alt"></i> View Website
                </a>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Admin Info</div>
            </div>
            <div class="p-4">
                <div style="font-size:14px; color:#374151; margin-bottom:12px;">
                    <i class="fas fa-user me-2" style="color:#6366f1;"></i>
                    Logged in as <strong>admin</strong>
                </div>
                <div style="font-size:13px; color:#6b7280; margin-bottom:16px;">
                    <i class="fas fa-info-circle me-2"></i>
                    To change your password, update the <code>ADMIN_PASS</code> constant in <code>config.php</code>
                </div>
                <a href="logout.php" class="btn-primary-custom" style="background:linear-gradient(135deg,#ef4444,#dc2626); justify-content:center; padding:10px;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn-primary-custom" style="padding:14px 40px; font-size:15px;">
        <i class="fas fa-save"></i> Save All Settings
    </button>
</div>
</form>

<?php require_once '_footer.php'; ?>
