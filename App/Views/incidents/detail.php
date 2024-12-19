<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Detail</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Main container for incident details -->
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6" role="main">
        <!-- Form heading -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center" id="incident-heading">Incident Detail</h2>
        
        <!-- Incident details section -->
        <div class="space-y-4 text-gray-700" aria-labelledby="incident-heading">
            <p><strong>Description:</strong> <?= htmlspecialchars($incident['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Priority:</strong> <?= htmlspecialchars($incident['priority'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($incident['status'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Form for updating incident status -->
        <form 
            method="POST" 
            action="/incidents/updatestatus/<?= htmlspecialchars($incident['id_incident'], ENT_QUOTES, 'UTF-8'); ?>" 
            class="mt-6 space-y-4" 
            aria-labelledby="update-status-form"
        >
            <!-- Status update label and dropdown -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    aria-required="true" 
                >
                    <option value="WAITING">Waiting</option>
                    <option value="IN_PROCESS">In Process</option>
                    <option value="RESOLVED">Resolved</option>
                </select>
                <!-- Dropdown for incident status update -->
            </div>

            <!-- Submit button -->
            <button 
                type="submit" 
                class="bg-blue-600 text-white w-full py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                aria-label="Update incident status"
            >
                Update
            </button>
        </form>
    </div>
</body>

</html>
