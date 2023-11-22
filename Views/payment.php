<?php //pr($order_info); ?>
<section class="orderbg">
      <div class="container">
      <div class="row">
        <div class="col-12">
        <div class="orderbg__content">
          <div class="row">
          <div class="col-sm-12 col-lg-3">
            <h3>Payment information :-</h3>
          </div>
          <div class="col-sm-12 col-lg-9">
            <div class="orderbg__steps"> <div class="row justify-content-center">
            <ul id="progressbar">
              <?php if(!$session->get('userdata')['logged_in']){ ?>
              <li id="step1">
                <strong>Add files</strong>
              </li>
              <li id="step2"><strong>Login/sign-up</strong></li>
              <li class="active" id="step3"><strong>Payment</strong></li>    
              <li id="step4"><strong>Complete order</strong></li>
              <?php } ?>
              <?php if($session->get('userdata')['logged_in']){ ?>
              <li id="step1">
                <strong>Add files</strong>
              </li>
              <li class="active" id="step2"><strong>Payment</strong></li>    
              <li id="step3"><strong>Complete order</strong></li>
              <?php } ?>
            </ul>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>

<section class="order__sect order-min">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 ">
         <div class="order_option">
        <div class="order_header">
          <h3>Select Payment Option:- </h3>
        </div>
        <div class="order_payment">
          <div class="order_flex">
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>
              <label class="form-check-label" for="radio1">PayPal</label>
              </div>
              <div>
                <button class="border-none"><img width="120" src="<?php echo base_url(); ?>assets/images/paypal-icon.png" alt=""></button>
              </div>
              <div class="visa-mc-button">
                <button class="border-none"><img width="180" src="<?php echo base_url(); ?>assets/images/visa-mastercard-amex-768x166.png" alt=""></button>
              </div>
          </div>
        </div>
         </div>
      </div>

      <div class="col-lg-3 ">
           <div class="order__summery">
          <h2 class="order_head">Order Summary</h2>
          <div class="order_price">
            <?php 
            $totalPrice = 0;
            foreach($order_info as $oi){ 
            $totalPrice += $oi['price']; 
            $hours = floor($oi['duration'] / 3600);
            $mins = floor($oi['duration'] / 60 % 60);
            $secs = floor($oi['duration'] % 60);
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
             ?>
            <div class="price-loop">
            <p><?php echo $oi['item_name']; ?></p>
            <p><?php echo $timeFormat; ?> <span>$<?php echo $oi['price']; ?></span></p>
            </div>
            <?php } ?>
            <form id="payment" action="<?php echo base_url(); ?>do_payment" method="post">
            <input type="hidden" name="final_price" value="<?php echo encryptMyData($totalPrice); ?>" />
            <input type="hidden" name="order_id" value="<?php echo encryptMyData($order_id); ?>" />
            <div class="total_price">
            <p class="dark">Total:</p>
            <p class="dark">$<?php echo $totalPrice; ?></p>
            </div>
             <div class="text-center pb-5">
            <button type="submit" class="btn place-btn">Continue</button>
             </div>
             </form>
          </div>
           </div>
      </div>
    </div>
  </div>
