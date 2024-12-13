<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidents</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Incidents</h2>

            <div class="overflow-auto">
                <table class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-gray-600">
                            <th class="p-4 font-medium">Description</th>
                            <th class="p-4 font-medium">Priority</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium">Machine</th>
                            <th class="p-4 font-medium">User</th>
                            <th class="p-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($incidents as $i): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-gray-700"><?= $i['description']; ?></td>
                                <td class="p-4 text-gray-700"><?= $i['priority']; ?></td>
                                <td class="p-4 text-gray-700"><?= $i['status']; ?></td>
                                <td class="p-4 text-gray-700"><?= $i['machine_model']; ?></td>
                                <td class="p-4 text-gray-700"><?= $i['user_username']; ?></td>
                                <td class="p-4 flex space-x-4">
                                    <?php if ($_SESSION['user_role'] == 'TECHNICAL' || $_SESSION['user_role'] == 'SUPERVISOR' || $_SESSION['user_role'] == 'ADMINISTRATOR'): ?>
                                        <a href="/incidents/detail/<?= $i['id_incident']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                        <a href="/incidents/assignself/<?= $i['id_incident']; ?>" class="text-green-600 hover:underline">Assign to me</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
