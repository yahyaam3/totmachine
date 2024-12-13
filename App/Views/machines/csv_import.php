<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Machines</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Import Machines from CSV</h2>
            <form method="POST" action="/machines/handleimportcsv" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Upload CSV File</label>
                    <input type="file" name="csv" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Import
                </button>
            </form>
        </div>
    </div>
</body>

</html>
