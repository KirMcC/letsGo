//SET UP VARIABLES
var myDrawingManager;
var myField;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var myInfoWindow;
var request;
var markers = [];
var j, timeVenue;


//SET UP DRECTION SERVICE
directionsDisplay = new google.maps.DirectionsRenderer();

//SET UP THE GOOGLE MAPS ONTO SITE ON WINDOW LOAD
function initialize() {
    
    var mapOptions = {
    zoom: 15 //ZOOM INTO 15X AT USERS CURRENT LOCATION
    };
    
    //SHOWS THE MAP ON THE ID CALLED MAP-CANVA    
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    
    
    
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    
    //LOOKS FOR USERS CURRENT LOCATION 
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(pos);//CENTER MAP AT USERS CURRENT POSITION
            sessionStorage.setItem('currentpos', pos); //set within session for directions purpose
        },
        function() {
            handleNoGeolocation(true);
        });
    } else{
        // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }
    
    
//ERROR FOR NO BROWSER SUPPORT (VALIDATION) 
    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            var content = 'Error: The Geolocation service failed.';
        } else {
            var content = 'Error: Your browser doesn\'t support geolocation.';
        }
        var options = {
            map: map,
            position: new google.maps.LatLng(60, 105),
            content: content
        };
        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
    }


    //**************************************
    // SEARCHBOX TO LOOK UP A LOCATION
    //USES THE PLACE AUTOCOMPLETE METHOD
    //**************************************
    var autocomplete = new google.maps.places.Autocomplete( /** @type {HTMLInputElement} */(
        document.getElementById('pac-input')), //GRAB TEXT FROM SEARCH BOX
          {
            types: ['geocode'], //LOOKING FOR LOCATIONS AND PLACES ONLY 
          });
    autocomplete.bindTo('bounds', map); //BIND THE RESULTS TO BOUND TO MAP

    
    //CREATE INFO WINDOW TO DISPLAY DETAILS    
    var infowindow = new google.maps.InfoWindow();
    //CREATE A MARKER TO SHOW SEARCHED LOCATION
    var locmarker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    //NEW PLACE SEARCH WILL CLOSE INFO WINDOW, HIDE MARKER AND GRAB THE NEW LOCATION
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        infowindow.close();
        locmarker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } 
        else {
            map.setCenter(place.geometry.location);
            map.setZoom(15);  // Why 15? Because it looks good.
        }
        
        //SHOW POSITION AND MAKE MARKER SHOW WHEN PLACE HAS BEEN FOUND  
        locmarker.setPosition(place.geometry.location);
        //GRAB THE PLACE ADDRESS AND SELECT THE FIRST THREE DETAILS FROM ARRAY  
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    });
    
    
    /*==============================CREATE AND DISPLAY GOOGLE MAPS DRAWING TOOLS============================*/
    // create a dialog box but don't bind it to anything yet
    myInfoWindow = new google.maps.InfoWindow();
    
    //DRAWING THE POLYGON ON MAP WHEN USERS SELECTS THE DRAW BUTTON
    $(".draw").on('click', function(e) {
        e.preventDefault(); //PREVENT THE LINK FROM JUMPING TO THE TOP OF THE PAGE
        document.getElementById("map_hand").style.cursor = "crosshair";
        directionsDisplay.setMap(null);
        $('#travelTab').hide('slow');
        disable()
        
        google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
            drawFreeHand()
        });
    })//CLICK EVENT CLOSED

}//FUNCTION INT CLOSED
    


/*==============================Functions area============================*/
 function drawFreeHand(){
     //the polygon
     poly=new google.maps.Polyline({map:map,clickable:false});
    
    //move-listener
    var move=google.maps.event.addListener(map,'mousemove',function(e){
        poly.getPath().push(e.latLng);
    });
    
    //mouseup-listener
    google.maps.event.addListenerOnce(map,'mouseup',function(e){
        google.maps.event.removeListener(move);
        var path=poly.getPath();
        poly.setMap(null);
        poly=new google.maps.Polygon({map:map,path:path});
        $(".draw").toggle('slow');
        $("div.search_btn").toggle('slow');

        google.maps.event.clearListeners(map.getDiv(), 'mousedown');
        enable()
    });
}  


