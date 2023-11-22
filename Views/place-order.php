<?php echo (isset($_SESSION['userdata']))?'hai':'nhi'; ?>
<section class="orderbg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="orderbg__content">
                    <div class="row">
                        <div class="col-sm-12 col-lg-3">
                            <h3>Work Process :-</h3>
                        </div>
                        <div class="col-sm-12 col-lg-9">
                            <div class="orderbg__steps">
                                <div class="row justify-content-center">
                                    <ul id="progressbar">
							
							<?php 
							if(isset($_SESSION['userdata']))
							{
							if(!$session->get('userdata')['logged_in']){ ?>
							<li id="step1">
								<strong>Add files</strong>
							</li>
							<li id="step2"><strong>Login/sign-up</strong></li>
							<li class="active" id="step3"><strong>Payment</strong></li>    
							<li id="step4"><strong>Complete order</strong></li>
							<?php } ?>
							<?php if($session->get('userdata')['logged_in']){ ?>
							<li id="step1" class="active">
								<strong>Add files</strong>
							</li>
							<li  id="step2"><strong>Payment</strong></li>    
							<li id="step3"><strong>Complete order</strong></li>
							<?php }}else{ ?>
							<li id="step1" class="active">
								<strong>Add files</strong>
							</li>
							<li id="step2"><strong>Login/sign-up</strong></li>
							<li  id="step3"><strong>Payment</strong></li> 
							<li id="step4"><strong>Complete order</strong></li>
							<?php } ?>
						</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="step__1">
                                <form id="upload-form" class="upload-form" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="d-flex gap-5 review">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn-upload">
                                                    <span><img src="https://gotranscript.tridentdispatch.com/assets/images/file-audio.svg " alt="" /></span>Upload files
                                                </button>
                                                <input type="file" name="upl_file[]" id="myfile" multiple="" />
                                            </div>

                                        </div>
                                    </fieldset>
                                </form>
                                <div>
                                    <p class="text-center mt-4 align-items-center">
                                        <span class="pe-3"><img src="https://gotranscript.tridentdispatch.com/assets/images/lock.svg" alt="" /></span>Security, privacy, and confidentiality guarantee: 2048-bit SSL encryption, NDA protection
                                    </p>
                                    <span class="text-center mt-4 align-items-center" id="file_msg" style="color:red;"></span>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="progress" class="" style="display: none;">
	<div class="container">
	<div class="row">
			<div class="col-lg-9 ">
				<div id="overall-progress-bar" style="padding:0px;">
				<div id="countmsg"></div>
				<div class="order_header progress">
				<div id="file-progress-bars" class="progress-bars" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				</div>
				
				

			</div>
	</div>
	</div>
</section>
<!--
<div id="result">
	<?php //pr($session); ?>
</div>
-->
<div id="result">
	<?php
	//if($session->has('file_data'))
	//{
	//	echo $session->get('file_data');
	//}
	?>
