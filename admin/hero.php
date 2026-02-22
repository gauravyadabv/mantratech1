<?php
require_once '_header.php';

$message = '';
$error = '';

// Handle actions
$action = $_GET['action'] ?? 'list';

// ── Delete ────────────────────────────────────────────
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    // Delete associated image file
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT media FROM hero_slides WHERE id=$id"));
    if ($row && $row['media'] && file_exists(HERO_UPLOAD_PATH . $row['media'])) {
        unlink(HERO_UPLOAD_PATH . $row['media']);
    }
    mysqli_query($conn, "DELETE FROM hero_slides WHERE id=$id");
    $message = 'Hero slide deleted successfully.';
    $action = 'list';
}

// ── Toggle Active ─────────────────────────────────────
if (isset($_GET['toggle']) && $conn) {
    $id = (int)$_GET['toggle'];
    mysqli_query($conn, "UPDATE hero_slides SET is_active = NOT is_active WHERE id=$id");
    $message = 'Status updated.';
}

// ── Save/Update ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id         = (int)($_POST['id'] ?? 0);
    $title      = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $subtitle   = mysqli_real_escape_string($conn, $_POST['subtitle'] ?? '');
    $type       = in_array($_POST['type'] ?? '', ['image','video']) ? $_POST['type'] : 'image';
    $btn_text   = mysqli_real_escape_string($conn, $_POST['button_text'] ?? 'Get Started');
    $btn_link   = mysqli_real_escape_string($conn, $_POST['button_link'] ?? '#contact');
    $order      = (int)($_POST['display_order'] ?? 0);

    // Handle file upload
    $mediaFile = '';
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === 0) {
        if (!is_dir(HERO_UPLOAD_PATH)) mkdir(HERO_UPLOAD_PATH, 0777, true);
        $ext = strtolower(pathinfo($_FILES['media_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp','mp4','webm'];
        if (in_array($ext, $allowed)) {
            $mediaFile = 'hero_' . time() . '_' . rand(100, 999) . '.' . $ext;
            move_uploaded_file($_FILES['media_file']['tmp_name'], HERO_UPLOAD_PATH . $mediaFile);
        }
    }

    if ($id > 0) {
        // Update
        $updateMedia = $mediaFile ? ", media='$mediaFile'" : '';
        mysqli_query($conn, "UPDATE hero_slides SET title='$title', subtitle='$subtitle', type='$type', button_text='$btn_text', button_link='$btn_link', display_order=$order $updateMedia WHERE id=$id");
        $message = 'Hero slide updated successfully.';
    } else {
        // Insert
        $media = $mediaFile ?: 'hero1.jpg';
        mysqli_query($conn, "INSERT INTO hero_slides (title, subtitle, type, media, button_text, button_link, display_order) VALUES ('$title', '$subtitle', '$type', '$media', '$btn_text', '$btn_link', $order)");
        $message = 'Hero slide added successfully.';
    }
    $action = 'list';
}

// ── Edit mode: fetch existing ─────────────────────────
$editSlide = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM hero_slides WHERE id=$id");
    $editSlide = mysqli_fetch_assoc($res);
}

