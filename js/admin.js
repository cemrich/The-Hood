/* globals jQuery */

(function () {

    function onPageLoaded() {
        const container = jQuery('#thehood_meta_pos_map');

        if (container.length === 1) {
            const wikimediaLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            const map = new L.map('thehood_meta_pos_map');
            map.setMinZoom(14);
            map.addLayer(wikimediaLayer);

            const latField = jQuery('#thehood_meta_pos_lat');
            const lonField = jQuery('#thehood_meta_pos_lon');

            const position = [latField.val() || 49.85672, lonField.val() || 8.63896];
            const marker = L.marker(position, { draggable:'true' });
            map.setView(position, 16);

            marker.on('dragend', function(event){
                var marker = event.target;
                var position = marker.getLatLng();
                latField.val(position.lat);
                lonField.val(position.lng);
                map.panTo(position);
            });
            marker.addTo(map);
        }
    }

    window.addEventListener('load', onPageLoaded);

})();