</div>	

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
<div id="myModal" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="s-upload-done-modal-content__title">
                    <svg width="45" height="30" viewBox="0 0 45 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_2075_25262strwymuefp6f3caenirggqt4i7lp2" style="mask-type: alpha;" maskUnits="userSpaceOnUse" x="0" y="0" width="45" height="30">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0H44.9062V30H0V0Z" fill="white"></path>
                        </mask>
                        <g mask="url(#mask0_2075_25262strwymuefp6f3caenirggqt4i7lp2)">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M44.3541 0.954667C43.8903 0.386386 43.206 0.0394752 42.4777 0.0030592C41.7465 -0.0323985 41.0326 0.24168 40.516 0.757254L17.7234 23.5508C17.5749 23.6994 17.3324 23.6994 17.1839 23.5508L4.49963 10.8665C3.52502 9.89001 1.9668 9.77501 0.953858 10.6049C0.386534 11.0707 0.0396237 11.7549 0.00320772 12.4823C-0.0332083 13.2115 0.241829 13.9255 0.757403 14.4411L15.5136 29.1972C16.032 29.7157 16.721 30.0003 17.4541 30.0003C18.1863 30.0003 18.8753 29.7157 19.3938 29.1972L44.0915 4.50044C45.0661 3.52391 45.1821 1.96665 44.3541 0.954667Z"
                                fill="#FFBA00"
                            ></path>
                        </g>
                    </svg>
                    <div class="s-upload-done-modal-content__title-text js-upload-done-toggle js-upload-done-links" style="display: none;">
                        <span class="js-upload-done-total filenum_url">1</span> of <span class="js-upload-done-total filenum_url">1</span> URLs added
                    </div>
                    <div class="s-upload-done-modal-content__title-text js-upload-done-toggle js-upload-done-regular" style="">
                        <span class="js-upload-done-total filenum">1</span> of <span class="js-upload-done-total filenum">1</span> files added
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12 col-md-6">
                        <button type="button" class="s-upload-done-modal-content__btn-upload js-upload-done-toggle js-upload-done-links js-upload-done-urls-btn" data-bs-dismiss="modal" aria-label="Close" style="display: none;">
                            ADD URL
                        </button>
                        <button type="button" class="s-upload-done-modal-content__btn-upload js-upload-done-toggle js-upload-done-regular js-upload-done-files-btn" data-bs-dismiss="modal" aria-label="Close" style="">UPLOAD FILE</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button id="closeBtn" type="button" class="s-upload-done-modal-content__btn-done" data-bs-dismiss="modal" aria-label="Close">DONE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	
<style>
.lds-ripple {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ripple div {
  position: absolute;
  border: 4px solid #fff;
  opacity: 1;
  border-radius: 50%;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes lds-ripple {
  0% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  4.9% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  5% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 0px;
    left: 0px;
    width: 72px;
    height: 72px;
    opacity: 0;
  }
}
	
input[type='radio']
{
	cursor:pointer;
}
	.orderbg__content .review {
    justify-content: center;
}
body.modal-open .modal {
    display: flex !important;
    height: 100%;
} 

body.modal-open .modal .modal-dialog {
    margin: auto;
}	
	
	
.modal-body {
    background: #002052;
    border-radius: 5px;
    padding: 40px 43px;
    width: 600px;
}

.s-upload-done-modal-content__title {
    color: #FFF;
    font-size: 24px;
    line-height: 36px;
    font-weight: 600;
    margin-bottom: 37px;
    text-align: center;
}

.s-upload-done-modal-content__title svg {
    display: inline-block;
    vertical-align: -4px;
    margin-right: 20px;
}

.s-upload-done-modal-content__title-text.js-upload-done-toggle.js-upload-done-regular {
    display: inline-block;
}

button.s-upload-done-modal-content__btn-upload.js-upload-done-toggle.js-upload-done-links.js-upload-done-urls-btn {
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    transition: .3s;
    color: #002052;
    border: none;
    border-radius: 30px;
    background-color: #FFBA00;
    box-shadow: 0 2px 10px #00000030;
    width: 100%;
    padding: 8px 0;
}

button.s-upload-done-modal-content__btn-upload.js-upload-done-toggle.js-upload-done-regular.js-upload-done-files-btn {
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    transition: .3s;
    color: #002052;
    border: none;
    border-radius: 30px;
    background-color: #FFBA00;
    box-shadow: 0 2px 10px #00000030;
    width: 100%;
    padding: 8px 0;
}

button.s-upload-done-modal-content__btn-done {
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    transition: .3s;
    color: #FFF;
    border: 1px solid #9CC4FF;
    border-radius: 30px;
    background-color: #002052;
    box-shadow: 0 2px 10px #00000030;
    width: 100%;
    padding: 7px 0;
}		

div#uploaded_file>table:first-child {
    background: rgba(191, 30, 46, 1);
    color: #fff;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

div#uploaded_file>table:first-child td p {
    color: #fff;
    border: none;
}

div#uploaded_file>table:first-child tr {
    border: none;
}

div#uploaded_file>table:first-child th {
    border: none;
}

