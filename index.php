
<?php 
ob_start();
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

	<title>Let's Go - Homepage</title>
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
    


	<script src="js/libs/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	
	
    
</head>


<?php require_once 'templates/header.php';?>
    

<!--        <header class="wrapper shaded parallax" gumby-parallax="0.5" id="flexi-image">-->
          <header id="masthead" gumby-media="only screen and (min-width: 768px)|img/belfast-main2.jpg,only screen and (max-width: 768px)|img/belfast-768.jpg">

           <section class="row">
            <article class="twelve columns banner">
               <div class="centered five columns">
               <div class="row hspace">
                <a href="#"><img src="img/main_logo.png" gumby-retina /></a>
              </div>
                    <div class="row hspace">
                        <h4>Finding venues anywhere in the world with personal taste</h4>  
                    </div>
                    <div class="row hspace">
                        <div class="medium btn primary">
                            <a href="search.php">Start Searching</a>  
                        </div>
                   </div>
                </div>
            </article>
        </section>
        </header>
<!--    </header>-->
		
		
		
<section id="panels">		
<!--Content Section-->
    
<div id="first">
  
    <img id="ser" class="inview search" gumby-media="only screen and (min-width: 960px)|img/back-search.png,only screen and (max-width: 767px)|img/back-search-small.png" gumby-classname="active" gumby-offset="50">
 <div class="container">
  <div class="row">
		<div class="seven columns" gumby-update >
          <div class="valign row">
          <div>
           <h2>Search</h2>
				<p>Instead of searching through countless results to find the perfect venue. Search by location, day, duration, spending and type to display venues that meet your criteria.</p>
          </div>
          </div>
        </div>
        
<!--
        <article class="four columns">
            <p><img src="img/search.png" /></p>
        </article>
-->
				
                
       
 </div>       
</div>
</div>

<div id="second">
      <div id="iconmap">
       <div class="inview map1" gumby-classname="active" gumby-offset="50">
           <div class="first pin" style="top: 111px; left: 305px;"></div>
           <div class="second pin" style="top: 300px; left: 200px;"></div>
           <div class="third pin" style="top: 100px; left: 100px;"></div>
       
       </div>
       </div>
    <div class="container">
        <div class="row">        
	
        <div class="seven columns push_five" gumpy-update>
            <div class="valign row">
               <div>
                <h2>Pick</h2>
				<p>Click on icons to find out more about the venue. If you like what you see either get directions or save the venue.</p>
              </div>
            </div>
        </div>
    
</div>
</div>
</div>
  
<div id="third">
    <div class="container">
        <section class="inview arrow row" gumby-classname="onscreen">      
		<div class="four columns centered center">
                <h2>Let's get started!</h2>
                <p><img src="img/down-arrow.png"/></p>
        </div>
        </section>
        <section class="row">
               <div class="six columns centered center">
                <p class="btn medium default circle-btn icon-right entypo icon-right-open-big">
                <a href="search.php"><img src="img/small_logo.png" gumby-retina /></a>
                </p>
                </div>
        </section>	
       
    </div>
  </div>
</div>    
                  
</section>                 
          
<?php require_once 'templates/footer.php';?>
