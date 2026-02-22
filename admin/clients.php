<?php
require_once '_header.php';

$message = '';
$action = $_GET['action'] ?? 'list';

// Delete
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    if ($conn) {
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT logo FROM clients WHERE id=$id"));
        if ($row && $row['logo'] && !str_starts_with($row['logo'], 'http') && file_exists(UPLOAD_PATH . $row['logo'])) {
            unlink(UPLOAD_PATH . $row['logo']);
        }
    }
    mysqli_query($conn, "DELETE FROM clients WHERE id=$id");
    $message = 'Client deleted.';
    $action = 'list';
}

// Toggle
if (isset($_GET['toggle']) && $conn) {
    mysqli_query($conn, "UPDATE clients SET is_active = NOT is_active WHERE id=".(int)$_GET['toggle']);
    $message = 'Status updated.';
}

// Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id      = (int)($_POST['id'] ?? 0);
    $name    = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $website = mysqli_real_escape_string($conn, $_POST['website'] ?? '');
    $order   = (int)($_POST['display_order'] ?? 0);
    $logoUrl = mysqli_real_escape_string($conn, $_POST['logo_url'] ?? '');

    $logoFile = $logoUrl;
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === 0) {
        if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0777, true);
        $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp','svg'])) {
            $fname = 'client_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['logo_file']['tmp_name'], UPLOAD_PATH . $fname);
            $logoFile = 'uploads/' . $fname;
        }
    }

    if ($id > 0) {
        $logoSet = $logoFile ? ", logo='$logoFile'" : '';
        mysqli_query($conn, "UPDATE clients SET name='$name', website='$website', display_order=$order $logoSet WHERE id=$id");
        $message = 'Client updated.';
    } else {
        mysqli_query($conn, "INSERT INTO clients (name, logo, website, display_order) VALUES ('$name','$logoFile','$website',$order)");
        $message = 'Client added.';
    }
    $action = 'list';
}

$editItem = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $res = mysqli_query($conn, "SELECT * FROM clients WHERE id=".(int)$_GET['id']);
    $editItem = mysqli_fetch_assoc($res);
}

$items = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM clients ORDER BY display_order, name");
    while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Clients';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Clients';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="row">
    <div class="col-lg-6">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border:1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editItem ? 'Edit Client' : 'Add New Client' ?></div>
            <a href="clients.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="form-card" style="border-radius:0 0 16px 16px;">
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editItem): ?><input type="hidden" name="id" value="<?= $editItem['id'] ?>"><?php endif; ?>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Client Name *</label>
                        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($editItem['name'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Website URL</label>
                        <input type="url" name="website" class="form-control" value="<?= htmlspecialchars($editItem['website'] ?? '') ?>" placeholder="https://client.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Upload Logo</label>
                        <input type="file" name="logo_file" class="form-control mb-2" accept="image/*">
                        <small class="text-muted">Or paste logo URL:</small>
                        <input type="url" name="logo_url" class="form-control mt-1" value="<?= htmlspecialchars(str_starts_with($editItem['logo'] ?? '', 'http') ? $editItem['logo'] : '') ?>" placeholder="https://...">
                        <?php if ($editItem && $editItem['logo']): ?>
                        <div class="mt-2">
                            <?php $imgSrc = str_starts_with($editItem['logo'], 'http') ? $editItem['logo'] : '../assets/images/'.$editItem['logo']; ?>
                            <img src="<?= htmlspecialchars($imgSrc) ?>" style="max-height:60px; border-radius:6px;" onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= $editItem['display_order'] ?? 0 ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?= $editItem ? 'Update Client' : 'Add Client' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Clients (<?= count($items) ?>)</div>
        <a href="clients.php?action=add" class="btn-primary-custom"><i class="fas fa-plus"></i> Add Client</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Logo</th><th>Name</th><th>Website</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?php if ($item['logo']): ?>
                        <?php $imgSrc = str_starts_with($item['logo'], 'http') ? $item['logo'] : '../assets/images/'.$item['logo']; ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" style="max-width:80px; max-height:40px; object-fit:contain;" onerror="this.src='https://via.placeholder.com/80x40?text=Logo'">
                    <?php else: ?>
                        <div style="width:80px; height:40px; background:#f0e7ff; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px; color:#8b5cf6;"><?= strtoupper(substr($item['name'], 0, 2)) ?></div>
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                <td><?= $item['website'] ? '<a href="'.htmlspecialchars($item['website']).'" target="_blank" style="font-size:12px; color:#6366f1;">'.htmlspecialchars($item['website']).'</a>' : '<span style="color:#9ca3af; font-size:12px;">—</span>' ?></td>
                <td><?= $item['display_order'] ?></td>
                <td><?= $item['is_active'] ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Hidden</span>' ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="clients.php?action=edit&id=<?= $item['id'] ?>" class="btn-sm-icon btn-edit"><i class="fas fa-pen"></i></a>
                        <a href="clients.php?toggle=<?= $item['id'] ?>" class="btn-sm-icon btn-toggle"><i class="fas fa-eye"></i></a>
                        <a href="clients.php?delete=<?= $item['id'] ?>" class="btn-sm-icon btn-delete" onclick="return confirm('Delete this client?')"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once '_footer.php'; ?>
