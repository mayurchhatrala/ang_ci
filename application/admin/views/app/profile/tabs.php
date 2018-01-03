<div class="wrapper bg-white b-b">
    <ul class="nav nav-pills nav-sm">
        <li class="<?= isset($tabs) && $tabs == 1 ? 'active' : ''; ?>">
            <a ui-sref="app.profile.update">Profile</a>
        </li>
        <li class="<?= isset($tabs) && $tabs == 2 ? 'active' : ''; ?>">
            <a ui-sref="app.profile.password">Change Password</a>
        </li>
        <li class="<?= isset($tabs) && $tabs == 3 ? 'active' : ''; ?>">
            <a ui-sref="app.profile.settings">Settings</a>
        </li>
    </ul>
</div>