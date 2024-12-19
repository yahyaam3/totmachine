<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8" role="main" aria-labelledby="maintenance-heading">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6" id="maintenance-heading">Maintenance List</h2>

            <!-- Show success or error message -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-lg">
                    <?= $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-lg">
                    <?= $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Add Maintenance Button -->
            <button type="button" class="add-maintenance bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700">
                Add Maintenance
            </button>

            <!-- Maintenance Table -->
            <table class="w-full mt-6 border border-gray-300 rounded-lg overflow-hidden shadow-sm" role="table">
                <thead class="bg-gray-100 text-gray-700" role="rowgroup">
                    <tr class="text-left" role="row">
                        <th class="p-4 font-medium" scope="col">Type</th>
                        <th class="p-4 font-medium" scope="col">Description</th>
                        <th class="p-4 font-medium" scope="col">Date</th>
                        <th class="p-4 font-medium" scope="col">Time Spent</th>
                        <th class="p-4 font-medium" scope="col">Machine</th>
                        <th class="p-4 font-medium" scope="col">User</th>
                        <th class="p-4 font-medium" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" role="rowgroup">
                    <?php foreach ($maintenance as $m): ?>
                        <tr class="hover:bg-gray-50" role="row" data-maintenance-id="<?= $m['id_maintenance']; ?>">
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['type'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['time_spent'], ENT_QUOTES, 'UTF-8'); ?>h</td>
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['machine_model'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4 text-gray-700" role="cell"><?= htmlspecialchars($m['user_username'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4 space-x-4">
                                <button class="edit-maintenance text-yellow-600 hover:underline" data-maintenance-id="<?= $m['id_maintenance']; ?>">
                                Edit
                                </button>
                                <button class="delete-maintenance text-red-600 hover:underline" data-maintenance-id="<?= $m['id_maintenance']; ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
