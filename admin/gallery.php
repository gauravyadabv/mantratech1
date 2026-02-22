<?php
require_once '_header.php';

$message = '';
$action = $_GET['action'] ?? 'list';

// Delete
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM gallery WHERE id=$id"));
    if ($row && $row['image'] && !str_starts_with($row['image'], 'http') && file_exists(UPLOAD_PATH . $row['image'])) {
        unlink(UPLOAD_PATH . $row['image']);
    }
    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");
    $message = 'Gallery item deleted.';
    $action = 'list';
}

// Toggle
if (isset($_GET['toggle']) && $conn) {
    $id = (int)$_GET['toggle'];
    mysqli_query($conn, "UPDATE gallery SET is_active = NOT is_active WHERE id=$id");
    $message = 'Status updated.';
}

// Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id       = (int)($_POST['id'] ?? 0);
    $title    = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? 'office');
    $desc     = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $order    = (int)($_POST['display_order'] ?? 0);
    $imageUrl = mysqli_real_escape_string($conn, $_POST['image_url'] ?? '');

    $imageFile = $imageUrl;
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0777, true);
        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $fname = 'gallery_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['image_file']['tmp_name'], UPLOAD_PATH . $fname);
            $imageFile = 'uploads/' . $fname;
        }
    }

    if ($id > 0) {
        $imgSet = $imageFile ? ", image='$imageFile'" : '';
        mysqli_query($conn, "UPDATE gallery SET title='$title', category='$category', description='$desc', display_order=$order $imgSet WHERE id=$id");
        $message = 'Gallery item updated.';
    } else {
        mysqli_query($conn, "INSERT INTO gallery (title, category, description, image, display_order) VALUES ('$title','$category','$desc','$imageFile',$order)");
        $message = 'Gallery item added.';
    }
    $action = 'list';
}

$editItem = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $res = mysqli_query($conn, "SELECT * FROM gallery WHERE id=".(int)$_GET['id']);
    $editItem = mysqli_fetch_assoc($res);
}

$items = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM gallery ORDER BY display_order, created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
}

$categories = ['office', 'team', 'event', 'work', 'meeting', 'award'];
?>

<script>
    document.getElementById('pageTitle').textContent = 'Gallery';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Gallery';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="row">
    <div class="col-lg-7">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border:1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editItem ? 'Edit Gallery Item' : 'Add Gallery Photo' ?></div>
            <a href="gallery.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="form-card" style="border-radius:0 0 16px 16px;">
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editItem): ?><input type="hidden" name="id" value="<?= $editItem['id'] ?>"><?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Photo Title *</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($editItem['category'] ?? '') === $cat ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Upload Photo</label>
                        <input type="file" name="image_file" class="form-control mb-2" accept="image/*">
                        <small class="text-muted">Or paste image URL:</small>
                        <input type="url" name="image_url" class="form-control mt-1" value="<?= htmlspecialchars(str_starts_with($editItem['image'] ?? '', 'http') ? $editItem['image'] : '') ?>" placeholder="https://...">
                        <?php if ($editItem && $editItem['image']): ?>
                        <div class="mt-2">
                            <?php $imgSrc = str_starts_with($editItem['image'], 'http') ? $editItem['image'] : '../assets/images/'.$editItem['image']; ?>
                            <img src="<?= htmlspecialchars($imgSrc) ?>" style="max-height:100px; border-radius:8px;" onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" min="0" value="<?= $editItem['display_order'] ?? 0 ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?= $editItem ? 'Update Photo' : 'Add Photo' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Gallery Photos (<?= count($items) ?>)</div>
        <a href="gallery.php?action=add" class="btn-primary-custom"><i class="fas fa-plus"></i> Add Photo</a>
    </div>
    <div class="row g-3 p-4">
        <?php foreach ($items as $item): ?>
        <div class="col-lg-3 col-md-4 col-6">
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                <?php $imgSrc = str_starts_with($item['image'], 'http') ? $item['image'] : '../assets/images/'.$item['image']; ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" style="width:100%; height:140px; object-fit:cover;" onerror="this.src='https://via.placeholder.com/300x160?text=No+Image'">
                <div style="padding:12px;">
                    <div style="font-size:13px; font-weight:600; margin-bottom:2px;"><?= htmlspecialchars($item['title']) ?></div>
                    <div style="font-size:11px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;"><?= $item['category'] ?></div>
                    <div class="d-flex gap-1">
                        <a href="gallery.php?action=edit&id=<?= $item['id'] ?>" class="btn-sm-icon btn-edit" style="flex:1; width:auto; border-radius:6px;"><i class="fas fa-pen"></i></a>
                        <a href="gallery.php?toggle=<?= $item['id'] ?>" class="btn-sm-icon btn-toggle" style="flex:1; width:auto; border-radius:6px;">
                            <i class="fas fa-<?= $item['is_active'] ? 'eye' : 'eye-slash' ?>"></i>
                        </a>
                        <a href="gallery.php?delete=<?= $item['id'] ?>" class="btn-sm-icon btn-delete" style="flex:1; width:auto; border-radius:6px;" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($items)): ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="fas fa-images" style="font-size:36px; opacity:0.3; display:block; margin-bottom:12px;"></i>
            No gallery items. <a href="gallery.php?action=add">Add your first photo</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once '_footer.php'; ?>
