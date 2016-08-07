<?php 
ob_start();
session_start();
require_once 'config.php';
?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<!-- Use the .htaccess and remove these lines to avoid edge case issues.
			 More info: h5bp.com/b/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Search - Let's Go</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="humans.txt">

	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

	<!-- Facebook Metadata /-->
	<meta property="fb:page_id" content="" />
	<meta property="og:image" content="" />
	<meta property="og:description" content=""/>
	<meta property="og:title" content=""/>

	<!-- Google+ Metadata /-->
	<meta itemprop="name" content="">
	<meta itemprop="description" content=""> 
	<meta itemprop="image" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<!-- We highly recommend you use SASS and write your custom styles in sass/_custom.scss.
		 However, there is a blank style.css in the css directory should you prefer -->
	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="css/jquery.remodal.css">

    


	<script src="js/libs/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	
	
	 <!--GOOGLE MAP SCRIPT WITH KEY-->
    
    <script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places,drawing,geometry&key=AIzaSyC6-X3n5u-ZRV-O1R7r_XLYvkZBN68GrbI'></script>
	
	
    
</head>

<body>
<?php require_once 'templates/header.php';?>


<div class="remodal" data-remodal-id="modal">
    
        <div class="content">
            <div class="row">
            <div class="twelve columns">
                <div class="img-slider"></div>
            </div>
            </div>
<!--
                <div class="twelve columns centered">
                     <h4 id="venue_image"></h4>
                </div>
-->
            <div class="row">
                <div class="five columns">
                <?php require_once 'templates/message.php';?>
                 <form id="sel-venue" action="" method="post" class="form-venue" role="form">
                     <h3 id="venue_name"></h3>
                     <input type="text" id="vname" name="vname" class="input text wide" hidden/>
                     <input type="text" id="vid" name="vid" class="input text wide" hidden/>
                     <input type="text" id="vimage" name="vimage" class="input text wide" hidden />
                     <input type="text" id="vaddress" name="vaddress" class="input text wide" hidden/>
                     <input type="text" id="vlat" name="vlat" class="input text wide" hidden/>
                     <input type="text" id="vlng" name="vlng" class="input text wide" hidden/>
                     <h4 id="venue_address"></h4>
                        
               </div>
                    <div class="push_two five columns">
                        <p>
                            <div class="medium secondary btn icon-left entypo icon-direction">
                                <a href="#" class="remodal-cancel" onClick="calcRoute()";return false;>Directions</a>
                            </div>
                        </p>
                        <p class="medium secondary btn">
                           <button type="submit"><i class="icon-floppy"></i>Save Venue</button>
                        </p>
                        <div id="store_error" class="danger alert hide"></div>
                        <div id="success" class="success alert hide"></div>
                        
                   </div> 
                </form>
            </div>	
            
            <div class="row">
                <div class="five columns">	  
                    <h4>Opening Times</h4>
                        <div id="venue_day"></div>   
                </div>
                <div class="push_two five columns">
                    <h4>Contact Information</h4>
                    <p id="venue_number"></p>
				    <p id="venue_site"></p>
				    <p id="venue_social"></p>
				</div>
            </div>
        </div>
     
</div>


      
<div class="remodal-bg">      
 

<header class="sub_banner">

    <div class="row">
              <div class="five columns centered">
               <hgroup>
                <h4>Choose your location, time, cost and type of venue</h4>
               </hgroup>
              </div>
    </div>     
</header>


<div class="container account-title" id="search-m">
    <section class="row search">
      
           <article class="twelve columns">  
                    <input class="xwide input" id="pac-input" type="text" placeholder="Start typing a location..." autofocus>    
            </article>
    </section>
</div>


