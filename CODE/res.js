
const shareBtn = document.getElementById('shareLocationBtn');
const locationInput = document.getElementById('location');
const locationStatus = document.getElementById('locationStatus');

shareBtn.addEventListener('click', () => {
    if (!navigator.geolocation) {
        locationStatus.textContent = 'Geolocation is not supported by your browser.';
        return;
    }

    locationStatus.textContent = 'Locating...';

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            locationInput.value = `${lat},${lng}`;
            locationStatus.textContent = `Location captured: ${lat.toFixed(5)}, ${lng.toFixed(5)}`;
        },
        (error) => {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    locationStatus.textContent = 'Permission denied. Please allow location access.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    locationStatus.textContent = 'Location unavailable.';
                    break;
                case error.TIMEOUT:
                    locationStatus.textContent = 'Location request timed out.';
                    break;
                default:
                    locationStatus.textContent = 'An unknown error occurred.';
            }
        }
    );
});

