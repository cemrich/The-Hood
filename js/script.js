const isInteractable = typeof(thehood_data) !== 'undefined';
const center = [49.85672, 8.63896];

const wikimediaLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

const map = new L.map('map');
map.setView(center, 17);
map.setMinZoom(14);
map.addLayer(wikimediaLayer);


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
        .addTo(map);

    marker.on('click', function () {
        showPostOverlay(post.id); 
    });
}

if (isInteractable) {
    hidePostOverlays();

    thehood_data
        .filter(canBeDisplayed)
        .forEach(displayMarker);

    document.querySelector('#main-wrapper').addEventListener('click', function (e) {
        if (!e.path.find(e => e.localName=='article')) {
            hidePostOverlays();
        }
    });
}