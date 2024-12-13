<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Incident</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Report an Incident</h2>
        <form method="POST" action="/public/store-incident" class="space-y-4">
            <!-- Campo Machine ID -->
            <div>
                <label for="machine_id" class="block text-sm font-medium text-gray-700 mb-1">Machine ID (optional)</label>
                <input 
                    type="number" 
                    name="machine_id" 
                    id="machine_id" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800"
                >
            </div>
            <!-- Campo Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    required
                ></textarea>
            </div>
            <!-- Campo Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select 
                    name="priority" 
                    id="priority" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800"
                >
                    <option value="LOW">Low</option>
                    <option value="MEDIUM">Medium</option>
                    <option value="HIGH">High</option>
                </select>
            </div>
            <!-- Botón Submit -->
            <button 
                type="submit" 
                class="bg-blue-600 text-white w-full py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Submit
            </button>
        </form>
    </div>
</body>

</html>
