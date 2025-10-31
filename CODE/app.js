// Global variables for Map and Geolocation
let map;
let userLocationMarker;
let teamMarkers = [];
let userLocation = null;

// --- GOOGLE MAPS & GEOLOCATION LOGIC ---

// Initialize the map (called by the Google Maps API script tag)
window.initMap = function() {
    // Default location (e.g., Dhaka, Bangladesh)
    const defaultCoords = { lat: 23.8103, lng: 90.4125 }; 
    
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultCoords,
        zoom: 12,
        mapId: "RESCUE_CENTER_MAP_ID" // Optional: Use a custom cloud-based map style
    });

    // Try to get user's current location on map load
    getUserCurrentLocation(false); // Pass false to not update the form input yet

    // Add markers for rescue teams (Simulated data)
    addTeamMarkers();
};

// Function to fetch and display the user's current location
function getUserCurrentLocation(updateForm = true) {
    const locationInput = document.getElementById('location');
    const locationStatus = document.getElementById('locationStatus');

    if (navigator.geolocation) {
        locationStatus.textContent = 'Fetching location...';
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                
                userLocation = pos; // Store global user location
                
                // Center map and add user marker
                map.setCenter(pos);
                if (userLocationMarker) {
                    userLocationMarker.setMap(null); // Remove old marker
                }
                userLocationMarker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    title: "Your Location",
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });

                if (updateForm) {
                    // Update the form input field
                    locationInput.value = `${pos.lat},${pos.lng}`;
                    locationStatus.textContent = `Location acquired: Lat ${pos.lat.toFixed(4)}, Lng ${pos.lng.toFixed(4)}`;
                    // Change button style to success
                    const btn = document.getElementById('shareLocationBtn');
                    btn.classList.remove('text-indigo-700', 'bg-indigo-50', 'border-indigo-200');
                    btn.classList.add('text-green-700', 'bg-green-50', 'border-green-200');
                    btn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Location Shared';
                }
            },
            () => {
                // Error handling
                locationStatus.textContent = updateForm ? 'Error: Geolocation failed or permission denied.' : 'Using default map center.';
                if (updateForm) {
                    const btn = document.getElementById('shareLocationBtn');
                    btn.classList.remove('text-indigo-700', 'bg-indigo-50', 'border-indigo-200');
                    btn.classList.add('text-red-700', 'bg-red-50', 'border-red-200');
                    btn.innerHTML = '<i class="fa-solid fa-xmark mr-2"></i> Failed to Get Location';
                }
            }
        );
    } else {
        // Browser doesn't support Geolocation
        locationStatus.textContent = 'Error: Your browser does not support Geolocation.';
    }
}

// Add markers for rescue teams
function addTeamMarkers() {
    const teamItems = document.querySelectorAll('#team-list .team-item');
    
    // Clear existing markers
    teamMarkers.forEach(marker => marker.setMap(null));
    teamMarkers = [];

    teamItems.forEach(item => {
        const lat = parseFloat(item.dataset.lat);
        const lng = parseFloat(item.dataset.lng);
        const name = item.querySelector('h3').textContent;
        const address = item.querySelector('p').textContent;

        const marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: name,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png" // Rescue team icon
            }
        });
        
        // Add info window
        const infowindow = new google.maps.InfoWindow({
            content: `<strong>${name}</strong><br>${address}`
        });

        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });

        teamMarkers.push(marker);

        // Center map on click of the list item
        item.addEventListener('click', () => {
            map.setCenter({ lat: lat, lng: lng });
            map.setZoom(14);
            infowindow.open(map, marker);
        });
    });
}

// --- FORM SUBMISSION LOGIC ---

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Report Pet Form Submission
    const rescueForm = document.getElementById('rescueForm');
    if (rescueForm) {
        rescueForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Basic validation for location
            const locationInput = document.getElementById('location');
            if (!locationInput.value) {
                window.showMessage('Please share your live location before submitting.', 'Location Required', 'error');
                return;
            }

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Submitting...';
            submitButton.disabled = true;

            try {
                const response = await fetch('handle_rescue.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    window.showMessage(result.message, 'Rescue Report Submitted!', 'success');
                    this.reset(); // Clear the form
                    document.getElementById('fileUploadText').textContent = 'Click to upload an image';
                    document.getElementById('locationStatus').textContent = 'Location reset.';
                    // Reset the location button style
                    const btn = document.getElementById('shareLocationBtn');
                    btn.classList.remove('text-green-700', 'bg-green-50', 'border-green-200');
                    btn.classList.remove('text-red-700', 'bg-red-50', 'border-red-200');
                    btn.classList.add('text-indigo-700', 'bg-indigo-50', 'border-indigo-200');
                    btn.innerHTML = '<i class="fa-solid fa-location-crosshairs mr-2"></i> Share Live Location';
                } else {
                    window.showMessage(result.message, 'Submission Failed', 'error');
                }
            } catch (error) {
                window.showMessage('An unexpected error occurred. Please try again.', 'Error', 'error');
                console.error('Fetch error:', error);
            } finally {
                submitButton.innerHTML = 'Submit Rescue Request';
                submitButton.disabled = false;
            }
        });
    }

    // 2. Abuse Report Form Submission (Assuming the HTML form has an ID 'abuseForm')
    // NOTE: The provided HTML uses an inline 'onsubmit' which is simpler, but a Fetch implementation is below.
    // If you add id="abuseForm" to the HTML form:
    /*
    const abuseForm = document.getElementById('abuseForm'); 
    if (abuseForm) {
        abuseForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Sending...';
            submitButton.disabled = true;

            try {
                const response = await fetch('handle_abuse.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    window.showMessage(result.message, 'Report Sent', 'success');
                    this.reset();
                } else {
                    window.showMessage(result.message, 'Submission Failed', 'error');
                }
            } catch (error) {
                window.showMessage('An unexpected error occurred. Please try again.', 'Error', 'error');
            } finally {
                submitButton.innerHTML = 'Submit Confidential Report';
                submitButton.disabled = false;
            }
        });
    }
    */
    
    // 3. File Upload UI update
    const fileUploadContainer = document.getElementById('fileUploadContainer');
    const fileUploadInput = document.getElementById('fileUploadInput');
    const fileUploadText = document.getElementById('fileUploadText');

    if (fileUploadContainer && fileUploadInput) {
        fileUploadContainer.addEventListener('click', () => {
            fileUploadInput.click();
        });

        fileUploadInput.addEventListener('change', (event) => {
            if (event.target.files.length > 0) {
                fileUploadText.textContent = event.target.files[0].name;
            } else {
                fileUploadText.textContent = 'Click to upload an image';
            }
        });
    }
    
    // 4. Attach Live Location button functionality
    const shareLocationBtn = document.getElementById('shareLocationBtn');
    if (shareLocationBtn) {
        shareLocationBtn.addEventListener('click', () => getUserCurrentLocation(true));
    }
});

// Attach initMap to window for Google Maps API callback
window.initMap = initMap;