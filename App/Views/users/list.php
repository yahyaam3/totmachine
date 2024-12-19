<h2 class="text-xl mb-4">Users</h2>
<!-- Cambia el enlace por un botón -->
<button type="button" class="add-user bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700">
    Add User
</button>
<a href="#" id="randomUserBtn" data-role="TECHNICAL" class="bg-yellow-500 text-white p-2 rounded ml-2">Create Random
    Technical</a>
<table class="w-full mt-4 border-collapse">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
            <tr class="border-b" data-user-id="<?= $u['id_user']; ?>">
                <td><?= $u['name'] . " " . $u['surname']; ?></td>
                <td><?= $u['username']; ?></td>
                <td><?= $u['email']; ?></td>
                <td><?= $u['role']; ?></td>
                <td>
                    <!-- Remove role condition so Edit always appears -->
                    <a href="#" class="edit-user text-yellow-500 underline" data-user-id="<?= $u['id_user']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    document.getElementById('randomUserBtn').addEventListener('click', function (e) {
        e.preventDefault();
        let role = this.dataset.role;
        fetch('/ajax/random-user?role=' + role)
            .then(res => res.json())
            .then(data => {
                if (data.result === 'ok') {
                    window.location.reload();
                }
            });
    });
</script>