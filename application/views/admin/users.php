<div class="container main-container" style="padding-top: 2rem;">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h1>👥 Daftar Pengguna</h1>
        <a href="<?php echo base_url('admin'); ?>" class="btn btn-outline">&larr; Dashboard</a>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 10px; padding: 1rem; box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 1rem; text-align: left;">Username</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Role</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;"><?php echo htmlspecialchars($u['username']); ?></td>
                        <td style="padding: 1rem;"><?php echo htmlspecialchars($u['email']); ?></td>
                        <td style="padding: 1rem;">
                            <span style="padding: 4px 8px; border-radius: 4px; background: <?php echo $u['role'] == 'admin' ? '#e2e6ea' : '#fff'; ?>; font-weight: bold;">
                                <?php echo ucfirst($u['role']); ?>
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <?php if ($u['is_active'] == 1): ?>
                                <span style="color: green;">● Aktif</span>
                            <?php else: ?>
                                <span style="color: red; font-weight: bold;">● Banned</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem;">
                            <?php if ($u['role'] != 'admin'): ?>
                                <?php if ($u['is_active'] == 1): ?>
                                    <a href="<?php echo base_url('admin/ban_user/' . $u['id']); ?>" 
                                       class="btn btn-small btn-danger"
                                       onclick="return confirm('Yakin ingin mem-banned user ini?');">🚫 Ban</a>
                                <?php else: ?>
                                    <a href="<?php echo base_url('admin/unban_user/' . $u['id']); ?>" 
                                       class="btn btn-small" style="background: green; color: white;">✅ Unban</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>