function disable(){
    map.setOptions({
        draggable: false, 
        zoomControl: false, 
        scrollwheel: false, 
        disableDoubleClickZoom: false
    });
    disable_scroll()
}

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function keydown(e) {
    for (var i = keys.length; i--;) {
        if (e.keyCode === keys[i]) {
            preventDefault(e);
            return;
        }
    }
}

function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  
}

    
function enable(){
    map.setOptions({
        draggable: true, 
        zoomControl: true, 
        scrollwheel: true, 
        disableDoubleClickZoom: true
    });
    enable_scroll()
} 

function enable_scroll() {
    if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
}


/**
     *when search button is clicked, it calls the formSubmit function
     *this will make sure no info window is open and displays the results from search query
     *then call the GetMessage function which includes all of the script for query searching
     */

function formSubmit(){
    event.preventDefault();
    GetMessage(poly); 
}



/*==============================Get Directions function============================*/
function calcRoute(Mode) {
    if (myInfoWindow){
        myInfoWindow.close();
    }
    
    directionsDisplay.setMap(map);
    var selectedMode = Mode;
    if(!Mode){
        selectedMode = 'DRIVING';
    }
    
    //SET UP DRECTION SERVICE
    var lat = sessionStorage.getItem('lat');
    var lng = sessionStorage.getItem('lng'); 
    var current = sessionStorage.getItem('currentpos');
    var start = current.slice(1, current.length-1);
    var end = lat +"," + lng;
    var request = {
        origin:start,
        destination:end,
        durationInTraffic :true,
        transitOptions: {
            departureTime:  new Date()
          },
        provideRouteAlternatives : true,
        travelMode: google.maps.DirectionsTravelMode[selectedMode]
    };
    
    directionsService.route(request, function(response, status) {
        $('#travelTab').show('slow');
        $('#error').hide('slow');

        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            // alert an error message when the route could nog be calculated.
                if (status == 'ZERO_RESULTS') {
                    $('#directionsPanel').empty();
                    $('#error').show('slow');
                } 
                else if (status == 'UNKNOWN_ERROR') {
                $('#directionsPanel').append('A directions request could not be processed due to a server error. The request may succeed if you try again.');
                } 
                else if (status == 'REQUEST_DENIED') {
                $('#directionsPanel').append('This webpage is not allowed to use the directions service.');
                } 
                else if (status == 'OVER_QUERY_LIMIT') {
                $('#directionsPanel').append('The webpage has gone over the requests limit in too short a period of time.');
                } 
                else if (status == 'NOT_FOUND') {
                $('#directionsPanel').append('At least one of the origin, destination, or waypoints could not be geocoded.');
                } 
                else if (status == 'INVALID_REQUEST') {
                $('#directionsPanel').append('The DirectionsRequest provided was invalid.');         
                } 
                else {
                $('#directionsPanel').append("There was an unknown error in your request. Requeststatus: nn"+status);
                }
            }
    });
}

   
//TRANSFERS CORRECT TRANSPORT DATA TO CALCROUTE FUNCTION
$('#DRIVING').click(function(){
    var Mode = $(this).attr('id');
    calcRoute(Mode);
})

$('#TRANSIT').click(function(){
    var Mode = $(this).attr('id');
    calcRoute(Mode);
})

$('#BICYCLING').click(function(){
    var Mode = $(this).attr('id');
    calcRoute(Mode);
})

$('#WALKING').click(function(){
    var Mode = $(this).attr('id');
    calcRoute(Mode);
})

//start google maps on window load
google.maps.event.addDomListener(window, 'load', initialize);
    
    