div#uploaded_file>table:first-child tr td .me-4 {
    margin-left: 5px;
}
.order_header.order_option_flex table th, .order_header.order_option_flex table td, .order_header.order_option_flex table tr {
    border: none;
    padding-top: 0;
    color: #fff;
}
a.s-upload-show-uploaded-file-table-bottom__btn.js-gtm-continue {
    display: block;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    transition: .3s;
    color: #002052;
    border-radius: 30px;
    background-color: #FFBA00;
    box-shadow: 0 2px 10px #00000030;
    width: 100%;
    padding: 8px 25px;
    margin-top: 20px;
}
section#progress {
    margin-top: 41px;
}
#file-progress-bars {
    width: 300px;
    display: grid;
}
div#file-progress-bars span {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    width: 100%;
}
.progressBar {
    background-color: rgba(255, 222, 0, 1);
    height: 17px;
    font-size: 13px;
    max-width: 300px;
    text-align: center;
    padding: 2px 0;
    display: inline-table;
}
section#progress .order_header {
    background: #ecf4ff !important;
	color:#000;
}
.flex_loc > div {
    display: flex !important;
    float: left;
    margin-right: 45px;
}

.flex_loc > div span {
    font-weight: bold;
    font-size: 18px;
}
.order__sect .order_option {
    max-height: unset !important;
	border:none !important;
}
.order-area-flex {
    border: 1px solid rgba(191, 30, 46, 0.8);
    margin-bottom: 20px;
    border-top-right-radius: 14px;
    border-top-left-radius: 14px;
}
div#loader {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform: -webkit-translate(-50%, -50%);
    transform: -moz-translate(-50%, -50%);
    transform: -ms-translate(-50%, -50%);
    background: #0000002b;
    width: 100%;
    height: 100%;
    z-index: 9999;
}

div#loader > div {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform: -webkit-translate(-50%, -50%);
    transform: -moz-translate(-50%, -50%);
    transform: -ms-translate(-50%, -50%);
    /* background: #000; */
    /* width: 100%; */
    /* height: 100%; */
    z-index: 9999;
}
.s-upload-show-uploaded-file-table-bottom__btn.js-gtm-continue {
    display: block;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    transition: .3s;
    color: #002052;
    border-radius: 30px;
    background-color: #FFBA00;
    box-shadow: 0 2px 10px #00000030;
    width: 100%;
    padding: 8px 25px;
    margin-top: 20px;
}
</style>