// ── Fetch all slides ──────────────────────────────────
$slides = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM hero_slides ORDER BY display_order, id");
    while ($row = mysqli_fetch_assoc($res)) $slides[] = $row;
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Hero Slides';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Hero';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ── Form ──────────────────────────────────────────────── -->
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border: 1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editSlide ? 'Edit Hero Slide' : 'Add New Hero Slide' ?></div>
            <a href="hero.php" class="btn-primary-custom" style="background: #6b7280; padding: 7px 14px; font-size:13px;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-card" style="border-radius: 0 0 16px 16px;">
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editSlide): ?>
                <input type="hidden" name="id" value="<?= $editSlide['id'] ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Slide Title *</label>
                        <input type="text" name="title" class="form-control" required
                               value="<?= htmlspecialchars($editSlide['title'] ?? '') ?>"
                               placeholder="e.g. Digital Transformation Experts">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Subtitle</label>
                        <textarea name="subtitle" class="form-control" rows="3"
                                  placeholder="Brief description for this slide"><?= htmlspecialchars($editSlide['subtitle'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Media Type</label>
                        <select name="type" class="form-select">
                            <option value="image" <?= ($editSlide['type'] ?? '') === 'image' ? 'selected' : '' ?>>Image</option>
                            <option value="video" <?= ($editSlide['type'] ?? '') === 'video' ? 'selected' : '' ?>>Video</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" min="0"
                               value="<?= $editSlide['display_order'] ?? 0 ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Upload Image/Video</label>
                        <input type="file" name="media_file" class="form-control" accept="image/*,video/mp4">
                        <?php if ($editSlide && $editSlide['media']): ?>
                            <div class="mt-2">
                                <small class="text-muted">Current: <strong><?= htmlspecialchars($editSlide['media']) ?></strong></small><br>
                                <?php if (in_array(strtolower(pathinfo($editSlide['media'], PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp'])): ?>
                                    <?php 
                                    $imgUrl = file_exists(HERO_UPLOAD_PATH . $editSlide['media']) 
                                        ? '../'.HERO_UPLOAD_URL.$editSlide['media']
                                        : 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=400&auto=format&fit=crop&q=60';
                                    ?>
                                    <img src="<?= $imgUrl ?>" alt="Current" style="max-height:100px; margin-top:8px; border-radius:8px;">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button_text" class="form-control"
                               value="<?= htmlspecialchars($editSlide['button_text'] ?? 'Get Started') ?>"
                               placeholder="Get Started">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Button Link</label>
                        <input type="text" name="button_link" class="form-control"
                               value="<?= htmlspecialchars($editSlide['button_link'] ?? '#contact') ?>"
                               placeholder="#contact">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-save"></i>
                            <?= $editSlide ? 'Update Slide' : 'Add Slide' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<!-- ── List ──────────────────────────────────────────────── -->
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Hero Slides</div>
        <a href="hero.php?action=add" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Add Slide
        </a>
    </div>
    <?php if (empty($slides)): ?>
    <div class="p-5 text-center text-muted">
        <i class="fas fa-image" style="font-size: 36px; opacity: 0.3; display: block; margin-bottom: 12px;"></i>
        No hero slides found. <a href="hero.php?action=add">Add your first slide</a>
    </div>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:80px;">Preview</th>
                <th>Title</th>
                <th>Type</th>
                <th>Order</th>
                <th>Status</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($slides as $slide): ?>
            <tr>
                <td>
                    <?php
                    $ext = strtolower(pathinfo($slide['media'] ?? '', PATHINFO_EXTENSION));
                    $isImg = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                    $imgSrc = file_exists(HERO_UPLOAD_PATH . $slide['media']) 
                        ? '../'.HERO_UPLOAD_URL.htmlspecialchars($slide['media'])
                        : 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=200&auto=format&fit=crop&q=60';
                    ?>
                    <?php if ($isImg): ?>
                    <img src="<?= $imgSrc ?>" style="width:64px; height:40px; object-fit:cover; border-radius:6px;">
                    <?php else: ?>
                    <div style="width:64px; height:40px; background:#f0e7ff; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#8b5cf6;">
                        <i class="fas fa-film"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?= htmlspecialchars($slide['title']) ?></strong><br>
                    <small style="color:#6b7280;"><?= htmlspecialchars(substr($slide['subtitle'] ?? '', 0, 60)) ?></small>
                </td>
                <td><span style="font-size:12px; text-transform:uppercase; color:#6b7280;"><?= $slide['type'] ?></span></td>
                <td><?= $slide['display_order'] ?></td>
                <td>
                    <?php if ($slide['is_active']): ?>
                        <span class="badge-active">Active</span>
                    <?php else: ?>
                        <span class="badge-inactive">Hidden</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="hero.php?action=edit&id=<?= $slide['id'] ?>" class="btn-sm-icon btn-edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <a href="hero.php?toggle=<?= $slide['id'] ?>" class="btn-sm-icon btn-toggle" title="Toggle"><i class="fas fa-eye"></i></a>
                        <a href="hero.php?delete=<?= $slide['id'] ?>" class="btn-sm-icon btn-delete" title="Delete"
                           onclick="return confirm('Delete this slide?')"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php require_once '_footer.php'; ?>
