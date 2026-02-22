<?php
require_once '_header.php';

$message = '';

// Delete
if (isset($_GET['delete']) && $conn) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id=$id");
    $message = 'Message deleted.';
}

// Mark as read
if (isset($_GET['read']) && $conn) {
    mysqli_query($conn, "UPDATE contact_messages SET is_read=1 WHERE id=".(int)$_GET['read']);
    $message = 'Marked as read.';
}

// Mark as unread
if (isset($_GET['unread']) && $conn) {
    mysqli_query($conn, "UPDATE contact_messages SET is_read=0 WHERE id=".(int)$_GET['unread']);
}

// Delete all read
if (isset($_GET['delete_read']) && $conn) {
    mysqli_query($conn, "DELETE FROM contact_messages WHERE is_read=1");
    $message = 'All read messages deleted.';
}

// Mark all as read
if (isset($_GET['read_all']) && $conn) {
    mysqli_query($conn, "UPDATE contact_messages SET is_read=1");
    $message = 'All messages marked as read.';
}

// Viewing a single message
$viewMessage = null;
if (isset($_GET['view']) && $conn) {
    $id = (int)$_GET['view'];
    $res = mysqli_query($conn, "SELECT * FROM contact_messages WHERE id=$id");
    $viewMessage = mysqli_fetch_assoc($res);
    if ($viewMessage) {
        mysqli_query($conn, "UPDATE contact_messages SET is_read=1 WHERE id=$id");
    }
}

// Fetch messages
$filter = $_GET['filter'] ?? 'all';
$whereClause = '';
if ($filter === 'unread') $whereClause = 'WHERE is_read=0';
elseif ($filter === 'read') $whereClause = 'WHERE is_read=1';

$messages = [];
$totalCount = 0;
$unreadCount = 0;

