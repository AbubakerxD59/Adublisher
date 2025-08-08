 <?php if ($this->router->fetch_method() == "editprofile") { ?>
   <script src="<?= GeneralAssets ?>plugins/timezone/timezones.full.js"></script>
 <?php } ?>

 <!-- <script src="<?= PublisherAssets ?>js/publisher.js?v=<?= BUILDNUMBER ?>"></script> -->
 <script type="text/javascript">
   $(function() {
     $(".change_status").click(function() {
       var n_id = $(this).data('id');
       var element = $(this);
       var dataNOBJ = {
         'id': n_id
       }
       $.ajax({
         type: "POST",
         url: "<?php echo SITEURL; ?>mark_read",
         data: dataNOBJ,
         dataType: "json",
         success: function(response) {
           if (response.status) {
             element.removeClass('text-muted').addClass('text-success');
           }
         },
         error: function() {}
       });
       return false;
     });
   });
 </script>
 <script>
   ///  This is my visiblity function for left-sidebar
   $(document).ready(function() {
     $('.nav-toggler.hidden-md-up').on('click', function() {
       $('.left-sidebar').toggleClass('visible');
     });
   });
 </script>