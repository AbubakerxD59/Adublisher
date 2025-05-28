<?php
  /**
   * Footer
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2020
   * @version $Id: footer.tpl.php, v1.00 2020-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<!-- Footer -->
</div>
</div>
</section>

<footer id="footer">
        <div class="container">
            <div class="row">
            <div class="col-md-6">
                 <p class="text-left m-0 text-white">&copy; 2015–<?php echo date('Y') . ' '. $this->core->company;?>™ All rights reserved <a href="<?=SITEURL?>terms"> Privacy & terms</a></p>
            </div>
            <div class="col-md-6">
                 <p class="text-right m-0 text-white">Made with <i class="icofont-heart-alt text-danger"></i>  by <a class="text-white" href="#">Solvare Technologies PVT LTD.</a></p>
            </div>
            </div>
        </div>
    </footer>

<script type="text/javascript" src="<?php echo FRONTVIEW;?>/js/master.js"></script> 
<?php Debug::displayInfo();?>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $.Master({
		url: "<?php echo FRONTVIEW;?>",
		surl: "<?php echo SITEURL;?>",
        lang: {
            button_text: "<?php echo Lang::$word->BROWSE;?>",
            empty_text: "<?php echo Lang::$word->NOFILE;?>",
        }
    });
});
// ]]>
</script>
<?php if(Utility::in_array_any(["dashboard"], $this->segments)):?>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<?php endif;?>
</body>
</html>

