<?php
require_once '_header.php';

$message = '';
$action = $_GET['action'] ?? 'list';

// Delete
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM portfolio WHERE id=$id"));
    if ($row && $row['image'] && !str_starts_with($row['image'], 'http') && file_exists(UPLOAD_PATH . $row['image'])) {
        unlink(UPLOAD_PATH . $row['image']);
    }
    mysqli_query($conn, "DELETE FROM portfolio WHERE id=$id");
    $message = 'Portfolio item deleted.';
    $action = 'list';
}

// Toggle
if (isset($_GET['toggle']) && $conn) {
    $id = (int)$_GET['toggle'];
    mysqli_query($conn, "UPDATE portfolio SET is_featured = NOT is_featured WHERE id=$id");
    $message = 'Status updated.';
}

// Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id       = (int)($_POST['id'] ?? 0);
    $title    = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $client   = mysqli_real_escape_string($conn, $_POST['client'] ?? '');
    $desc     = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $tech     = mysqli_real_escape_string($conn, $_POST['technologies'] ?? '');
    $url      = mysqli_real_escape_string($conn, $_POST['project_url'] ?? '');
    $order    = (int)($_POST['display_order'] ?? 0);
    $imageUrl = mysqli_real_escape_string($conn, $_POST['image_url'] ?? '');

    $imageFile = $imageUrl;
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0777, true);
        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $fname = 'portfolio_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['image_file']['tmp_name'], UPLOAD_PATH . $fname);
            $imageFile = 'uploads/' . $fname;
        }
    }

    if ($id > 0) {
        $imgSet = $imageFile ? ", image='$imageFile'" : '';
        mysqli_query($conn, "UPDATE portfolio SET title='$title', category='$category', client='$client', description='$desc', technologies='$tech', project_url='$url', display_order=$order $imgSet WHERE id=$id");
        $message = 'Project updated.';
    } else {
        mysqli_query($conn, "INSERT INTO portfolio (title, category, client, description, image, technologies, project_url, display_order) VALUES ('$title','$category','$client','$desc','$imageFile','$tech','$url',$order)");
        $message = 'Project added.';
    }
    $action = 'list';
}

$editItem = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $res = mysqli_query($conn, "SELECT * FROM portfolio WHERE id=".(int)$_GET['id']);
    $editItem = mysqli_fetch_assoc($res);
}

$items = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY display_order, created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Portfolio';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Portfolio';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border:1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editItem ? 'Edit Project' : 'Add Portfolio Project' ?></div>
            <a href="portfolio.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="form-card" style="border-radius: 0 0 16px 16px;">
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editItem): ?><input type="hidden" name="id" value="<?= $editItem['id'] ?>"><?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Project Title *</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <?php foreach (['web'=>'Web', 'mobile'=>'Mobile', 'ecommerce'=>'E-commerce', 'design'=>'UI/UX', 'other'=>'Other'] as $val => $label): ?>
                            <option value="<?= $val ?>" <?= ($editItem['category'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="client" class="form-control" value="<?= htmlspecialchars($editItem['client'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Project URL</label>
                        <input type="url" name="project_url" class="form-control" value="<?= htmlspecialchars($editItem['project_url'] ?? '') ?>" placeholder="https://...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Technologies Used</label>
                        <input type="text" name="technologies" class="form-control" value="<?= htmlspecialchars($editItem['technologies'] ?? '') ?>" placeholder="PHP, React, MySQL">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Project Image</label>
                        <input type="file" name="image_file" class="form-control mb-2" accept="image/*">
                        <small class="text-muted">Or paste image URL:</small>
                        <input type="url" name="image_url" class="form-control mt-1" value="<?= htmlspecialchars(str_starts_with($editItem['image'] ?? '', 'http') ? $editItem['image'] : '') ?>" placeholder="https://example.com/image.jpg">
                        <?php if ($editItem && $editItem['image']): ?>
                        <div class="mt-2">
                            <?php $imgSrc = str_starts_with($editItem['image'], 'http') ? $editItem['image'] : '../assets/images/'.$editItem['image']; ?>
                            <img src="<?= htmlspecialchars($imgSrc) ?>" style="max-height:80px; border-radius:8px;" onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" min="0" value="<?= $editItem['display_order'] ?? 0 ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?= $editItem ? 'Update Project' : 'Add Project' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Portfolio Projects (<?= count($items) ?>)</div>
        <a href="portfolio.php?action=add" class="btn-primary-custom"><i class="fas fa-plus"></i> Add Project</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr><th>Image</th><th>Title</th><th>Category</th><th>Client</th><th>Featured</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?php $imgSrc = str_starts_with($item['image'], 'http') ? $item['image'] : '../assets/images/'.$item['image']; ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" style="width:60px;height:40px;object-fit:cover;border-radius:6px;" onerror="this.src='https://via.placeholder.com/60x40?text=N/A'">
                    </td>
                    <td><strong><?= htmlspecialchars($item['title']) ?></strong></td>
                    <td><span style="font-size:12px; text-transform:uppercase; color:#6b7280;"><?= htmlspecialchars($item['category']) ?></span></td>
                    <td><?= htmlspecialchars($item['client']) ?></td>
                    <td><?= $item['is_featured'] ? '<span class="badge-active">Yes</span>' : '<span class="badge-inactive">No</span>' ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="portfolio.php?action=edit&id=<?= $item['id'] ?>" class="btn-sm-icon btn-edit"><i class="fas fa-pen"></i></a>
                            <a href="portfolio.php?toggle=<?= $item['id'] ?>" class="btn-sm-icon btn-toggle"><i class="fas fa-star"></i></a>
                            <a href="portfolio.php?delete=<?= $item['id'] ?>" class="btn-sm-icon btn-delete" onclick="return confirm('Delete this project?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once '_footer.php'; ?>
