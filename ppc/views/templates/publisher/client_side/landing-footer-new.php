  <!-- Footer -->
  <div id="footer" class="container-fluid">
      <div class="container pt-5">
          <div class="row">
              <div class="footer-container col-12 pb-5">
                  <div class="row text-center text-md-start mx-auto">
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Company
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a href="#">About Us</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'pricing'; ?>">Plans & Pricing</a>
                                  </li>
                                  <li>
                                      <a href="#">Give Feedback</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Features
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a href="<?php echo SITEURL . 'calendar-view'; ?>">Calender View</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'analytic'; ?>">Analytics</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'curate-post'; ?>">Curate Post</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'bulk-schedule'; ?>">Bulk Schedule</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'recycling'; ?>">Recycle</a>
                                  </li>
                                  <li>
                                      <a href="<?php echo SITEURL . 'automations'; ?>">Automation</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Integrations
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a href="#">Youtube</a>
                                  </li>
                                  <li>
                                      <a href="#">Facebook</a>
                                  </li>
                                  <li>
                                      <a href="#">Instagram</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Resources
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a href="<?php echo SITEURL . 'blogs'; ?>">Blog</a>
                                  </li>
                                  <li>
                                      <a>Book a Call</a>
                                  </li>
                                  <li>
                                      <a>Product Updates</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Compare
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a>Adublishers vs.Hootsuite</a>
                                  </li>
                                  <li>
                                      <a>Adublishers vs.Sprout Social</a>
                                  </li>
                                  <li>
                                      <a>Adublishers vs.Later</a>
                                  </li>
                                  <li>
                                      <a>Adublishers vs.Buffer</a>
                                  </li>
                                  <li>
                                      <a>Adublishers vs.SocialPilot</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-xl-2 my-4 m-md-0">
                          <div class="footer-high">
                              <h2>
                                  Free Tools
                              </h2>
                              <ul class="p-0">
                                  <li>
                                      <a href="<?php echo SITEURL . 'link-shortener'; ?>">URL Link Shortner</a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="footer-lower d-md-flex text-center justify-content-between align-center border-top py-4">
                  <p class="foot-content">
                      © 2024 Adublishers Limited | All Rights Reserved.
                  </p>
                  <div class="foot-end-links">
                      <a href="<?php echo SITEURL . 'terms'; ?>">Terms of Services</a>
                      <a href="<?php echo SITEURL . 'privacy'; ?>">Privacy Policy</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <?php $this->load->view('templates/publisher/external_head_scripts'); ?>
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
  <!-- Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- GSAP -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
  <!-- Scroll Trigger -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
  <!-- Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <!-- Bootstrap.min -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="<?= ASSETURL ?>plugins/sweetalert/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
  <!-- Custom JS -->
  <script src="<?php echo ASSETURL . 'js/main.js'; ?>"></script>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
      var Tawk_API = Tawk_API || {},
          Tawk_LoadStart = new Date();
      (function() {
          var s1 = document.createElement("script"),
              s0 = document.getElementsByTagName("script")[0];
          s1.async = true;
          s1.src = 'https://embed.tawk.to/5abeaf1fd7591465c7091240/default';
          s1.charset = 'UTF-8';
          s1.setAttribute('crossorigin', '*');
          s0.parentNode.insertBefore(s1, s0);
      })();
  </script>
  <!--End of Tawk.to Script-->