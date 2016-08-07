
$(document).ready(function() {
    //Strength.js password setup
   $('#myPassword').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
   });
    
    //jQuery ui slider for max price setup    
    $(function() {
        $( "#slider-range" ).slider({
          range: "min",
          min: 1,
          max: 500,
          value: 50, //VALUES SET TO A MAX OF 500
          slide: function( event, ui ) {
            $( "#amount" ).val( "£" + ui.value);
          }
        });
        //output the slider amount in sterling
        $( "#amount" ).val( "£" + $( "#slider-range" ).slider( "value"));
    });

    //STOP THE FORM SUMBITING TO SHOW RESULTS ON GOOGLE MAPS
    $('a.stopLink').click(function(e) {
        e.preventDefault();
    });
    
    //Hide directions panel, help blocks and error panels on document load
     $('.help-block').hide();
     $('#travelTab').hide();
     $('#error').hide();
     $('#store_error').hide();
     $('#success').hide();  
 
    //Slick.js slider set up
    $('.img-slider').slick({
        dots: false,
        autoplay: true,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 2,
        swipeToSlide: true,
        autoplaySpeed: 5000,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
    });
    
    
    //**************************************
    //  Ajax requests from different forms
    //**************************************
    
    //AJAX CALLS FOR STORING VENUES FORM SUBMISSIOM
    $('#sel-venue').on('submit',function(e) {
        var data = {
            "action": "store"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                $('#store_error').empty();
                $('#success').empty();
                if(data == 'Venue saved!'){
                    $('#success').append(data);
                    $("#success").show().fadeOut(7000); //=== Show Success Message==
                }
                else if (data == 'Login'){
                    $('#store_error').append('<a href="javascript:void(0)" id="show_log">Log in!/Sign up!</a> to store venues');
                    $("#store_error").show();
                    $('#show_log').click(function(){
                        $('.modal, .login, .register').removeClass('active');
                        $('.modal, .login').addClass('active');
                    })
                }
                else{
                    $('#store_error').append(data);
                    $("#store_error").show().fadeOut(7000); //=== Show Success Message==
                }     
            },
            error:function(data){
                $('#store_error').empty();
                $('#store_error').append('No data found');
                $("#store_error").show().fadeOut(7000); //===Show Error Message====
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
    
    
    
    //AJAX CALLS FOR login SUBMISSIOM
    $('#login-form').on('submit',function(e) {
        var data = {
            "action": "login"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                 if (data == 'Login Successful'){
                     location.reload();
                 }else{
                 $('#login-error').empty();
                 $('#login-error').hide('fast'); 
                 $('#login-error').append(data);
                 $('#login-error').show('slow'); 
                 }
            },
            error:function(data){
                console.log(data); 
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });

 
    //AJAX CALLS FOR delete account SUBMISSIOM
    $('#delete-form').on('submit',function(e) {
        var data = {
            "action": "delete"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                if (data == 'Delete Successful'){
                     location.reload();
                 }
                 window.location.href = 'index.php';
            },
            error:function(data){
                console.log(data); 
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
    

    //On submit the venues are deleted from account
    $('.delvenue').on('submit',function(e){
        var data = {
            "action": "del_venue"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                console.log(data);
                $(data).hide('slow', function(){ $('form').remove(data); });
            },
            error:function(data){
                console.log(data); 

            }
        });
        e.preventDefault();
    });
});

 //**************************************
    //  Event within page
    //**************************************

//Modal box settings for more info
$(document).on("open", ".remodal", function () {
    console.log("open");
    $('.img-slider').slick('slickNext');
});

$(document).on("opened", ".remodal", function () {
    console.log("opened");
});

$(document).on("close", ".remodal", function (e) {
    console.log('close' + (e.reason ? ", reason: " + e.reason : ''));
});

$(document).on("closed", ".remodal", function (e) {
    console.log('closed' + (e.reason ? ', reason: ' + e.reason : ''));
});

$(document).on("confirm", ".remodal", function () {
    console.log("confirm");
});

$(document).on("cancel", ".remodal", function () {
    console.log("cancel");
});

//  You can open or close it like this:
//  $(function () {
//    var inst = $.remodal.lookup[$("[data-remodal-id=modal]"").data("remodal")];
//    inst.open();
//    inst.close();
//  });

  //  Or init in this way:
  var inst = $("[data-remodal-id=modal2]").remodal();
  //  inst.open();
    

// Gumby is ready to go
Gumby.ready(function() {
	Gumby.log('Gumby is ready to go...', Gumby.dump());

	// placeholder polyfil
	if(Gumby.isOldie || Gumby.$dom.find('html').hasClass('ie9')) {
		$('input, textarea').placeholder();
	}

	// skip link and toggle on one element
	// when the skip link completes, trigger the switch
	$('#skip-switch').on('gumby.onComplete', function() {
		$(this).trigger('gumby.trigger');
	});

// Oldie document loaded
}).oldie(function() {
	Gumby.warn("This is an oldie browser...");

// Touch devices loaded
}).touch(function() {
	Gumby.log("This is a touch enabled device...");
});



//**************************************
    //  Gumby Form validation settings
    //**************************************

//register form validation
$('.register form').validation({
    required: [
        {
            name: 'name', //check for name input
            validate: function($el){
                if($el.val() == false){
                    $('#name-block.help-block').html('Input your full name'); //display error message
                    $('#name-block.help-block').show('slow');
                    return false;
                }
                else {
                    $('#name-block.help-block').hide('slow');
                    return true;    
                }
            }
        },
        {
            name: 'email',
            // email must contain @ and .com,.co.uk etc
            validate: function($el) {
                var reg =/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(reg.test($el.val()) == false)
                {
                    $('#email-block.help-block').html('Invalid Email!'); //display error message
                    $('#email-block.help-block').show('slow');
                    return false;
                }
                else {
                    $('#email-block.help-block').hide('slow');
                    return true;   
                }
            }
        }
    ],
    // validation passed
    submit: function(formData) {
        var data = {
        "name": formData[0].value,
        "email": formData[1].value,
        "password": formData[2].value,
        "confirm_password": formData[3].value,
        "action": "reg"
        };
    data ="&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                $('.c-pass>.field').removeClass('danger');
                if (data == 'reg worked'){
                     location.reload();
                 }else if(data == 'Passwords do not match'){
                     $('.c-pass>.field').addClass('danger');
                     $('#c-block.help-block').html(data);
                     $('#c-block.help-block').show('slow');
                 }
                else{
                 $('#reg-error').empty();
                 $('#reg-error').hide('fast'); 
                 $('#reg-error').append(data);
                 $('#reg-error').show('slow'); 
                 }
            },
            error:function(data){
            }
        });
    },
    // validation failed
    fail: function() {
        $('#log-error').append('Test');
    }
});