<div class="wrapper" id="search-map">
    <section class="row" id ="main-map">
      <div class="four columns">
          <div><h4>Results:<span id="result_count"></span></h4></div>
       <div id="form-section">
        <!--FORM SECTION-->
            <form id="form">
                <!--SELECT BOX SECTION FOR PICKING DAY OF WEEK, START AND END TIME-->
                <section class="first-r row">
                <div class="eight columns">
                <p class="first-p">Day</p>
                <ul>
                  <li class="field">
                    <div class="picker">
                        <select name="day_week" id="day_w">
                            <option value="7">Sunday</option>
                            <option selected value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                        </select>
                    </div>
                  </li> 
                </ul>
                </div> 
                
                <div class="one columns ttip" data-tooltip="Select a day."><i class="icon-info-circled"></i></div>
                
                </section> 
                
                
            <!--START TIME-->
            <section class="first-r row">
                   <div class="two columns">
                    <p class="first-p">Time /</p>
                  </div>
             <div class="three columns">
               <p>Start</p>     
                <ul>
                    <li class="field">
                        <div class="picker">
                           <select name="starttime" id="start-t">
                            <option value="0600">06:00</option>
                            <option value="0700">07:00</option>
                            <option value="0800">08:00</option>
                            <option selected value="0900">09:00</option>
                            <option value="1000">10:00</option>
                            <option value="1100">11:00</option>
                            <option value="1200">12:00</option>
                            <option value="1300">13:00</option>
                            <option value="1400">14:00</option>
                            <option value="1500">15:00</option>
                            <option value="1600">16:00</option>
                            <option value="1700">17:00</option>
                            <option value="1800">18:00</option>
                            <option value="1900">19:00</option>
                            <option value="2000">20:00</option>
                            <option value="2100">21:00</option>
                            <option value="2200">22:00</option>
                            <option value="2300">23:00</option>
                            <option value="0000">00:00</option>
                            <option value="0100">01:00</option>
                            <option value="0200">02:00</option>
                            <option value="0300">03:00</option>
                            <option value="0400">04:00</option>
                            <option value="0500">05:00</option>
                        </select>
                            
                        </div>
                    </li>
                 </ul>
            </div>  
                        
                
       
            <!--END TIME-->
                   <div class="three columns">
                       <p>End Time</p>
                          <ul>
                           <li class="field">
                               <div class="picker">
                        <select name="endtime" id="end-t">
                            <option value="0600">06:00</option>
                            <option value="0700">07:00</option>
                            <option value="0800">08:00</option>
                            <option value="0900">09:00</option>
                            <option value="1000">10:00</option>
                            <option value="1100">11:00</option>
                            <option value="1200">12:00</option>
                            <option value="1300">13:00</option>
                            <option value="1400">14:00</option>
                            <option value="1500">15:00</option>
                            <option value="1600">16:00</option>
                            <option value="1700">17:00</option>
                            <option selected value="1800">18:00</option>
                            <option value="1900">19:00</option>
                            <option value="2000">20:00</option>
                            <option value="2100">21:00</option>
                            <option value="2200">22:00</option>
                            <option value="2300">23:00</option>
                            <option value="0000">00:00</option>
                            <option value="0100">01:00</option>
                            <option value="0200">02:00</option>
                            <option value="0300">03:00</option>
                            <option value="0400">04:00</option>
                            <option value="0500">05:00</option>
                        </select> 
                                   
                               </div>
                           </li>
                       </ul>
                    </div>
                    <div class="one columns ttip" data-tooltip="Input your chosen timeframe."><i class="icon-info-circled"></i></div>    
                </section>
                           
          <!--JQUERY UI RANGE SLIDER TO PICK MIN AND MAX VAULE THE USER WANTS TO SPEND-->
            <section class="first-r row">
             <div class="row">
                <div class="three columns">                             
                    <p class="first-p">Max Price /</p>
                </div>
                <div class="five columns">
                <input type="text" id="amount" readonly style="border:0; color:#B5D571; font-weight:bold;"></div>
               <div class="one columns ttip" data-tooltip="Set the maximum amount you want to spend."><i class="icon-info-circled"></i></div>
              </div>  
            
            <div class="row">
            <div class="eight columns">
                   <!--INPUT RANGE SLIDER HERE-->
                    <div id="slider-range"></div>
            </div>
           </div>
           

           </section> 
 

            <!--SELECT THE TYPE OF VENUE USING CHECKBOXES-->
            <section class="first-r row">
               <div class="eight columns">
                   <p class="first-p">Type of Venue</p>
                <ul>
                    <li class="field">
                        <div class="picker">
                           <select id="category">
                            <option value="">All</option>
                            <option value="4d4b7105d754a06376d81259">Bars</option>
                            <option value="4d4b7105d754a06376d81259">Nightclubs</option>
                            <option value="4bf58dd8d48988d17f941735">Movie Theater</option>
                            <option value="4bf58dd8d48988d181941735">Museum</option>
                            <option value="4d4b7105d754a06378d81259">Shops</option>
                            <option value="4bf58dd8d48988d16d941735">Cafe</option>
                            <option value="4d4b7105d754a06374d81259">Restaurants</option>
                            <option value="4bf58dd8d48988d184941735">Stadium</option>
                            <option value="4bf58dd8d48988d182941735">Theme Park</option>
                           </select>
                        </div>
                    </li>
                  </ul>
                </div>
        <div class="one columns ttip" data-tooltip="Select the type of venue you would like to see."><i class="icon-info-circled"></i></div>

        </section>

            <!--BUTTON TO SUBMIT THE FORM AND GIVE BACK RESULTS-->                              
           <div class="row">
               <div class="eight columns">
                 <div class="search_btn danger alert">Draw on map to enable search.</div>  
                  <div class="search_btn" style="display: none">            
                   <div class="medium btn primary" onClick="formSubmit()"><a href="javascript:void(0);">Search</a></div>
                    <div class="medium btn danger" onClick="clearMarkers()"><a href="javascript:void(0);">Reset</a></div>
                  </div> 
               </div>
            </div>
          </form>
       </div>
    </div>
       
        <div id="map_hand" class="eight columns">
               
    
        <!--Menu section for clearing, editing and drawing the polygon area-->
                <div class="menu">
                     <div class="draw medium btn primary"><a href="javascript:void(0);">Draw</a></div>
                </div>
  
          <!--INPUT GOOGLE MAPS HERE--> 
           <div class="google-maps">   
            <div id="map-canvas"></div>
           </div>
       </div>   
  </section>
        
    
</div>



<div class="wrapper">
   <section class="row" id="direction-panel">
      <div class="twelve columns">  
          <div id="travelTab">
               <h4>Directions</h4>
                <section class="tabs pill" data-target='direction-panel'>
                <ul class="tab-nav" id="travelType">
                    <li id="DRIVING" class="active"><a href="">Driving</a></li>
                    <li id="WALKING"><a href="#">Walk</a></li>
                    <li id="BICYCLING"> <a href="#">Cycling</a></li>
                    <li id="TRANSIT"><a href="#">Transit</a></li>
                </ul>
                </section>
        <div id="error"><p class="danger alert">No route could be found between the origin and destination.</p></div>
        <div id="directionsPanel" class="tab-content active"></div>
        </div>
    </div>
  </section>
</div>
</div>


<?php require_once 'templates/footer.php';
if(isset($_POST['lat'])){
    $lat =$_POST['lat'];
    $lng =$_POST['lng'];

    echo "<script type='text/javascript'>sessionStorage.setItem('lat', ".$lat.");sessionStorage.setItem('lng', ".$lng.");calcRoute();</script>";
};

?>