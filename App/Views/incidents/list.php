<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidents</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-8">
    <div class="container mx-auto" role="main">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Incidents</h2>

            <!-- Incident Table -->
            <div class="overflow-auto">
                <table class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr class="text-left">
                            <th class="p-4 font-medium">Description</th>
                            <th class="p-4 font-medium">Priority</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium">Technician</th>
                            <th class="p-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($incidents as $i): ?>
                            <tr id="row-<?= $i['id_incident']; ?>" class="hover:bg-gray-50" data-incident-id="<?= $i['id_incident']; ?>">
                                <!-- Description -->
                                <td class="p-4"><?= htmlspecialchars($i['description'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <!-- Priority -->
                                <td class="p-4">
                                    <span id="priority-view-<?= $i['id_incident']; ?>"><?= htmlspecialchars($i['priority'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <select id="priority-edit-<?= $i['id_incident']; ?>" class="hidden bg-white border p-2 rounded w-full">
                                        <option value="LOW" <?= $i['priority'] === 'LOW' ? 'selected' : ''; ?>>Low</option>
                                        <option value="MEDIUM" <?= $i['priority'] === 'MEDIUM' ? 'selected' : ''; ?>>Medium</option>
                                        <option value="HIGH" <?= $i['priority'] === 'HIGH' ? 'selected' : ''; ?>>High</option>
                                    </select>
                                </td>

                                <!-- Status -->
                                <td class="p-4">
                                    <span id="status-view-<?= $i['id_incident']; ?>"><?= htmlspecialchars($i['status'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <select id="status-edit-<?= $i['id_incident']; ?>" class="hidden bg-white border p-2 rounded w-full">
                                        <option value="WAITING" <?= $i['status'] === 'WAITING' ? 'selected' : ''; ?>>Waiting</option>
                                        <option value="IN_PROCESS" <?= $i['status'] === 'IN_PROCESS' ? 'selected' : ''; ?>>In Process</option>
                                        <option value="RESOLVED" <?= $i['status'] === 'RESOLVED' ? 'selected' : ''; ?>>Resolved</option>
                                    </select>
                                </td>

                                <!-- Technician -->
                                <td class="p-4">
                                    <span id="technician-view-<?= $i['id_incident']; ?>">
                                        <?= isset($i['technician_username']) ? htmlspecialchars($i['technician_username'], ENT_QUOTES, 'UTF-8') : 'No Technician Assigned'; ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="p-4 space-x-4">
                                    <!-- Assign Technician Button -->
                                    <button onclick="showAssignTechnicianForm(<?= $i['id_incident']; ?>)" class="text-blue-600 hover:underline">
                                        Assign Technician
                                    </button>

                                    <!-- Edit Button -->
                                    <button class="edit-incident text-yellow-600 hover:underline" data-incident-id="<?= $i['id_incident']; ?>">
                                         Edit
                                    </button>

                                    <!-- Save Button (Visible when editing) -->
                                    <button onclick="saveIncident(<?= $i['id_incident']; ?>)" class="hidden text-green-600 hover:underline" id="save-btn-<?= $i['id_incident']; ?>">
                                        Save
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="delete-incident text-red-600 hover:underline" data-incident-id="<?= $i['id_incident']; ?>">
                                        Delete
                                    </button>

                                    <!-- Drop Zone for Assigning Technician (Initially Hidden) -->
                                    <form id="assign-form-<?= $i['id_incident']; ?>" action="/incidents/assign" method="POST" class="mt-2 hidden">
                                        <input type="hidden" name="incident_id" value="<?= $i['id_incident']; ?>">
                                        <select name="technician_id" class="border p-2 rounded w-full">
                                            <option value="" disabled selected>Select Technician</option>
                                            <?php foreach ($technicians as $technician): ?>
                                                <option value="<?= $technician['id_user']; ?>" <?= ($technician['id_user'] == $i['id_user']) ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($technician['username'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="mt-2 text-blue-600 hover:underline">Assign Technician</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle visibility of the assign technician form
        function showAssignTechnicianForm(id) {
            const form = document.getElementById(`assign-form-${id}`);
            form.classList.toggle("hidden"); // Toggle the visibility of the form
        }

        // Toggle between viewing and editing priority/status fields
        function editFields(id) {
            document.getElementById(`priority-view-${id}`).classList.add('hidden');
            document.getElementById(`status-view-${id}`).classList.add('hidden');
            document.getElementById(`priority-edit-${id}`).classList.remove('hidden');
            document.getElementById(`status-edit-${id}`).classList.remove('hidden');
            document.getElementById(`save-btn-${id}`).classList.remove('hidden');
        }

        // Save the updated values
        function saveIncident(id) {
            const priority = document.getElementById(`priority-edit-${id}`).value;
            const status = document.getElementById(`status-edit-${id}`).value;

            fetch(`/incidents/update/${id}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ priority, status })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById(`priority-view-${id}`).innerText = priority;
                      document.getElementById(`status-view-${id}`).innerText = status;
                      document.getElementById(`priority-view-${id}`).classList.remove('hidden');
                      document.getElementById(`status-view-${id}`).classList.remove('hidden');
                      document.getElementById(`priority-edit-${id}`).classList.add('hidden');
                      document.getElementById(`status-edit-${id}`).classList.add('hidden');
                      document.getElementById(`save-btn-${id}`).classList.add('hidden');
                  }
              });
        }

        // Delete Incident
        function deleteIncident(id) {
            if (confirm("Are you sure you want to delete this incident?")) {
                fetch(`/incidents/delete/${id}`, { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`row-${id}`).remove();
                    }
                });
            }
        }
    </script>
</body>  

</html>
