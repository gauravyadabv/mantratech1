<?php
require_once '_header.php';

$message = '';
$action = $_GET['action'] ?? 'list';

// Delete
if (isset($_GET['delete']) && $conn) {
    mysqli_query($conn, "DELETE FROM technologies WHERE id=".(int)$_GET['delete']);
    $message = 'Technology deleted.';
    $action = 'list';
}

// Toggle
if (isset($_GET['toggle']) && $conn) {
    mysqli_query($conn, "UPDATE technologies SET is_active = NOT is_active WHERE id=".(int)$_GET['toggle']);
    $message = 'Status updated.';
}

// Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id       = (int)($_POST['id'] ?? 0);
    $name     = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $icon     = mysqli_real_escape_string($conn, $_POST['icon'] ?? 'fas fa-cog');
    $color    = mysqli_real_escape_string($conn, $_POST['color'] ?? '#6366f1');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? 'other');
    $order    = (int)($_POST['display_order'] ?? 0);

    if ($id > 0) {
        mysqli_query($conn, "UPDATE technologies SET name='$name', icon='$icon', color='$color', category='$category', display_order=$order WHERE id=$id");
        $message = 'Technology updated.';
    } else {
        mysqli_query($conn, "INSERT INTO technologies (name, icon, color, category, display_order) VALUES ('$name','$icon','$color','$category',$order)");
        $message = 'Technology added.';
    }
    $action = 'list';
}

$editItem = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $res = mysqli_query($conn, "SELECT * FROM technologies WHERE id=".(int)$_GET['id']);
    $editItem = mysqli_fetch_assoc($res);
}

$items = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM technologies ORDER BY category, display_order");
    while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
}

$categories = ['frontend', 'backend', 'mobile', 'database', 'cloud', 'devops', 'tools', 'cms', 'other'];
?>

<script>
    document.getElementById('pageTitle').textContent = 'Technologies';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Technologies';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="row">
    <div class="col-lg-6">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border:1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editItem ? 'Edit Technology' : 'Add Technology' ?></div>
            <a href="technologies.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="form-card" style="border-radius:0 0 16px 16px;">
            <form method="POST">
                <?php if ($editItem): ?><input type="hidden" name="id" value="<?= $editItem['id'] ?>"><?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($editItem['name'] ?? '') ?>" placeholder="e.g. React">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($editItem['category'] ?? '') === $cat ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">FontAwesome Icon Class</label>
                        <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($editItem['icon'] ?? 'fas fa-code') ?>" placeholder="fab fa-react" id="iconInput" oninput="updatePreview()">
                        <div class="mt-2">
                            Preview: <i id="iconPreview" class="<?= htmlspecialchars($editItem['icon'] ?? 'fas fa-code') ?>" style="font-size:24px; color:<?= htmlspecialchars($editItem['color'] ?? '#6366f1') ?>;"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Brand Color</label>
                        <input type="color" name="color" class="form-control" style="height:42px;" value="<?= htmlspecialchars($editItem['color'] ?? '#6366f1') ?>" id="colorInput" oninput="updatePreview()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= $editItem['display_order'] ?? 0 ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> <?= $editItem ? 'Update' : 'Add Technology' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Technologies (<?= count($items) ?>)</div>
        <a href="technologies.php?action=add" class="btn-primary-custom"><i class="fas fa-plus"></i> Add Tech</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Icon</th><th>Name</th><th>Category</th><th>Color</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><i class="<?= htmlspecialchars($item['icon']) ?>" style="font-size:22px; color:<?= htmlspecialchars($item['color']) ?>;"></i></td>
                <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                <td><span style="font-size:12px; text-transform:uppercase; color:#6b7280;"><?= $item['category'] ?></span></td>
                <td>
                    <div style="width:24px; height:24px; background:<?= htmlspecialchars($item['color']) ?>; border-radius:50%; display:inline-block; vertical-align:middle;"></div>
                    <span style="font-size:12px; margin-left:6px;"><?= htmlspecialchars($item['color']) ?></span>
                </td>
                <td><?= $item['display_order'] ?></td>
                <td><?= $item['is_active'] ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Hidden</span>' ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="technologies.php?action=edit&id=<?= $item['id'] ?>" class="btn-sm-icon btn-edit"><i class="fas fa-pen"></i></a>
                        <a href="technologies.php?toggle=<?= $item['id'] ?>" class="btn-sm-icon btn-toggle"><i class="fas fa-eye"></i></a>
                        <a href="technologies.php?delete=<?= $item['id'] ?>" class="btn-sm-icon btn-delete" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
function updatePreview() {
    const icon = document.getElementById('iconInput').value;
    const color = document.getElementById('colorInput').value;
    const preview = document.getElementById('iconPreview');
    if (preview) {
        preview.className = icon;
        preview.style.color = color;
    }
}
</script>

<?php require_once '_footer.php'; ?>