//User Account validation
$('#acc-section form').validation({
    required: [
        {
            name: 'name', //check for name input
            validate: function($el){
                if($el.val() == false){
                    $('#name-block.help-block').html('Input your full name');
                    $('#name-block.help-block').show('slow');
                    return false;
                }
                else {
                    $('#name-block.help-block').hide('slow');
                    return true;  
                }
            }
        },
        {
            name: 'email',
            // email must contain @
            validate: function($el) {
                var reg =/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(reg.test($el.val()) == false)
                {
                    $('#email-block.help-block').html('Invalid Email!');
                    $('#email-block.help-block').show('slow');
                    return false;
                }
                else {
                    $('#email-block.help-block').hide('slow');
                    return true;  
                }
            }
        } 
    ],
    // validation passed
    submit: function(formData) {
        var data = {
        "name": formData[0].value,
        "email": formData[1].value,
        "old_password": formData[2].value,
        "new_password": formData[3].value,
        "confirm_password": formData[4].value,
        "user_id": formData[5].value,
        "action": "update"
        };
        data ="&" + $.param(data);
        $.ajax({
            url:'php/ajax.php',
            data: data,
            type:'POST',
            success:function(data){
                $('.old_pass>.field').removeClass('danger');
                $('.con_pass>.field').removeClass('danger');
                if (data == 'Update Successful' || data =='Password changed'){
                     location.reload();
                } else if(data == 'Input current password' || data =='Current password does not match'){
                    $('.help-block').hide();
                    $('.old_pass>.field').addClass('danger');
                    $('#c-block.help-block').html(data);
                    $('#c-block.help-block').show('slow');
                }
                else if(data == 'New password does not match'){
                    $('.help-block').hide();
                    $('.con_pass>.field').addClass('danger');
                    $('#con-block.help-block').html(data);
                    $('#con-block.help-block').show('slow');
                }
            }
        });
    },
    // validation failed
    fail: function() {
    }
});
    
  