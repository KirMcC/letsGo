
<div class="modal" id="modal">
           <div class="content">
               <a class="close switch" gumby-trigger="|#modal"><i class="icon-cancel" /></i></a>
               
               <section class="hide row login">
                   <div class="eight columns centered">
                       <?php require_once 'templates/message.php';?>
                       
                       <form id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-signin" role="form">
                           <h4 class="Pacifico" style="color: #ffffff;">Log In</h4>
                           <h4 id="login-error" class="danger alert hide"></h4>						
                           
                           <ul>
                            <li class="field">
                                <input class="xwide input text" name="email" id="email" type="email" placeholder="Email address" autofocus />
                            </li>
                            
                            <li class="field">
                                <input name="password" id="password" type="password" class="wide input text" placeholder="Password" />
                                <div class="medium secondary btn">
                                    <input type="submit" value="Log in!" />
                                </div>
                            </li>
                               
                            <div class="eight columns centered">
                                <li>
                                    <h4><a href="#" class="switch" gumby-trigger="#modal,#modal .register|#modal .login">Sign Up</a></h4>
                                </li>
                            </div>
						</ul>
					</form>
	        	</div>
			</section>
          
           
           <section class="hide row register">
               <div class="eight columns centered">
			        <?php require_once 'templates/message.php';?>
                    <h4 class="Pacifico" style="color: #ffffff;">Register</h4>
                    <h4 id="reg-error" class="danger alert hide"></h4>
                        
                    <form method="post" name="reg_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-register" role="form" id="register-form">
                        <ul>
                            <div class="row">
                                <div class="eight columns">
                                    <li class="field"><input type="text" id="name" name="name" class="input text" placeholder="Full Name" />
                                </div>
                                        <div class="four columns">
                                            <p id="name-block" class="help-block warning alert"></p>
                                        </div>
                                     </li>
                            </div>
                             
                            <div class="row">
                                 <div class="eight columns">
                                     <li class="field"><input name="email" id="email" type="email" class="input text " placeholder="Email Address" /> 
                                </div>
                                        <div class="four columns">
                                            <p id="email-block" class="help-block warning alert"></p>
                                        </div>
                                     </li>
                             
                                 </div>
                             
                             <div class="row">
                              <div class="eight columns">
                                  <li class="field"><input name="password" id="myPassword" type="password" class="input text npass" placeholder="Password" />
                             </div>
                                    <div class="four columns">
                                        <p class="help-block warning alert"></p>
                                    </div>
                                  </li>
                              </div>
                              
                            <div class="row">
                              <div class="eight columns c-pass">
                                  <li class="field"><input name="confirm_password" id="confirm_password" type="password" class="input text" placeholder="Confirm Password" />
                              </div>
                                  <div class="four columns">
                                        <p id="c-block" class="help-block warning alert"></p>
                                  </div>
                                  </li>
                              </div>
                              
                              <li>
                                  <div class="medium secondary btn"><input type="submit" value="Sign Up!" />
                                  </div>
                              </li>
                        </ul>
                    </form>
	        	</div>
			</section> 
      

    </div>
    </div>
    
    <!---Navigation bar---->
           
            <div class="navbar" gumby-fixed="top" id="nav1">
                <nav class="row">
                    <a class="toggle" gumby-trigger="#nav1 > .row > ul" href="#"><i class="icon-menu"></i></a>
                    <h1 class="four columns logo">
                       <a href="index.php">
                        <img src="img/letsgo_logo.png" gumby-retina />
                       </a>    
                   </h1>
                   
                   <ul class ="eight columns pull_right">
                        <li><a href="index.php">Homepage /</a></li>
                        <li><a href="search.php">Search /</a></li>
                          
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) { 
                                if(isset($_SESSION['name'])) { ?>
                                   <li id="user_name">
                                       <a href="#">
                                          <?php echo $_SESSION['name'];?>
                                      </a>
                                      <div class="dropdown">
                                          <ul>
                                              <li><a href="account.php">My Account</a></li>
                                              <li><a href="logout.php">Log Out</a></li>

                                          </ul>
                                     </div>
                                   </li>
                                <?php 
                                }
                            }
                            else
                                {?>
                                  <li><a href="#" class="switch" gumby-trigger="#modal,#modal .login|#modal .register">Log in</a></li>
                                  <?php
                                }
                            
                        ?>
                  </ul>
                </nav>
            </div>