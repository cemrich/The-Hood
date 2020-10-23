/* globals thehood_data */

(function() {

    const wikimediaLayer = L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png', {
        attribution: '<a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia maps</a> | Map data © <a href="http://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    });

    const map = new L.map('map');
    const locationsLayer = L.layerGroup();
    const todayLayer = L.layerGroup([wikimediaLayer]);

    map.setView(thehood_data.center, thehood_data.initialZoom);
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

    if (thehood_data.isInteractable) {
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
