<?php
require_once '_header.php';

$message = '';
$action = $_GET['action'] ?? 'list';

// Delete
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
    $message = 'Service deleted.';
    $action = 'list';
}

// Toggle
if (isset($_GET['toggle']) && $conn) {
    $id = (int)$_GET['toggle'];
    mysqli_query($conn, "UPDATE services SET is_active = NOT is_active WHERE id=$id");
    $message = 'Status updated.';
}

// Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {
    $id    = (int)($_POST['id'] ?? 0);
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $desc  = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $icon  = mysqli_real_escape_string($conn, $_POST['icon'] ?? 'fas fa-cog');
    $order = (int)($_POST['display_order'] ?? 0);

    if ($id > 0) {
        mysqli_query($conn, "UPDATE services SET title='$title', description='$desc', icon='$icon', display_order=$order WHERE id=$id");
        $message = 'Service updated.';
    } else {
        mysqli_query($conn, "INSERT INTO services (title, description, icon, display_order) VALUES ('$title','$desc','$icon',$order)");
        $message = 'Service added.';
    }
    $action = 'list';
}

$editItem = null;
if ($action === 'edit' && isset($_GET['id']) && $conn) {
    $res = mysqli_query($conn, "SELECT * FROM services WHERE id=".(int)$_GET['id']);
    $editItem = mysqli_fetch_assoc($res);
}

$items = [];
if ($conn) {
    $res = mysqli_query($conn, "SELECT * FROM services ORDER BY display_order, id");
    while ($row = mysqli_fetch_assoc($res)) $items[] = $row;
}

$iconOptions = [
    'fas fa-code' => 'Web Development',
    'fas fa-mobile-alt' => 'Mobile App',
    'fas fa-paint-brush' => 'UI/UX Design',
    'fas fa-shopping-cart' => 'E-commerce',
    'fas fa-cloud' => 'Cloud',
    'fas fa-chart-line' => 'Marketing',
    'fas fa-robot' => 'AI/ML',
    'fas fa-shield-alt' => 'Security',
    'fas fa-database' => 'Database',
    'fas fa-server' => 'Server',
    'fas fa-network-wired' => 'Network',
    'fas fa-cog' => 'General',
];
?>

<script>
    document.getElementById('pageTitle').textContent = 'Services';
    document.getElementById('pageBreadcrumb').textContent = 'Content / Services';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="row">
    <div class="col-lg-7">
        <div class="admin-card-header" style="background:#fff; border-radius:16px 16px 0 0; border:1px solid #e5e7eb; border-bottom:none;">
            <div class="admin-card-title"><?= $editItem ? 'Edit Service' : 'Add New Service' ?></div>
            <a href="services.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-card" style="border-radius:0 0 16px 16px;">
            <form method="POST">
                <?php if ($editItem): ?><input type="hidden" name="id" value="<?= $editItem['id'] ?>"><?php endif; ?>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Service Title *</label>
                        <input type="text" name="title" class="form-control" required
                               value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" placeholder="e.g. Web Development">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" rows="4" required
                                  placeholder="Short description of this service..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Icon Class (FontAwesome)</label>
                        <select name="icon" class="form-select" id="iconSelect" onchange="updatePreview()">
                            <?php foreach ($iconOptions as $cls => $label): ?>
                            <option value="<?= $cls ?>" <?= ($editItem['icon'] ?? '') === $cls ? 'selected' : '' ?>><?= $label ?> (<?= $cls ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="icon" id="iconManual" class="form-control mt-2"
                               value="<?= htmlspecialchars($editItem['icon'] ?? 'fas fa-cog') ?>"
                               placeholder="Or type custom: fas fa-star" onchange="document.getElementById('iconPreview').className=this.value">
                        <div class="mt-2" style="font-size:13px; color:#6b7280;">
                            Preview: <i id="iconPreview" class="<?= htmlspecialchars($editItem['icon'] ?? 'fas fa-cog') ?>" style="font-size:24px; color:#6366f1;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" min="0"
                               value="<?= $editItem['display_order'] ?? count($items) + 1 ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-save"></i> <?= $editItem ? 'Update Service' : 'Add Service' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php else: ?>
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">All Services (<?= count($items) ?>)</div>
        <a href="services.php?action=add" class="btn-primary-custom"><i class="fas fa-plus"></i> Add Service</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><i class="<?= htmlspecialchars($item['icon']) ?>" style="font-size:20px; color:#6366f1;"></i></td>
                <td><strong><?= htmlspecialchars($item['title']) ?></strong></td>
                <td style="max-width:300px;"><small style="color:#6b7280;"><?= htmlspecialchars(substr($item['description'], 0, 80)) ?>...</small></td>
                <td><?= $item['display_order'] ?></td>
                <td><?= $item['is_active'] ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Hidden</span>' ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="services.php?action=edit&id=<?= $item['id'] ?>" class="btn-sm-icon btn-edit"><i class="fas fa-pen"></i></a>
                        <a href="services.php?toggle=<?= $item['id'] ?>" class="btn-sm-icon btn-toggle"><i class="fas fa-eye"></i></a>
                        <a href="services.php?delete=<?= $item['id'] ?>" class="btn-sm-icon btn-delete"
                           onclick="return confirm('Delete this service?')"><i class="fas fa-trash"></i></a>
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
    const select = document.getElementById('iconSelect');
    const manual = document.getElementById('iconManual');
    const preview = document.getElementById('iconPreview');
    manual.value = select.value;
    preview.className = select.value;
}
</script>

<?php require_once '_footer.php'; ?>
