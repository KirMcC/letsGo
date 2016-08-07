
<?php 
ob_start();
session_start();
require_once 'config.php';

if (!isset($_SESSION['name'])){
   header("location: index.php");
			}

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

	<title>Account - Let's Go</title>
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
    


	<script src="js/libs/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	
	
	 <!--GOOGLE MAP SCRIPT WITH KEY-->
    
    <script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places,drawing,geometry&key=AIzaSyC6-X3n5u-ZRV-O1R7r_XLYvkZBN68GrbI'></script>
	
	
    
</head>

<body>
<?php require_once 'templates/header.php';?>

 	<div class="modal" id="modaldel"> 
        <div class="content delete">
            <a class="close switch" gumby-trigger="|#modaldel"><i class="icon-cancel" /></i></a> 
              <section class="row delete">
			    <div class="six columns centered">
			        <form id="delete-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="delete-form" role="form">
					    <h4 class="Pacifico">Delete <?php echo $_SESSION['name']; ?>'s Account</h4>
                             <p>Are you sure you want to delete your account?</p>
                                 <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"/>
                               <div class="eight columns centered"> 
                                 <div class="medium danger btn"><input type="submit" value="Yes" /></div>
                                 <h4 class="medium default btn"><a href="#" class="close switch" gumby-trigger="|#modaldel">No</a></h4>
                                </div>
                    </form>  	
	        	</div>
			</section>

        </div>
  	</div>
  	
<header class="sub_banner">
    <div class="row">
        <div class="twelve columns">
            <div class="centered five columns">
                <h4>Welcome <?php echo $_SESSION['name']; ?>! <br />Account page</h4>     
            </div>
        </div>
    </div> 
</header>
  	

<div class="container account-title">
    <div class="row">
        <h3>Account details</h3>
    </div>
</div>

  	
   	<div class="container account_banner">
    	<section class="row" id="acc-section">
    			<?php require_once 'templates/message.php';?>
    			
    			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="account-form" method="post" class="form-horizontal myaccount" role="form">
                 <h4 id="update-error" class="danger alert hide"></h4>
                    <div class="twelve columns centered">
                          <section class="row">
                          <div class="three columns">
                           <p>Name</p>
                          </div>
                          <div class="six columns">
                           <p class="field"><input class="input" type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>"/></p>
                         </div>
                         <div class="three columns">
                            <p id="name-block" class="help-block danger alert"></p>
                        </div>
                         </section>
                       
                       <section class="row">
                          <div class="three columns">
                           <p>Email</p>
                         </div>
                          <div class="six columns">
                           <p class="field"><input class="input" type="text" name="email" id="email" value="<?php echo $_SESSION['email']; ?>"/></p>
                           </div>
                           
                           <div class="three columns">
                                             <p id="email-block" class="help-block danger alert"></p>
                          </div>
                       </section>
                          
                          <section class="row">
                          <div class="three columns">
                           <p>Current Password</p>
                           </div>
                           <div class="six columns old_pass">
                           <p class="field"><input class="input" type="password" name="old_password" id="old_password"></p>
                           </div>
                            <div class="three columns">
                                <p id="c-block" class="help-block danger alert"></p>
                            </div>
                         </section>
                          
                          <section class="row">
                          <div class="three columns">
                           <p>New Password</p>
                           </div>
                           <div class="six columns">
                           <p class="field"><input type="password" name="new_password" id="new_password" class="input"></p>
                           </div>
                         </section>  
                          
                          <section class="row">
                          <div class="three columns">
                           <p>Confirm Password</p>
                         </div>
                          <div class="six columns con_pass">
                           <p class="field"><input type="password" name="confirm_password" id="confirm_password" class="input"></p>
                          </div>
                          <div class="three columns">
                                <p id="con-block" class="help-block danger alert"></p>
                          </div>
                         </section>
                         
   <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"/>                       
                          <section class="row">
                          <div class="push_three three columns">
                           <div class="medium danger btn"><a href="#" class="switch" gumby-trigger="#modaldel">Delete</a></div>
                          </div>
                          
                          <div class="push_one three columns">
                           <div class="medium secondary btn"><input type="submit" value="Update account" /></div>
                           </div>
                         </section>
                                   
                    </div>
                
                </form>
              
                  </section>
</div>
                
<div class="container account-title">
    <div class="row">
        <h3>Stored Venues</h3>
    </div>
</div>                  
 <!--Stored Venues from the db which have been saved--> 
                <div class="container ve_store">
                 <div class="row">
                     <div class="twelve columns store">
                     
           
                           <?php
                                $db = new Cl_DBclass();
                                $_con = $db->con;
                                $user = $_SESSION['user_id'];
                                $query = "SELECT Venue_Id, VName, v_address, Vimage, directions.direction_id, Lat, Lng FROM users, venuetable, directions WHERE users.user_id = venuetable.user_id AND users.user_id = '$user' AND venuetable.direction_id = directions.direction_id";
                                
                                $result = mysqli_query($_con,$query)or die(mysqli_error($_con));
                                //$row = mysqli_fetch_assoc($result);
                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    echo '<div class="img-slider">';
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '<form id="delvenue" method="post" class="delvenue ' .$row['direction_id'].'" role="form">';
                                        echo '<div class="hover-image"><div class="hover">';
                                        echo '<div class="h-image"><img data-lazy="'.$row["Vimage"]. '"/></div>';
                                        echo '<div class="h-info"><button type="submit" class="btn icon-btn"><i class="icon-trash"></i></button></div></div>';
                                        echo '<input type="hidden" id="dir_id" name="dir_id" value="' .$row['direction_id'].'"/>';
                                        echo '<h2>' .$row["VName"]. '</h2>';
                                        echo '<p>' .$row["v_address"]. '</p>';
                                        echo '</form>';
                                        echo '<form id="getder" method="post" action="search.php" class="getder" role="form">';
                                        echo '<input type="hidden" id="lat" name="lat" value="' .$row['Lat'].'"/>';
                                        echo '<input type="hidden" id="lng" name="lng" value="' .$row['Lng'].'"/>';
                                        echo '<div class="row"><p class="medium btn secondary"><button type="submit">Get Directions</button><p></div>';
                                        echo '</form>';
                                        echo '</div>';

                                    }


                                    echo '</div>';
                                }
                        ?>
            </div>
        </div>
    </div>
        

       
          
<?php require_once 'templates/footer.php';?>
