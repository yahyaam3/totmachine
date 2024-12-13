<div class="max-w-sm mx-auto">
    <h2 class="text-xl mb-4">My Profile</h2>
    <form method="POST" action="/users/update-profile" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="border w-full p-2" value="<?= $user['name']; ?>" required>
        </div>
        <div class="mb-2">
            <label>Surname</label>
            <input type="text" name="surname" class="border w-full p-2" value="<?= $user['surname']; ?>" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="border w-full p-2" value="<?= $user['email']; ?>" required>
        </div>
        <div class="mb-2">
            <label>Avatar</label>
            <input type="file" name="avatar" class="border w-full p-2">
            <?php if ($user['avatar']): ?>
                <img src="/<?= $user['avatar']; ?>" class="w-32 h-32 object-cover mt-2">
            <?php endif; ?>
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update</button>
    </form>
</div>