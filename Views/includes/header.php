
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>public/favicon.ico" type="image/x-icon" width="32" height="32">
    <title>Daily Transcription</title>
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500&family=Khand:wght@300;400;500;600;700&family=Khula:wght@300;400;600;700;800&family=Lato:ital,wght@0,100;0,300;1,100;1,300&family=Noto+Sans:ital,wght@1,100;1,200;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,700;1,100;1,300;1,400;1,500;1,700&family=Shippori+Antique+B1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500&family=Khand:wght@300;400;500;600;700&family=Khula:wght@300;400;600;700;800&family=Lato:ital,wght@0,100;0,300;1,100;1,300&family=Noto+Sans:ital,wght@1,100;1,200;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,300;0,400;0,900;1,400;1,500;1,900&family=Shippori+Antique+B1&display=swap" rel="stylesheet">

    <!-- FONT AWSOME ICon -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-free-6.1.1-web/css/all.min.css">
    <!-- BXSLIDER CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bxslider.css">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	
	<script>var BASE_URL = "<?php echo base_url(); ?>"</script>
</head>
<body id="main">
	<div id="loader" style="display:none;"><div class="lds-ripple"><div></div><div></div></div></div>
    <!-- HEADER HTML START-->
    <div class="header_top desktop-top">
        <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-3">
                      <a class="nav-link" href="index.html">+18312228398</a>
              </div>
              <div class="col-md-9 align-end">
				 
                  <div class="d-flex  gap-3">
					
					<?php 
					if((session('userdata')))
					{ ?>
                    <div>
                      <a class="nav-link" href="<?php echo base_url(); ?>">Hello, <?php echo session('userdata')['user_fullname']; ?></a>
                    </div>
					<div class="navBar_btn text-end">
                      <a href="<?php echo base_url(); ?>order-list" class="btn riskAssement-Btn">My Account</a>
                    </div>
					<?php }else{ ?>
					<div class="navBar_btn text-end">
                      <a href="<?php echo base_url(); ?>login" class="btn riskAssement-Btn">Login/Signup</a>
                    </div>
					<?php } ?>
					<div class="navBar_btn text-end">
                      <a href="<?php echo base_url(); ?>place-order" class="btn place-btn">Place Your Order</a>
                  </div>
				  <?php 
					if((session('userdata'))){ ?>
				                      <div class="navBar_btn text-end">
                      <a href="<?php echo base_url(); ?>Auth/logout" class="btn riskAssement-Btn">Logout</a>
                    </div>
					<?php } ?>
				                    </div>
              </div>
        </div>
      </div>
      </div>
      <div class="header_top mobile-top">
        <div class="container">
          <div class="row align-items-center">
              <div class="col-3">
                      <a class="nav-link" href="index.html">+18312228398</a>
              </div>
              <div class="col-9 align-end">
                  <div class="d-flex gap-1">
                    <div>
					  <?php if((session('userdata'))){ ?>
                      <a class="nav-link" href="<?php echo base_url(); ?>"><?php echo session('userdata')['user_fullname']; ?></a>
					  <?php } ?>
                    </div>
                    <div class="navBar_btn text-end">
                      <a href="#" class="btnorder-btn"><i class="fa-solid fa-user"></i></a>
                  </div>
                  <div class="navBar_btn text-end">
                      <a href="#" class="btn order-btn"><i class="fa-sharp fa-solid fa-cart-plus"></i></a>
                  </div>
                  </div>
              </div>
        </div>
      </div>
      </div>
      <header id="header" class="header">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-2 col-md-3 col-sm-3 col-4">
              <div class="menu-lt logo">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                  <img
                    src="<?php echo base_url(); ?>assets/images/logo.png"
                    alt="Logo "
                    class="img-fluid"
                  />
                </a>
              </div>
            </div>
            <div class="col-lg-10 col-md-8 col-sm-8 order_2 col-8">
              <div class="menu-rt align-end">
                <nav class="navbar navbar-expand-lg navbar-light">
                  <div class="button_nav" onclick="openNav()">
                    <i class="fa-solid fa-bars"></i>
                  </div>
                  <div class="navbar_collapse" id="mySidenav">
                    <a
                      href="javascript:void(0)"
                      class="closebtn"
                      onclick="closeNav()"
                      >×</a
                    >
                    <ul class="navbar-nav menu_bar">
                      <li class="nav-item active">
                        <a class="nav-link" href="#">Services</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#"> Pricing </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Enterprise </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#"> Company</a>
                      </li>
  
                      <li class="nav-item">
                        <a class="nav-link" href="#">Case Studies </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                      </li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </header>