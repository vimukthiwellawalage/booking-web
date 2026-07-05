<?php
require_once("../db_conn.php");

$busID = $_GET['bus_id'] ?? null;
$busInfo = null;

if ($busID) {
    $busIDEsc = mysqli_real_escape_string($conn, $busID);
    $busResult = mysqli_query($conn, "SELECT busID, regNo, model FROM bus WHERE busID = '$busIDEsc'");
    if ($busResult && mysqli_num_rows($busResult) > 0) {
        $busInfo = mysqli_fetch_assoc($busResult);
    }
}

$pageTitle = $busInfo ? "Yamu - " . $busInfo['regNo'] : "Yamu - Display Panel";
include("header.php");
?>

<?php if (!$busInfo): ?>

    <main class="h-[calc(100%-4.5rem)] flex items-center justify-center px-6">
        <div class="text-center">
            <p class="text-3xl font-semibold text-white/90">No bus selected</p>
            <p class="mt-3 text-white/60 text-lg">Open this screen with a valid bus, e.g. <code class="bg-white/10 px-2 py-1 rounded">display/index.php?bus_id=NC0909</code></p>
        </div>
    </main>

<?php else: ?>

    <main class="h-[calc(100%-4.5rem)] flex flex-col md:flex-row" data-bus-id="<?php echo htmlspecialchars($busInfo['busID']); ?>">

        <!-- Map -->
        <div class="relative w-full md:w-[65%] h-1/2 md:h-full">
            <div id="map" class="w-full h-full"></div>
        </div>

        <!-- Info panel -->
        <div class="w-full md:w-[35%] h-1/2 md:h-full flex flex-col gap-4 p-6 overflow-y-auto bg-slate-950">

            <div>
                <p id="route-label" class="text-white/60 text-xl">Route</p>
                <p id="route-value" class="text-3xl font-bold text-white">—</p>
                <p class="text-white/50 text-lg mt-1">Bus <?php echo htmlspecialchars($busInfo['regNo']); ?></p>
            </div>

            <div class="border-t border-white/10 pt-4">
                <div class="flex items-center gap-3 opacity-60">
                    <i class="text-2xl">✔</i>
                    <div>
                        <p class="text-lg text-white/60">Previous Stop</p>
                        <p id="previous-stop" class="text-2xl font-semibold text-white">—</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-4">
                <div class="flex items-center gap-3">
                    <i class="text-3xl text-sky-400">📍</i>
                    <div>
                        <p class="text-lg text-sky-300">Next Stop</p>
                        <p id="next-stop" class="text-4xl font-extrabold text-white">—</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-4">
                <p class="text-lg text-white/60">Distance to Next Stop</p>
                <p id="distance-value" class="text-6xl font-extrabold text-sky-400 leading-tight">—</p>
            </div>

            <div class="mt-auto border-t border-white/10 pt-3 text-white/40 text-sm" id="last-updated">
                Waiting for location data…
            </div>

        </div>

    </main>

    <script>
        const busID = document.querySelector('main').dataset.busId;
        const pollUrl = `../api/get-live-location.php?bus_id=${encodeURIComponent(busID)}`;
        const pollIntervalMs = 7000;

        // Sri Lanka bounding box
        const SRI_LANKA_BOUNDS = [[5.9, 79.5], [9.9, 81.9]];

        const map = L.map('map', {
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            touchZoom: false,
            boxZoom: false,
            keyboard: false,
        });
        map.fitBounds(SRI_LANKA_BOUNDS);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);

        const busIcon = L.divIcon({
            html: '<div style="font-size:28px; line-height:1;">🚌</div>',
            className: '',
            iconSize: [30, 30],
            iconAnchor: [15, 15],
        });

        let busMarker = null;
        let routeDrawn = false;

        function drawRouteOnce(routeStops) {
            if (routeDrawn || !routeStops || routeStops.length === 0) {
                return;
            }
            routeDrawn = true;

            const latLngs = [];
            routeStops.forEach(stop => {
                if (stop.latitude === null || stop.longitude === null) {
                    return;
                }
                const lat = parseFloat(stop.latitude);
                const lng = parseFloat(stop.longitude);
                latLngs.push([lat, lng]);

                L.circleMarker([lat, lng], {
                    radius: 6,
                    color: '#38bdf8',
                    fillColor: '#0ea5e9',
                    fillOpacity: 1,
                    weight: 2,
                }).bindTooltip(stop.city, { permanent: false });
            });

            if (latLngs.length > 1) {
                L.polyline(latLngs, { color: '#38bdf8', weight: 4, opacity: 0.7 }).addTo(map);
                map.fitBounds(latLngs, { padding: [40, 40] });
            }
        }

        function updatePanel(data) {
            document.getElementById('route-label').textContent = data.route ? `Route ${data.route.routeNo}` : 'Route';
            document.getElementById('route-value').textContent = data.route ? `${data.route.origin} → ${data.route.destination}` : '—';
            document.getElementById('previous-stop').textContent = data.previous_stop ? data.previous_stop.name : '—';
            document.getElementById('next-stop').textContent = data.next_stop ? data.next_stop.name : '—';
            document.getElementById('distance-value').textContent =
                data.distance_to_next_stop_km !== null && data.distance_to_next_stop_km !== undefined
                    ? `${data.distance_to_next_stop_km} km`
                    : '—';
            document.getElementById('last-updated').textContent = 'Last updated: ' + data.recorded_at;
        }

        async function poll() {
            try {
                const response = await fetch(pollUrl, { cache: 'no-store' });
                const data = await response.json();

                if (!data.success || !data.has_location) {
                    document.getElementById('last-updated').textContent = data.message || 'Waiting for location data…';
                    return;
                }

                drawRouteOnce(data.route_stops);

                const lat = data.latitude;
                const lng = data.longitude;

                if (!busMarker) {
                    busMarker = L.marker([lat, lng], { icon: busIcon }).addTo(map);
                } else {
                    busMarker.setLatLng([lat, lng]);
                }

                updatePanel(data);
            } catch (err) {
                document.getElementById('last-updated').textContent = 'Connection error, retrying…';
            }
        }

        poll();
        setInterval(poll, pollIntervalMs);
    </script>

<?php endif; ?>

</body>
</html>
