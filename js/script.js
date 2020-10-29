/* globals thehood_data */

(function() {

    const wikimediaLayer = L.tileLayer('https://a.tile.openstreetmap.de/{z}/{x}/{y}.png ', {
        attribution: '<a href="http://www.openstreetmap.org/">Karte hergestellt aus OpenStreetMap-Daten</a> | Lizenz: <a href="http://opendatacommons.org/licenses/odbl/">Open Database License (ODbL)</a>'
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
        let boundingBox = L.latLngBounds(layer.boundingBox);
        boundingBox = boundingBox.getCenter().equals([0, 0]) ? null : boundingBox;

        const tileLayer = L.tileLayer(layer.tileUrl, {
            attribution: layer.attribution,
            tms: false,
            minNativeZoom: layer.minZoom, 
            maxNativeZoom: layer.maxZoom,
            bounds: boundingBox
        });
        const layerGroup = L.layerGroup([todayLayer, tileLayer]);
        baserLayerControl.addBaseLayer(layerGroup, layer.title);

        layerGroup.setZIndex(10);
    }

    if (thehood_data.isInteractable) {
        hidePostOverlays();

        thehood_data.posts
            .filter(canBeDisplayed)
            .forEach(displayMarker);

        thehood_data.layers.forEach(displayLayer);

        document.querySelector('#main-wrapper').addEventListener('click', function (e) {
            var targetElement = e.target;
            do {
                if (targetElement.localName == 'article') {
                    return;
                }
                targetElement = targetElement.parentNode;
            } while (targetElement);

            hidePostOverlays();
        });
    }

})();
