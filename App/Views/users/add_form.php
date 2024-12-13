<div class="max-w-sm mx-auto">
    <h2 class="text-xl mb-4">Add User</h2>
    <form method="POST" action="/users/store" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Surname</label>
            <input type="text" name="surname" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Username</label>
            <input type="text" name="username" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Password (6-13 chars, at least 1 letter & 1 number)</label>
            <input type="password" name="password" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="border w-full p-2">
                <option value="TECHNICAL">Technical</option>
                <option value="SUPERVISOR">Supervisor</option>
                <option value="ADMINISTRATOR">Administrator</option>
            </select>
        </div>
        <div class="mb-2">
            <label>Avatar</label>
            <input type="file" name="avatar" class="border w-full p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create</button>
    </form>
</div>