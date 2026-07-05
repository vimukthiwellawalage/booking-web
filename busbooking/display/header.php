<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Yamu | යමු - Live Journey"; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: "Poppins", "Ubuntu", sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 text-white h-full">

    <header class="flex items-center gap-3 px-6 py-3 bg-[#000b3d] border-b border-white/10">
        <img src="../images/yamu-logo.png" alt="Yamu Logo" class="h-12 w-auto">
        <span class="text-lg font-semibold tracking-wide text-white/90">Yamu | යමු</span>
    </header>