if ($conn) {
    $countRes = mysqli_query($conn, "SELECT COUNT(*) FROM contact_messages");
    $totalCount = mysqli_fetch_row($countRes)[0] ?? 0;

    $unreadRes = mysqli_query($conn, "SELECT COUNT(*) FROM contact_messages WHERE is_read=0");
    $unreadCount = mysqli_fetch_row($unreadRes)[0] ?? 0;

    $res = mysqli_query($conn, "SELECT * FROM contact_messages $whereClause ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) $messages[] = $row;
}
?>

<script>
    document.getElementById('pageTitle').textContent = 'Contact Messages';
    document.getElementById('pageBreadcrumb').textContent = 'Communication / Messages';
</script>

<?php if ($message): ?>
<div class="alert-success-custom auto-dismiss mb-4"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($viewMessage): ?>
<!-- Single Message View -->
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <div>
                    <div class="admin-card-title"><?= htmlspecialchars($viewMessage['subject'] ?? 'No Subject') ?></div>
                    <div style="font-size:12px; color:#6b7280; margin-top:4px;"><?= date('F d, Y \a\t h:i A', strtotime($viewMessage['created_at'])) ?></div>
                </div>
                <a href="contacts.php" class="btn-primary-custom" style="background:#6b7280; padding:7px 14px; font-size:13px;"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <div style="padding: 28px;">
                <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid #f3f4f6;">
                    <div style="width:52px; height:52px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; font-weight:600; flex-shrink:0;">
                        <?= strtoupper(substr($viewMessage['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-size:16px; font-weight:600; color:#111827;"><?= htmlspecialchars($viewMessage['name']) ?></div>
                        <a href="mailto:<?= htmlspecialchars($viewMessage['email']) ?>" style="color:#6366f1; font-size:14px; text-decoration:none;">
                            <?= htmlspecialchars($viewMessage['email']) ?>
                        </a>
                    </div>
                </div>

                <div style="font-size:15px; line-height:1.8; color:#374151; white-space:pre-wrap;"><?= htmlspecialchars($viewMessage['message']) ?></div>

                <div style="margin-top:28px; padding-top:20px; border-top:1px solid #f3f4f6; display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="mailto:<?= htmlspecialchars($viewMessage['email']) ?>" class="btn-primary-custom">
                        <i class="fas fa-reply"></i> Reply via Email
                    </a>
                    <?php if ($viewMessage['is_read']): ?>
                    <a href="contacts.php?unread=<?= $viewMessage['id'] ?>&view=<?= $viewMessage['id'] ?>" class="btn-primary-custom" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <i class="fas fa-envelope"></i> Mark as Unread
                    </a>
                    <?php endif; ?>
                    <a href="contacts.php?delete=<?= $viewMessage['id'] ?>" class="btn-primary-custom" style="background:linear-gradient(135deg,#ef4444,#dc2626);"
                       onclick="return confirm('Delete this message?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Messages List -->
<!-- Stats Bar -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number"><?= $totalCount ?></div>
            <div class="stat-label">Total Messages</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number" style="color:#ef4444;"><?= $unreadCount ?></div>
            <div class="stat-label">Unread</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number" style="color:#10b981;"><?= $totalCount - $unreadCount ?></div>
            <div class="stat-label">Read</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="admin-card-title">Messages</div>
            <div class="d-flex gap-2">
                <a href="contacts.php?filter=all" class="btn-primary-custom" style="padding:5px 12px; font-size:12px; <?= $filter !== 'all' ? 'background:#e5e7eb; color:#374151;' : '' ?>">All</a>
                <a href="contacts.php?filter=unread" class="btn-primary-custom" style="padding:5px 12px; font-size:12px; <?= $filter !== 'unread' ? 'background:#e5e7eb; color:#374151;' : 'background:linear-gradient(135deg,#ef4444,#dc2626);' ?>">Unread <?= $unreadCount > 0 ? "($unreadCount)" : '' ?></a>
                <a href="contacts.php?filter=read" class="btn-primary-custom" style="padding:5px 12px; font-size:12px; <?= $filter !== 'read' ? 'background:#e5e7eb; color:#374151;' : 'background:linear-gradient(135deg,#10b981,#059669);' ?>">Read</a>
            </div>
        </div>
        <div class="d-flex gap-2">
            <?php if ($unreadCount > 0): ?>
            <a href="contacts.php?read_all=1" class="btn-primary-custom" style="background:linear-gradient(135deg,#10b981,#059669); padding:7px 14px; font-size:12px;"
               onclick="return confirm('Mark all as read?')">
                <i class="fas fa-check-double"></i> Mark All Read
            </a>
            <?php endif; ?>
            <a href="contacts.php?delete_read=1" class="btn-primary-custom" style="background:linear-gradient(135deg,#ef4444,#dc2626); padding:7px 14px; font-size:12px;"
               onclick="return confirm('Delete all read messages?')">
                <i class="fas fa-trash"></i> Delete Read
            </a>
        </div>
    </div>

    <?php if (empty($messages)): ?>
    <div class="p-5 text-center text-muted">
        <i class="fas fa-inbox" style="font-size:48px; opacity:0.2; display:block; margin-bottom:16px;"></i>
        <div style="font-size:16px; font-weight:500;">No messages found</div>
        <?php if ($filter !== 'all'): ?>
        <a href="contacts.php" style="color:#6366f1; font-size:14px;">View all messages</a>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div>
        <?php foreach ($messages as $msg): ?>
        <div style="padding: 18px 24px; border-bottom: 1px solid #f3f4f6; display:flex; align-items:center; gap:16px; <?= !$msg['is_read'] ? 'background:#fafaff;' : '' ?>">
            <!-- Avatar -->
            <div style="width:44px; height:44px; background:<?= !$msg['is_read'] ? 'linear-gradient(135deg,#6366f1,#8b5cf6)' : '#e5e7eb' ?>; border-radius:50%; display:flex; align-items:center; justify-content:center; color:<?= !$msg['is_read'] ? 'white' : '#6b7280' ?>; font-size:16px; font-weight:600; flex-shrink:0;">
                <?= strtoupper(substr($msg['name'], 0, 1)) ?>
            </div>
            
            <!-- Content -->
            <div style="flex:1; min-width:0;">
                <div style="display:flex; align-items:baseline; gap:8px; margin-bottom:2px;">
                    <strong style="font-size:14px; color:#111827;"><?= htmlspecialchars($msg['name']) ?></strong>
                    <span style="font-size:12px; color:#9ca3af;"><?= htmlspecialchars($msg['email']) ?></span>
                    <?php if (!$msg['is_read']): ?>
                    <span class="badge-unread" style="font-size:10px; padding:2px 7px;">NEW</span>
                    <?php endif; ?>
                </div>
                <div style="font-size:13px; font-weight:<?= !$msg['is_read'] ? '600' : '400' ?>; color:<?= !$msg['is_read'] ? '#111827' : '#374151' ?>; margin-bottom:2px;">
                    <?= htmlspecialchars($msg['subject'] ?? 'No Subject') ?>
                </div>
                <div style="font-size:12px; color:#6b7280; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:500px;">
                    <?= htmlspecialchars(substr($msg['message'], 0, 120)) ?>...
                </div>
            </div>

            <!-- Time & Actions -->
            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px; flex-shrink:0;">
                <div style="font-size:11px; color:#9ca3af; white-space:nowrap;"><?= date('M d, g:i A', strtotime($msg['created_at'])) ?></div>
                <div class="d-flex gap-1">
                    <a href="contacts.php?view=<?= $msg['id'] ?>" class="btn-sm-icon btn-edit" title="View"><i class="fas fa-eye"></i></a>
                    <?php if ($msg['is_read']): ?>
                    <a href="contacts.php?unread=<?= $msg['id'] ?>" class="btn-sm-icon" style="background:#fef3c7; color:#d97706;" title="Mark Unread"><i class="fas fa-envelope"></i></a>
                    <?php else: ?>
                    <a href="contacts.php?read=<?= $msg['id'] ?>" class="btn-sm-icon btn-toggle" title="Mark Read"><i class="fas fa-check"></i></a>
                    <?php endif; ?>
                    <a href="contacts.php?delete=<?= $msg['id'] ?>" class="btn-sm-icon btn-delete" title="Delete" onclick="return confirm('Delete this message?')"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php require_once '_footer.php'; ?>
