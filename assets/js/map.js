var map = L.map('map').setView([-6.200000, 106.816666], 13); // Jakarta contoh

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap'
}).addTo(map);

// Contoh lokasi penyetoran (statis dulu → SAH UAS)
var locations = [
  { name: "Penyetoran 1", lat: -6.201, lng: 106.816 },
  { name: "Penyetoran 2", lat: -6.205, lng: 106.820 }
];

locations.forEach(loc => {
  L.marker([loc.lat, loc.lng])
    .addTo(map)
    .bindPopup(`<b>${loc.name}</b><br>Lokasi Penyetoran`);
});
