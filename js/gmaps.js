function initMap() { 
  var uluru = {lat: 52.815754, lng: 6.515109}; 
  var map = new google.maps.Map(document.getElementById('googleMap'), { 
    zoom: 12,
    center: uluru 
  }); 
  var marker = new google.maps.Marker({ 
    position: uluru,
    map: map 
  });
  }