
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/favicon.png"
      type="image/x-icon"
      width="32"
      height="32"
    />
    <title>Gotranscript</title>
    <!-- GOOGLE FONTS -->
    <link
      href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500&family=Khand:wght@300;400;500;600;700&family=Khula:wght@300;400;600;700;800&family=Lato:ital,wght@0,100;0,300;1,100;1,300&family=Noto+Sans:ital,wght@1,100;1,200;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,700;1,100;1,300;1,400;1,500;1,700&family=Shippori+Antique+B1&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500&family=Khand:wght@300;400;500;600;700&family=Khula:wght@300;400;600;700;800&family=Lato:ital,wght@0,100;0,300;1,100;1,300&family=Noto+Sans:ital,wght@1,100;1,200;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,300;0,400;0,900;1,400;1,500;1,900&family=Shippori+Antique+B1&display=swap"
      rel="stylesheet"
    />

    <!-- FONT AWSOME ICon -->
    <link
      rel="stylesheet"
      href="<?php echo base_url(); ?>assets/css/fontawesome-free-6.1.1-web/css/all.min.css"
    />
    <!-- BXSLIDER CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bxslider.css" />
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
    />
	
	<script>var BASE_URL = '<?php echo base_url(); ?>'; </script>
  </head>
  <body id="main">
    <!-- LOGIN SECTION  -->

    <div class="login">
      <div class="container">
        <div class="row login__box">
          <div class="col-lg-6">
            <div class="login__left">
              <div class="login__pad">
                <div class="login__logo">
                  <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="" class="img-fluid" />
                </div>
                <div class="login__head">
                  <h3>Welcome back to <span>Daily Transcription</span></h3>
                  <p>Looking to be a Company name Freelancer? Visit here.</p>
                  <div class="text-center mt-5">
                    <button class="place-btn login-btn"><a href="<?php echo base_url(); ?>">Go to Home</a></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="login__right login__pad">
              <div class="login__right--head">
                <a href="">Forgot Password</a>
               
              </div>
			  
			  
			  <div class="fxt-content fxt-template-layout1">
				
				<div class="fxt-form"> 
					
					<form class="needs-validation"  id="forgot_form" autocomplete="off">
						<div class="form-group">
							<div class="fxt-transformY-50 fxt-transition-delay-1">
								<input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email Address" required="required" autocomplete="off"/>
								<i class="flaticon-envelope"></i>
							</div>
						</div>
						
						<div class="form-group">
							<div class="fxt-transformY-50 fxt-transition-delay-3">
								<div class="fxt-content-between">
									<button type="submit" class="btn btn-primary">Submit</button>
									
								</div>
								<div id="result"></div>
							</div>
						</div>
					</form>
				</div>
			</div>

			  
			  <!--
              <div class="login__social">
                <p class="login__right--para">Login With Social Media</p>
                <div>
                  <button class="btn-social">
                    <img src="<?php //echo base_url(); ?>assets/images/React-Social-Login-Buttons 1.png" alt="" />
                  </button>
                </div>
                <span>Or</span>
                <div>
                  <button class="btn-social btn--Glogin">
					<a href="<?php //echo base_url(); ?>google_login">
                    <img src="<?php //echo base_url(); ?>assets/images/React-Social-Login-Buttons 2.png" alt="" />
					</a>
                  </button>
                </div>
              </div>
			  -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SCRIPT -->

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
    <script
      type="text/javascript"
      src="https://www.jquery-az.com/boots/js/bootstrap-filestyle.min.js"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
	
		$("#forgot_form").validate({
			// Validation rules and messages go here
        rules: {
            
            user_email: "required"
        },
        messages: {
			user_email: "Please enter your email"
        },
        submitHandler: function(form) {
            // Use AJAX to submit the form
            var formData = $("#forgot_form").serialize();
            
            $.ajax({
				url: BASE_URL+"Auth/ci_forgot_ajax",
				type: "POST",
				data: formData,
				dataType: "JSON",
				beforeSend: function() {
					$("#submit-button").text("Submitting...");
					$("#submit-button").prop('disabled', true);
				},
				success: function(response) {
					$("#result").html('<span class="'+response.status+'">'+response.msg+'</span>'); 
					if(response.status == 'success')
					{
					//$(function () {
					//setTimeout(function() {
					//	window.location.replace(BASE_URL);
					 // }, 2000);
					//});
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					//$("#result").html("Error: " + textStatus + " - " + errorThrown);
				},
				complete: function() {
					$("#submit-button").text("Submit");
					$("#submit-button").prop('disabled', false);
					$("#forgot_form")[0].reset();
				}
			});
        }
    });

	
		
	</script>
  </body>
</html>
<style>
ul.fxt-socials-links {
    text-align: center;
}

ul.fxt-socials-links li img {max-width: 50%;}	
.loaded.fxt-template-animation .fxt-transition-delay-4 {
    -webkit-transition-delay: 0.4s;
    -o-transition-delay: 0.4s;
    transition-delay: 0.4s;
}
.loaded.fxt-template-animation .fxt-transformY-50 {
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
    -webkit-transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    -o-transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
}

.fxt-template-layout1 ul.fxt-socials li {
    display: inline-block;
    margin-right: 4px;
    margin-bottom: 8px;
}
.fxt-template-animation .fxt-transformY-50 {
    opacity: 0;
    -webkit-transform: translateY(50px);
    -ms-transform: translateY(50px);
    transform: translateY(50px);
}
.fxt-template-layout1 ul.fxt-socials li.fxt-google a {
    background-color: #CC3333;
    border-color: #CC3333;
}
.fxt-template-layout1 ul.fxt-socials {
    text-align: center;
}
ul {
    list-style: outside none none;
    margin: 0;
    padding: 0;
}
.fxt-template-layout1 ul.fxt-socials li.fxt-facebook a {
    background-color: #3b5998;
    border-color: #3b5998;
}
.fxt-template-layout1 ul.fxt-socials li a {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    font-size: 14px;
    height: 40px;
    width: 40px;
    color: #ffffff;
    border-radius: 50%;
    border: 1px solid;
    -webkit-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}	
	.fxt-template-layout1 .switcher-text2 {
    color: #9f9f9f;
    font-size: 15px;
    margin-top: 5px;
    display: block;
    -webkit-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.fxt-content-between {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.fxt-template-layout1 .fxt-form .form-control {
    border-radius: 0;
    min-height: 40px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 0;
    border-bottom: 1px solid #e7e7e7;
    padding: 10px 30px 10px 0;
    color: #111111;
    background-color: #ffffff;
}
.fxt-template-layout1 .fxt-form .form-group i {
    position: absolute;
    z-index: 1;
    right: 5px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.fxt-template-layout1 .fxt-form .form-group {
    position: relative;
    z-index: 1;
    margin-bottom: 15px;
}
.loaded.fxt-template-animation .fxt-transition-delay-2 {
    -webkit-transition-delay: 0.2s;
    -o-transition-delay: 0.2s;
    transition-delay: 0.2s;
}
.loaded.fxt-template-animation .fxt-transformY-50 {
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
    -webkit-transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    -o-transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    transition: all 1.3s cubic-bezier(0.075, 0.82, 0.165, 1);
}

.fxt-template-animation .fxt-transformY-50 {
    opacity: 0;
    -webkit-transform: translateY(50px);
    -ms-transform: translateY(50px);
    transform: translateY(50px);
}
	#signup_form .col-sm-12, #signup_form label {
    margin: 0;
}
label.error {
    color: red;
    font-style: italic;
    font-size: 12px;
}
div#result .info {
    color: blue;
}

div#result {
    text-align: center;
}

div#result .error {
    color: red;
}

div#result .success {
    color: #35b335;
}
</style>
