	function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2, distance) {
		var R = 6371;
		// Radius of the earth in km
		var dLat = deg2rad(lat2 - lat1);
		// deg2rad below
		var dLon = deg2rad(lon2 - lon1);
		var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var d = R * c;
		// Distance in km
		if (distance > d) {
			return true;
		} else {
			return false;
		}

	}

	function deg2rad(deg) {
		return deg * (Math.PI / 180);
	}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}