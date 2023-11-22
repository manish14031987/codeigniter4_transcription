<section class="get_touch_sect">
  <div class="container">
	<div class="row">
	  <div class="col-lg-6">
		<h5>Get In Touch</h5>
		<h3>
		  <a href="">+91 (831) 222-8398</a>
		</h3>
	  </div>
	  <div class="col-lg-6">
		<div class="join-us">
		  <a href="">Join us as a transcriber</a>
		</div>
	  </div>
	</div>
  </div>
</section>
<!-- FOOTER -->
    <footer class="footer">
      <div class="footer-top">
        <div class="container footer-map">
          <div class="footer-row">
            <div class="row">
              <div class="col-lg-3">
                <h5>Products</h5>
                <ul class="footer-list">
					<li><a href="#" class="footer-links">Service</a></li>
                  <li><a href="#" class="footer-links">Pricing</a></li>
                  <li><a href="#" class="footer-links">Enterprise</a></li>
                  <li><a href="#" class="footer-links">Company</a></li>
                  <li><a href="#" class="footer-links">Case Studies</a></li>
                  <li><a href="#" class="footer-links">Contact</a></li>
                </ul>
              </div>
              <div class="col-lg-3">
                <h5>Products</h5>
                <ul class="footer-list">
                  <li><a href="#" class="footer-links">Service</a></li>
                  <li><a href="#" class="footer-links">Pricing</a></li>
                  <li><a href="#" class="footer-links">Enterprise</a></li>
                  <li><a href="#" class="footer-links">Company</a></li>
                  <li><a href="#" class="footer-links">Case Studies</a></li>
                  <li><a href="#" class="footer-links">Contact</a></li>
                </ul>
              </div>
              <div class="col-lg-3">
                <h5>General Inquiries</h5>
                <div class="contact-detail">
                  <p>
                    <strong> Call Inquiries</strong> <br />
                    +900000000000 <br />
                    +90000000000000
                  </p>
                  <p><strong> Email</strong> <br />contact@dummy.com</p>
                </div>
              </div>
              <div class="col-lg-3">
                <h5>Address</h5>
                <address>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Quasi, minus.
                </address>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container text-center">
          <div class="row align-items-center">
            <div class="col-lg-12">
              <p class="mb-0 text-center">
                &copy; Copyright ©2022 Company Name. All Rights reserved
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- SCRIPT -->
    
    <script src="https://gotranscript.tridentdispatch.com/assets/js/jquery.min.js"></script>
    <script src="https://gotranscript.tridentdispatch.com/assets/js/jquery.bxslider.min.js"></script>
    <script src="https://gotranscript.tridentdispatch.com/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://gotranscript.tridentdispatch.com/assets/js/custom.js"></script>
    <script
      type="text/javascript"
      src="https://www.jquery-az.com/boots/js/bootstrap-filestyle.min.js"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- NAVIGATION BAR TOGGLER -->
	
    <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "0";
        document.getElementById("main").style.overflow = "hidden";
      }

      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        document.getElementById("main").style.overflow = "auto";
      }
	  
	 
    </script>
    <!-- STICKY HEADER -->
    <script>
      window.onscroll = function () {
        myFunction();
      };

      var header = document.getElementById("header");
      var sticky = header.offsetTop;

      function myFunction() {
        if (window.pageYOffset > sticky) {
          header.classList.add("sticky");
        } else {
          header.classList.remove("sticky");
        }
      }
    </script>

    <!-- counter -->
    <script>
      $(".counter-count").each(function () {
        $(this)
          .prop("Counter", 0)
          .animate(
            {
              Counter: $(this).text(),
            },
            {
              //chnage count up speed here
              duration: 4000,
              easing: "swing",
              step: function (now) {
                $(this).text(Math.ceil(now));
              },
            }
          );
      });
    </script>

    <!-- TESTIMONIAL SLIDER -->
    <script>
      $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
          items: 3,
          autoplay: false,
          margin: 30,
          loop: true,
          dots: true,
		  
          nav: true,
          navText: [
            "<i class='fas fa-long-arrow-alt-left'></i>",
            "<i class='fas fa-long-arrow-alt-right'></i>",
          ],
          responsiveClass: true,
          responsive: {
            0: {
              items: 1,
            },
            480: {
              items: 1,
            },
            769: {
              items: 3,
            },
          },
        });
      });
    </script>

    <script>
      $("#filecount").filestyle({
        input: false,
        buttonName: "btn-danger",
      });
    </script>
  </body>
</html>