<script>
$(document).ready(function() {
	
	var totalVideosToUpload = 0;
    var videosUploaded = 0;
	
	$("button.s-upload-done-modal-content__btn-upload").click(function(){
		$('#myfile').trigger('click'); 
		$('input[name=upl_file').val('');
	});
	
	getSessionUploadFiles();
	

    $(document).on("change", "#myfile", function (event) {
    event.preventDefault();
	
	if($('#myfile').val() != ''){
		
	var ext = $('#myfile').val().split('.').pop().toLowerCase();
	alert(ext);
       if($.inArray(ext, ['mov','rm','mp3','mp4','aac','aiff','avi','divx','dss','flv','mxf','ogg','vob','wav','wmv']) == -1) {
           
           $("#file_msg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
           return false; 
       }
	}
	

    $("#file_msg").empty();

    var files = $(this)[0].files;
    $('#file-progress-bars').empty();
	
	if(files.length == 1)
	{
		var text = ' file is uploading';
	}
	else
	{
		var text = ' files are uploading';
	}
	$("#countmsg").html(files.length + text);
	totalVideosToUpload = files.length;
    videosUploaded = 0;

    for (var i = 0; i < files.length; i++) {
		//$("#file-progress-bars").append('<div class="progressBar" id="progressBar' + i + '"></div><span>' + this.files[i].name + '</span>');
        var videoID = generateUniqueID(); // Generate a unique video ID
		createProgressElement(videoID, files[i].name);
        uploadVideoFile(files[i], videoID);
    }
});

function generateUniqueID() {
    return Date.now().toString();
}
function createProgressElement111(videoID, fileName) {
	var progressBar = '<div class="progress-bar-1" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" id="progressBar' + videoID + '"></div>';
	var progressText = '<div class="progress-text" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" id="progressText' + videoID + '">' + fileName + '  0%</div>';

	$('.progress').append(progressBar);
	$('.progress').append(progressText);
}



function createProgressElement(videoID, fileName) {
    var progressBar = '<div class="progress-container">' +
                        '<div class="progress-bar-1" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" id="progressBar' + videoID + '"></div>' +
                    '</div>';
    var progressText = '<div class="progress-text" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" id="progressText' + videoID + '">' + fileName + '</div>';

    $('.progress').append(progressBar);
    $('.progress').append(progressText);
}




function updateProgress(videoID, percent) {
	$('#progressBar' + videoID ).css('width', percent + '%');
	$('#progressBar'+ videoID ).text(percent + '%');
}
			
function uploadVideoFile(file, videoID) {
    var chunkSize = 1024 * 1024; // 5MB chunks
    var totalChunks = Math.ceil(file.size / chunkSize);
    var chunkIndex = 0;
    var videoName = file.name.replace(/[^a-zA-Z0-9]/g, ''); // Remove spaces and special characters

    function processChunk() {
        var start = chunkIndex * chunkSize;
        var end = Math.min(start + chunkSize, file.size);
        var blob = file.slice(start, end);

        var formData = new FormData();
        formData.append('chunk', blob);
        formData.append('isLastChunk', chunkIndex === totalChunks - 1);
        formData.append('videoName', videoName);
        formData.append('originalFileName', file.name);
        formData.append('originalFileExtension', file.name.split('.').pop());
        formData.append('videoID', videoID); // Pass the video ID

        $.ajax({
            url: BASE_URL + 'Order/upl1',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
			dataType:'json',
			async: true,
			beforeSend: function(){
				 showLoader(); 
				$("#progress").show();
			},
			
			success: function(json) {
				
				
			  
			  if(json.status == 'error')
			  {
				  $("#file_msg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+json.msg+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
				  $("#loader").hide();
				  $("#overall-progress-bar").fadeOut();
				  $(document).ajaxStop(function() {
				  
				  });
				  
				  if(json.msgchk = 'duplicate')
				  {
					setTimeout(function() {
					location.reload();
					}, 2000);
				  }
				  
			  }
			  else
			  {
			  $("#result").append(json.html);
			  $("#result").fadeIn();
			  $("#progress").fadeOut();
			  $("#myModal .modal-body .filenum").text( json.filesCount );
			  //var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
			  //myModal.show();
			  }
			},
			complete: function() {
				chunkIndex++;
				var overallProgress = Math.round((chunkIndex / totalChunks) * 100);
                updateProgress(videoID, overallProgress);
                if (chunkIndex < totalChunks) {
                    processChunk();
                } else {
					hideLoader();  
					$("#countmsg").html('');
					update_tat($("language").val());
					getSessionUploadFiles();
					$('input[name=upl_file').val('');	
					videosUploaded++; // Increment the uploaded videos counter

					if (videosUploaded === totalVideosToUpload) {
						var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
						myModal.show();
						$('.progress').empty();// added by khemit
					}
					
                }
				
			}
			
        });
    }

    processChunk(); // Start the chunking process
}





});	

/*
$(document).ready(function() {
	
	
$(document).ajaxStart(function () {
    showLoader();
});

$(document).ajaxComplete(function () {
   hideLoader();  
});
	
	$("button.s-upload-done-modal-content__btn-upload").click(function(){
		$('#myfile').trigger('click'); 
		$('input[name=upl_file').val('');
	});
	
	getSessionUploadFiles();
	

    $(document).on("change", "#myfile", function(event){	
		event.preventDefault();
		
		$("#file_msg").empty();
		
		var files = $(this)[0].files;
		  $('#file-progress-bars').empty();

		  for (var i = 0; i < files.length; i++) {
			$("#file-progress-bars").append('<div class="progressBar" id="progressBar' + i + '"></div><span>'+this.files[i].name+'</span>');
		
		  }
		
		uploadFiles();
    });

    function uploadFiles() {
      var formData = new FormData($('#upload-form')[0]);
      var files = $("#myfile").prop("files");
      
     
     
        var input = document.getElementById('myfile');
  
  
  
        var str =[];
        $('.filenames > p').each(function(){
          str.push($(this).text());
        })
        //console.log(str);
  
        var children =  [];
        for (var i = 0; i < input.files.length; ++i) {
              //children.push(input.files.item(i).name);
              
              if(jQuery.inArray(input.files.item(i).name, str) !== -1)
              {
                
                 $("#file_msg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">You are trying to upload duplicate file.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
           return false; 
              }
              
              
              
        }

        
       
     
      
       var ext = $('#myfile').val().split('.').pop().toLowerCase();
       if($.inArray(ext, ['mov','rm','mp3','mp4','aac','aiff','avi','divx','dss','flv','mxf','ogg','vob','wav','wmv']) == -1) {
           
           $("#file_msg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
           return false; 
       }



      // Add each file to the formData object
      //for (var i = 0; i < files.length; i++) {
      //  formData.append('files[]', files[i]);
     // }

      // Ajax request to handle file upload
      $.ajax({
        url: BASE_URL+'Order/upl',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        xhr: function() {
          // Create XMLHttpRequest with progress events
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
			  
              var progress = (evt.loaded / evt.total) * 100;
              $(".progressBar").css("width", progress + "%");
			  $(".progressBar").html(progress.toFixed(0) + "%");
			  
            }
          }, false);
          return xhr;
        },
		dataType:'json',
		async: true,
		beforeSend: function(){
			 
			$("#progress").show();
			//$("#result").hide();
			//$("#file-progress-bar").show();
			//$("#file-progress-bar").width('0%');
			//$("#extractedFileName").html(extractedFileName);
		},

        success: function(json) {
         
          if(json.status == 'error')
          {
              $("#file_msg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+json.msg+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
              //$("#progress").fadeOut();
          }
          else
          {
		  $("#result").append(json.html);
		  $("#result").fadeIn();
		  $("#progress").fadeOut();
		
		 
		  
		  //for (let i = 0; i < json.filesCount; i++) {
		  
		  //}
		  $("#myModal .modal-body .filenum").text( json.filesCount );
		  var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
		  myModal.show();
          }
        },
		complete: function() {
		    update_tat($("language").val());
			getSessionUploadFiles();
			$('input[name=upl_file').val('');
			
		}
      });
    }

  });
*/  
  function update_tat(lang)
  {
	//alert(lang);
	if(lang == 'undefined')
	{
		return false;
	}
	$.ajax({
		url: BASE_URL+"Order/update_tat",
		type: "POST",
		data: {'lang':lang},
		dataType: "JSON",
		//async: false,
		beforeSend: function() {
		//	$("#loader").show(); 
			$("#tat_data").empty();
			$("#tat_data").html('<span class="loadersmall"></span>');
		},
		success: function(response) {
			$("#tat_data").html(response.html);
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			//$("#result").html("Error: " + textStatus + " - " + errorThrown);
		},
		complete: function() {
		    	//getFormData();
				
			calculatePrice(lang);
			//}
			
		}
	});
  }
  
  function calculatePrice(lang)
  {
	$.ajax({
		url: BASE_URL+"Order/calculatePrice",
		type: "POST",
		data: {'seconds':$("#seconds").val(),'tat': $("#tat_data input[type='radio']:checked").val(), 'lang':lang, 'text_format':$(".text_format_class:checked").val(),'speakers':$(".speakers_class:checked").val(), 'quality':$(".quality_class:checked").val(), 'timestamping':$(".timestamping_class").val()},
		dataType: "JSON",
		async: false,
		beforeSend: function() {
			showLoader();
			$("#tot_duration").html('<span class="loadersmall"></span>');
			$("#tot_price").html('<span class="loadersmall"></span>');
		},
		success: function(response) {
			var priceFinal = 0;
			$(response).each(function (i,value) {
				//console.log(value);
				//console.log(i);
				$("#tot_price_"+i+"").text('$'+value.price);
				$("#tot_duration_"+i+"").text(value.mins);
				$("#hidden_tot_price_"+i+"").val(value.price);
				$("#hidden_tot_price_"+i+"").val(value.price); 	
				priceFinal += parseFloat(value.price);
				//$("#tot_duration").text(response.sec_format);
			});
			$("#final_tot_price").text('$'+priceFinal.toFixed(2));
			
			
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			//$("#result").html("Error: " + textStatus + " - " + errorThrown);
		},
		complete: function() {
			$('input[name=upl_file').val('');
			hideLoader();
			
			
		}
	});
  }


  function getSessionUploadFiles()
 {
		$.ajax({
			type: 'POST',
			url: BASE_URL+'Order/getSessionUploadFiles',
			data: {},
			dataType:'json',	
			async: true,
			beforeSend: function() {
				showLoader();
			},
			success: function(response){
				$("#result").html(response.html);
				
				
			},
			complete: function() {
				hideLoader();
				update_tat($("#language").val());
			}
		 });
	}

  $(document).on("change", "#language", function(event){	
	event.preventDefault();
	//$("#loader").show(); 
	update_tat($("#language").val());
	getFormData();
	//calculatePrice($("#language").val());
  });
  
  
  $(document).on("change", "#timestamping, input[name=text_format], input[name=speakers], input[name=quality]", function(event){	
	event.preventDefault();
	//$("#loader").show(); 
	
	getFormData();
	calculatePrice($("#language").val());
  });
  
  $(document).on("change", "input[name=tat]", function(event){	
	event.preventDefault();
	//update_tat($("#language").val());
	getFormData();
	calculatePrice($("#language").val());
  });
  
  function getFormData()
  {
	$.ajax
	({
		url: BASE_URL+"Order/getFormData",
		type: "POST",
		data: $("#order_data").serialize(),
		dataType: "JSON",
		async: false,
		beforeSend: function() {
			showLoader();
		},
		success: function(response) {
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
		
		},
		complete: function() {
			hideLoader();
			
			
		}
	});
			
  }
  
  function removeItem(itemnumber)
{
	$.ajax({
		type: 'POST',
        url: BASE_URL+'Order/removeItem',
		data: {'itemnumber': itemnumber},
		dataType:'json',	
		beforeSend: function() {
			showLoader();
		},
		success: function(response){
		if(response.remain == 0)
		{
			$("#result").fadeOut();
			$("#result").empty();
		}
		getSessionUploadFiles();
			
		},
		complete: function() {
			hideLoader();
			$('input[name=upl_file').val('');
			
		}
	 });
	
} 
  

  
function showLoader() {
    $("#loader").css("display", "block");
}

function hideLoader() {
    setTimeout(function () {
        $("#loader").css("display", "none");
    }, 1000);
}
$(document).on("submit", "#order_data", function(e){
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: "POST",
        url: BASE_URL+"Order/orderData",
        data: form.serialize(), // serializes the form's elements.
		dataType:"JSON",
        beforeSend: function() {
			showLoader();
		},
		success: function(response) {
			if(response.status == 'redirect')
			{
				window.location.href = response.redirect;
			}
			if(response.status == 'success')
			{
				window.location.href = response.redirect;
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
		
		},
		complete: function() {
			hideLoader();  
			
			
		}
    });
    
});
</script>  


<style>
    .price-loop p {
    overflow: hidden;
    text-overflow: ellipsis;
}
.progressBar {
    box-shadow: 10px 10px 10px 10px #ddd;
    border: 1px solid #ccc;
}
div#overall-progress-bar {
    position: relative;
}

div#countmsg {
    position: absolute;
    left: 55px;
    top: 10px;
}
div#file-progress-bars {
    background: #ffcc00;
    float: left;
    display: inline-table;
    padding-left: 15px;
}
.progress {
    height: auto !important;
}
.order_header.progress {
    display: grid !important;
}
.progress-container > div {
    background: #ffcc00;
}
</style>