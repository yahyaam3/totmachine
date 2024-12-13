<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Detail</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Incident Detail</h2>
        <!-- Detalle de la incidencia -->
        <div class="space-y-4 text-gray-700">
            <p><strong>Description:</strong> <?= $incident['description']; ?></p>
            <p><strong>Priority:</strong> <?= $incident['priority']; ?></p>
            <p><strong>Status:</strong> <?= $incident['status']; ?></p>
        </div>
        <!-- Formulario para actualizar estado -->
        <form method="POST" action="/incidents/updatestatus/<?= $incident['id_incident']; ?>" class="mt-6 space-y-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800"
                >
                    <option value="WAITING">Waiting</option>
                    <option value="IN_PROCESS">In Process</option>
                    <option value="RESOLVED">Resolved</option>
                </select>
            </div>
            <button 
                type="submit" 
                class="bg-blue-600 text-white w-full py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Update
            </button>
        </form>
    </div>
</body>

</html>
