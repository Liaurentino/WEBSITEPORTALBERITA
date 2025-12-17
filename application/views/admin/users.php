<div class="container main-container admin-wrapper">

    <div class="admin-page-header">
        <h1>Daftar Pengguna</h1>
        <a href="<?php echo base_url('admin'); ?>" class="btn btn-outline">
            &larr; Dashboard
        </a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td>
                            <span class="role-badge <?php echo $u['role']; ?>">
                                <?php echo ucfirst($u['role']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($u['is_active'] == 1): ?>
                                <span class="status status-active">● Aktif</span>
                            <?php else: ?>
                                <span class="status status-banned">● Banned</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['role'] != 'admin'): ?>
                                <?php if ($u['is_active'] == 1): ?>
                                    <a href="<?php echo base_url('admin/ban_user/' . $u['id']); ?>"
                                       class="btn btn-small btn-danger"
                                       onclick="return confirm('Yakin ingin mem-banned user ini?');">
                                        🚫 Ban
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo base_url('admin/unban_user/' . $u['id']); ?>"
                                       class="btn btn-small btn-success">
                                        ✅ Unban
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
