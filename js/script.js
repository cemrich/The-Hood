/* globals thehood_data */

(function() {

    const isInteractable = typeof(thehood_data) !== 'undefined';
    const center = [49.85672, 8.63896];

    const wikimediaLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    const map = new L.map('map');
    const locationsLayer = L.layerGroup();
    const todayLayer = L.layerGroup([wikimediaLayer]);

    map.setView(center, 17);
    map.setMinZoom(14);
    map.addLayer(todayLayer);
    map.addLayer(locationsLayer);

    var baseLayers = {
        "Heute": todayLayer,
    };
    var overlays = {
        "Orte": locationsLayer
    };
    
    const baserLayerControl = L.control.layers(baseLayers, overlays, { 
        collapsed: false 
    });
    baserLayerControl.addTo(map);


    function hidePostOverlays() {    
        document.querySelector('#main-wrapper').style.pointerEvents = 'none';
        document.querySelectorAll('article').forEach(function (article) {
            article.style.display = 'none';
        });
    }

    function showPostOverlay(id) {
        document.querySelector('#main-wrapper').style.pointerEvents = 'auto';
        document.querySelector('article[data-post-id="' + id + '"]').style.display = 'block';
    }

    function canBeDisplayed(post) {
        return !!post.lat && !!post.lon;
    }

    function displayMarker(post) {
        const pos = [post.lat, post.lon];
        const marker = L.marker(pos)
            .addTo(locationsLayer);

        marker.on('click', function () {
            showPostOverlay(post.id); 
        });
    }

    function displayLayer(layer) {
        baserLayerControl.addBaseLayer(todayLayer, layer.title);
    }

    if (isInteractable) {
        hidePostOverlays();

        thehood_data.posts
            .filter(canBeDisplayed)
            .forEach(displayMarker);

        thehood_data.layers.forEach(displayLayer);

        document.querySelector('#main-wrapper').addEventListener('click', function (e) {
            if (!e.path.find(e => e.localName=='article')) {
                hidePostOverlays();
            }
        });
    }

})();