</section>


   <!-- counter section  -->
    <section class="countersection">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-4">
            <div class="count-up">
              <div class="count-img"><img src="<?php echo base_url(); ?>assets/images/count1.png" /></div>
              <div class="countertext">
                <p class="counter-count">60</p>
                <span>+</span>
                <h3>No. of People Healed</h3>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-4">
            <div class="count-up">
              <div class="count-img"><img src="<?php echo base_url(); ?>assets/images/count2.png" /></div>
              <div class="countertext">
                <p class="counter-count">144</p>
                <!-- <span>+</span> -->
                <h3>Million Minutes Transcribed</h3>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-4">
            <div class="count-up">
              <div class="count-img"><img src="<?php echo base_url(); ?>assets/images/count3.png" /></div>
              <div class="countertext">
                <p class="counter-count">98</p>
                <span>%</span>
                <h3>Customer Satisfaction</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- contact sales section  -->

    <section class="contact-sales-section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="coutact-salest-text">
                <h3>The Best Solution for Enterprises</h3>
                <p>
                  At Company Name, we value transparency and close collaboration
                  with our clients.Get an accurate quote on our transcribing
                  services up front. Check the status of your order anytime.
                </p>

                <div class="buttonariya">
                  <div class="leftbutt"><a href="#"> Contact for Sales</a></div>
                  <div class="rightbutt">
                    <a href="#">
                      <img src="<?php echo base_url(); ?>assets/images/buttaro.png" /> Learn about Enterprise</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="coutact-salest-image">
                <img src="<?php echo base_url(); ?>assets/images/contactforsell.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- servivestop section  -->

    <section class="services-topsection">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="services-block">
              <div class="iconround">
                <img src="<?php echo base_url(); ?>assets/images/servicesicon1.png" />
              </div>
              <div class="servicestext-block">
                <h3>Professional Transcription Services</h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="services-block">
              <div class="iconround">
                <img src="<?php echo base_url(); ?>assets/images/servicesicon1.png" />
              </div>
              <div class="servicestext-block">
                <h3>Professional Transcription Services</h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="services-block">
              <div class="iconround">
                <img src="<?php echo base_url(); ?>assets/images/servicesicon1.png" />
              </div>
              <div class="servicestext-block">
                <h3>Professional Transcription Services</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!------------ FAQ SECTION  -------------->
    <section class="faq">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="ind-head">
              <h5>FAQ</h5>
              <h2>Frequently Asked Questions</h2>
              <p>
                Customer support represents the resources within your company
                that provide technical assistance<br />
                to consumers after they purchase a product or service.
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="faq__accordian">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button
                      class="accordion-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      How do you ensure quality?
                    </button>
                  </h2>
                  <div
                    id="collapseOne"
                    class="accordion-collapse collapse show"
                    aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="accordion-body">
                      <p>
                        We at GoTranscript completely understand the importance
                        of accuracy in transcription. That's why we always aim
                        for 99% accuracy.We start by hiring only the best. We
                        then employ a system of reviews and checks to ensure
                        quality and accuracy. Our staff have no less than 5
                        years of transcribing experience, so you can be sure
                        your audio files are transcribed with great care and
                        attention to detail.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTwo"
                      aria-expanded="false"
                      aria-controls="collapseTwo"
                    >
                      Do you offer transcription services in other languages?
                    </button>
                  </h2>
                  <div
                    id="collapseTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong>
                      It is hidden by default, until the collapse plugin adds
                      the appropriate classes that we use to style each element.
                      These classes control the overall appearance, as well as
                      the showing and hiding via CSS transitions. You can modify
                      any of this with custom CSS or overriding our default
                      variables. It's also worth noting that just about any HTML
                      can go within the <code>.accordion-body</code>, though the
                      transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseThree"
                      aria-expanded="false"
                      aria-controls="collapseThree">
                      Do you offer a discount for high volume?
                    </button>
                  </h2>
                  <div
                    id="collapsefour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong>
                      It is hidden by default, until the collapse plugin adds
                      the appropriate classes that we use to style each element.
                      These classes control the overall appearance, as well as
                      the showing and hiding via CSS transitions. You can modify
                      any of this with custom CSS or overriding our default
                      variables. It's also worth noting that just about any HTML
                      can go within the <code>.accordion-body</code>, though the
                      transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingfour">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapsefour"
                      aria-expanded="false"
                      aria-controls="collapseThree"
                    >
                      How do I know if I have a low-quality audio file?
                    </button>
                  </h2>
                  <div
                    id="collapsefour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingfour"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong>
                      It is hidden by default, until the collapse plugin adds
                      the appropriate classes that we use to style each element.
                      These classes control the overall appearance, as well as
                      the showing and hiding via CSS transitions. You can modify
                      any of this with custom CSS or overriding our default
                      variables. It's also worth noting that just about any HTML
                      can go within the <code>.accordion-body</code>, though the
                      transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingfive">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapsefive"
                      aria-expanded="false"
                      aria-controls="collapseThree"
                    >
                      Do you use speech recognition software to produce your
                      transcriptions?
                    </button>
                  </h2>
                  <div
                    id="collapsefive"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingfive"
                    data-bs-parent="#accordionExample"
                  >
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong>
                      It is hidden by default, until the collapse plugin adds
                      the appropriate classes that we use to style each element.
                      These classes control the overall appearance, as well as
                      the showing and hiding via CSS transitions. You can modify
                      any of this with custom CSS or overriding our default
                      variables. It's also worth noting that just about any HTML
                      can go within the <code>.accordion-body</code>, though the
                      transition does limit overflow.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="get__started">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="get__started__box">
                 <div class="get__content">
                   <h3>Get Started Now</h3>
                   <div class="review review--get gap-5 mt-3">
                    <div class="d-flex justify-content-center gap-2 ">
                     <ul class="nav gap-3">
                       <li><a href=""><i class="fa-solid fa-star"></i></a></li>
                       <li><a href=""><i class="fa-solid fa-star"></i></a></li>
                       <li><a href=""><i class="fa-solid fa-star"></i></a></li>
                       <li><a href=""><i class="fa-solid fa-star"></i></a></li>
                       <li><a href=""><i class="fa-solid fa-star"></i></a></li>
                    </ul>
                    <div>
                      <h3>4.9/5</h3>
                    </div>
                    </div>
                    <div>
                       <h4>
                         3393 customer reviews
                       </h4>
                    </div>
                 </div>
                 <p>Security, privacy, and confidentiality guarantee: 2048-bit SSL encryption, NDA protection
                </p>
                 <button class="place-btn">Order Online</button>
                 </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="get__started__box">
                 <div class="get__content mt-5">
                   <h3>Have a large project?</h3>
                 <p class="mt-3">Connecting business with 20,000+ 
                  transcriptionist workforce
                  
                </p>
                 <div class="mt-60">
                  <button class="place-btn">Order Online</button>
                 </div>
                 </div>
              </div>
            </div>
          </div>
        </div>
    </section>



<style>
.price-loop {
    padding: 0 15px;
}

.price-loop p {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.order__sect {
    margin-top: 41px;
    min-height: auto;
}
</style>