//get the address from foursqaure api
function getVenueAddress(venue, fields) {
    var address = [];
	fields = fields || ['state', 'address', 'city', 'postalCode'];
	for (var i = 0; i < fields.length; i++) {
        if (venue.location[fields[i]]) {
            address.push(venue.location[fields[i]]);
            if (fields[i] == 'address' && venue.location['crossStreet']) {
                address[address.length - 1] += ' (' + venue.location['crossStreet'] + ')';
            }
        }
    }	
    address = address.join(',  ');
    return address;
}

//get the icons depending in categorie
function _getVenueIcon(venue) {
    if (venue.categories && venue.categories.length > 0) {
        return venue.categories[0].icon.prefix + 'bg_88' + venue.categories[0].icon.suffix;
        if (typeof(venue.categories[0].icon) == 'string') {
            return venue.categories[0].icon;
        }
        else{
            return venue.categories[0].icon.prefix + venue.categories[0].icon.sizes[0]  + venue.categories[0].icon.name;
        }
    }
    else{
        return 'https://foursquare.com/img/categories/none.png';
    }
}

//get the venues description
function getVenueDescription(venue, callback){
    var html = '';
    $.ajax({
        url:'https://api.foursquare.com/v2/venues/' + venue.id + '?client_id=SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC&client_secret=INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX&v=20140806',
        type: 'get',
        dataType: 'jsonp',
        success: function (data){
            if(data.response.venue.bestPhoto){
                var phot = data.response.venue.bestPhoto;
                var prefix =phot.prefix;
                var size = '400x200'
                var suffix = phot.suffix;
                var result = prefix + size + suffix;
                var imageLink = '<div class="row"><div class="twelve columns"><p><img style="position: relative; max-width: 100%;" src="' + result + ' " /></p></div></div>';
                html += imageLink;
                $('#vimage').val(result);
            }
            else{
                html += '';
            }
            html +='<div class="row"><div class="twelve columns"><h4>' + venue.name + ' /  <b class="gr">' + venue.location.distance + ' meters</b></h4>';
	
    
       
/*==============================For more info modal box============================*/            
            document.getElementById('venue_name').innerHTML = venue.name;
            $('#vname').val(venue.name);
            $('#vid').val(venue.id); 
            $('#vlat').val(venue.location.lat); 
            $('#vlng').val(venue.location.lng);
            sessionStorage.setItem('lat', venue.location.lat);//store for directions
            sessionStorage.setItem('lng', venue.location.lng);
    
            //display the icon
            if (venue.categories && venue.categories.length > 0) {
                html += '<p><img style="position: relative; max-width: 100%;" width="32" src="' + _getVenueIcon(venue) + '" />';
                html += ' ' + venue.categories[0].name + '</p>';
            }
            //display the address
            if (address = getVenueAddress(venue)) {
                html += '<p class="window"><i>' + address + '</i></p>';
                //FOR MODAL BOX DISPLAY
                $('#vaddress').val(address);
                document.getElementById('venue_address').innerHTML = address;
            }
            
            //display contant info if avaliable
            if (venue.contact) {
                html += '<div class="contact">';
                if (venue.contact.formattedPhone) {
                    html += '<p class="window"><span>' + venue.contact.formattedPhone + ' / ';
                    //FOR MODAL BOX DISPLAY
                    document.getElementById('venue_number').innerHTML = venue.contact.formattedPhone;
                }else{
                    document.getElementById('venue_number').innerHTML = 'No phone number available';
                }
                
                if (venue.contact.twitter) {
                    html += '<a target="_blank" href="http://twitter.com/' + venue.contact.twitter + '">@' + venue.contact.twitter + '</a> / ';
                    //FOR MODAL BOX DISPLAY
                    document.getElementById('venue_social').innerHTML = '<a target="_blank" href="http://twitter.com/' + venue.contact.twitter + '">@' + venue.contact.twitter + '</a>';
                }else{
                    document.getElementById('venue_social').innerHTML = 'No twitter available';
                }
                if (venue.url) {
                    html += ' <a target="_blank" href="' + venue.url + '">' + venue.url.replace(/^http:\/\//, '') + '</a> /';
                    //FOR MODAL BOX DISPLAY
                    document.getElementById('venue_site').innerHTML = ' <a target="_blank" href="' + venue.url + '">' + venue.url.replace(/^http:\/\//, '') + '</a>';
                }else{
                    document.getElementById('venue_site').innerHTML = 'No website available';
                }
                html += '</span></p></div>';
            }
            
            //FOR MODAL BOX DISPLAY
            dis_Hour(venue);
            photoGall(venue);
            html += '<div class="get_dir">';
            html += '<p class="window"><a href="#modal">More info</a></p></div></div></div>'; 
            callback(html);
        }
    });
}

//Gather the opening hours to display
function dis_Hour(venue) {
    
  $.ajax({
      url: 'https://api.foursquare.com/v2/venues/' + venue.id + '/hours?client_id=SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC&client_secret=INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX&v=20140806', 
      dataType: 'JSONP',
      success:  function (val){
        var times = [];
        //CHECK IF ANY RESPONSE IS AVALIABLE IF SO LOOP THROUGH JSON FILE   
          if(val.response.hours.timeframes) {
              for (h = 0; h < val.response.hours.timeframes.length; h++){
                  var length = val.response.hours.timeframes[h];
                  for (i = 0; i < length.days.length; i++){
                      var opening_times = length.open[0].start + ' ' + ' - ' + length.open[0].end;
                      times.push(opening_times);
                  }
              }
              
              var monday = 'Monday';
              var tuesday = 'Tueday';
              var wed = 'Wednesday';
              var thur = 'Thursday';
              var fri = 'Friday';
              var sat = 'Saturday';
              var sun = 'Sunday';
              
              if(!times[0]){
                  var mTime = 'Closed';
              }else{
                  var mTime = times[0];
              }
              
              if(!times[1]){
                  var tTime = 'Closed';
              }else{
                  var tTime = times[1];
              }
              
              if(!times[2]){
                  var wTime = 'Closed';
              }else{
                  var wTime = times[2];
              }
              
              if(!times[3]){
                  var thTime = 'Closed';
              }else{
                  var thTime = times[3];
              }
              
              if(!times[4]){
                  var fTime = 'Closed';
              }else{
                  var fTime = times[4];
              }
              
              if(!times[5]){
                  var sTime = 'Closed';
              }else{
                  var sTime = times[5];
              }
              
              if(!times[6]){
                  var sunTime = 'Closed';
              }else{
                  var sunTime = times[6];   
              }
              
              var htmlOpen = '';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + monday + '</p></div><div class="six columns"><p>' + mTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + tuesday + '</p></div><div class="six columns"><p>' + tTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + wed + '</p></div><div class="six columns"><p>' + wTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + thur + '</p></div><div class="six columns"><p>' + thTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + fri + '</p></div><div class="six columns"><p>' + fTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + sat + '</p></div><div class="six columns"><p>' + sTime + '</p></div></div>';
              htmlOpen += '<div class="twelve columns"><div class="six columns"><p>' + sun + '</p></div><div class="six columns"><p>' + sunTime + '</p></div></div>';
             document.getElementById('venue_day').innerHTML = htmlOpen;
              
          }
          else
          {
              times = 'No opening hours avaliable';
              document.getElementById('venue_day').innerHTML = '<div class="twelve columns"><div class="six columns"><p>' + times + '</p></div></div>';
          }      
      }
  });
}


//Gather photos to display
function photoGall(venue){
    $.ajax({
        url: 'https://api.foursquare.com/v2/venues/' + venue.id + '/photos?client_id=SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC&client_secret=INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX&v=20140806', 
      dataType: 'JSONP',
      success:  function (val){
          if(val.response.photos.items) {
              $('.imgR').remove();
              for (h = 0; h < val.response.photos.items.length; h++){
                  var phot = val.response.photos.items[h];
                  var prefix =phot.prefix;
                  var size = '500x500'
                  var suffix = phot.suffix;
                  var result = prefix + size + suffix;
                  $('.img-slider').slick('slickAdd','<div class="imgR"><img data-lazy="' + result + '"/></div>');
              }
          }
      }
    });
}




/*==============================For search generation============================*/  

//Get price tier
function GetPriceRange(venue, marker){
    $.ajax({
        url:'https://api.foursquare.com/v2/venues/' + venue.id + '?client_id=SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC&client_secret=INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX&v=20140806', 
          type: 'get',
          dataType: 'jsonp',
          success: function(data) {
              //Checks the price range for shops
              var maxPrice;
              var highPrice = $('#slider-range').slider("value"); //grab the 
              //highPrice check
              if (highPrice < 51)
              {
                  maxPrice = 1;
              }
              else if (highPrice < 101)
              {
                  maxPrice = 2;
              }
              else if (highPrice < 201)
              {
                  maxPrice = 3;
              }
              else if (highPrice < 501)
              {
                  maxPrice = 4;
              }
              
              //pass only matching venues to getHours function 
              if(data.response.venue.price)
              {
                  if(maxPrice === data.response.venue.price.tier){
                      getHours(venue, marker)
                  }
              }
              else if(!data.response.venue.price){
                  getHours(venue, marker)
              }
          }
    });
}


//Sets map markers invisible if not within timeframe
function getHours(venue, marker, callback){
    var start_val = $('select[name=starttime]').val();
    var end_val = $('select[name=endtime]').val();
    var day_val = $('select[name=day_week]').val();
    var test, daysOpen, openHours, closeHours;
    //GET JSON FILE CONTAINING VENUES HOURS DETAILS      
    $.ajax({
        url:'https://api.foursquare.com/v2/venues/' + venue.id + '/hours?client_id=SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC&client_secret=INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX&v=20140806', 
        type: 'get',
        dataType: 'jsonp',
        success: function(val) {
            if(val.response.hours.timeframes) {
                for (h = 0; h < val.response.hours.timeframes.length; h++)
                {
                    var dlength = val.response.hours.timeframes[h];
                    for (i = 0; i < dlength.days.length; i++)
                    {
                        if (dlength.days[i] == day_val)
                        {
                            openHours = val.response.hours.timeframes[h].open[0].start;
                            closeHours = val.response.hours.timeframes[h].open[0].end;
                            var closeH = closeHours.replace("+","");
                        }
                    }
                }
                
                if (( end_val >= openHours || end_val <= openHours) && (start_val <= closeH || start_val >= closeH ))
                {
                    $('#result_count').html(function(i, val) { return +val+1 });
                    marker.setVisible(true);
                }
                else
                {
                    
                    console.log(venue.name);
                    console.log(venue.id);
                    console.log(closeH);
                    marker.setVisible(false);
                }
            }
            $('#result_count').html(function(i, val) { return +val+1 });
        }
    });
}//getHours function closed


//Reset all search area including map
function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
    markers = [];
    poly.setPath([]);
    directionsDisplay.setMap(null);
    map.setZoom(15);
    $('#travelTab').hide('slow');
    $(".draw").toggle('slow');
    $("div.search_btn").toggle('slow');
    $('#result_count').html('0');
}


//activate the script when function is called
function GetMessage(polygon) {
    $('#result_count').html('0');
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
    //var coordinates = polygon.getPath().getArray(); //gain the shapes co and set into an array
    var message = '';
    if (typeof myField != 'undefined') {
    }
    
    
    var bounds = new google.maps.LatLngBounds();
                var paths = polygon.getPath();
        console.log(bounds);

                var path;
                for (var p = 0; p < paths.getLength(); p++) {
                        path = paths.getAt(p);
                        //var sw = path.lat();
                        //var ne = path.lng();

                        bounds.extend(path);       
                }
    
    var polyCenter = bounds.getCenter();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    
    var CLIENT_ID = 'SZIHYFHTJSL5ZSZEJLY0VFBPSR4N54WUDCZGKKNQWTSXUUBC';
    var CLIENT_SECRET = 'INL4I1MPCAALYO5WLC0SQKH2HAKD3RI1X2IWEI3ZBY3QQQYX';
    var lat = polyCenter.lat();
    var lng = polyCenter.lng();
    var swLat = sw.lat().toFixed(5);
    var swLng = sw.lng().toFixed(5);
    var neLat = ne.lat().toFixed(5);
    var neLng = ne.lng().toFixed(5);
    var type = $("#category option:selected").val();
    var start_val = $('select[name=starttime]').val();
    var end_val = $('select[name=endtime]').val();
    var day = $('select[name=day_week]').val();
    var API_ENDPOINT = 'https://api.foursquare.com/v2/venues/search' +
        '?client_id='+CLIENT_ID+'' +
        '&client_secret='+CLIENT_SECRET+'' +
        '&v=20140806' +
        '&ll='+lat+','+lng+'' +
        '&intent=browse' +
        '&ne='+neLat+','+neLng+'' +
        '&sw='+swLat+','+swLng+'' +
        '&categoryId='+type+'';
    
    
    
    $.ajax({
         url: API_ENDPOINT,
         type: 'GET',
         dataType: 'jsonp',
         success: getSearchResults
    })
    
    
    function getSearchResults(data){
        for (j = 0; j < data.response.venues.length; j++)
        {
           
            var item = data.response.venues[j];
            var marker = new google.maps.Marker({
                map: map,
                animation: google.maps.Animation.DROP, 
                position: new google.maps.LatLng(item.location.lat, item.location.lng), 
                title: item.name, 
                icon: new google.maps.MarkerImage(_getVenueIcon(item), null, null, null, new google.maps.Size(20, 20))
            });
            
            
            GetPriceRange(item, marker);     
            marker.item = item; //store information of each item in marker
            // retrieve information using `this.item`
            google.maps.event.addListener(marker, 'click', function(mark) {
                getVenueDescription(this.item, function(result) {
                    myInfoWindow.setContent(result);
                })
                myInfoWindow.open(map, this);
            });
            markers.push(marker);
        }
        
    }

}//FUNCTION GET MESSAGE CLOSED




