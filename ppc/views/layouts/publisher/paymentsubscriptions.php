<!-- Page wrapper  -->
<script type="text/javascript" src="<?=BASEURL?>accounts/assets/global.js"></script>
<link href="<?=BASEURL?>accounts/view/front/cache/master_adub.css" rel="stylesheet" type="text/css" />
<link href="<?php echo FRONTVIEW . '/cache/' . Cache::cssCacheadub(array('transition.css','label.css','form.css','dropdown.css','input.css','button.css','message.css','image.css','list.css','table.css','icon.css','card.css','modal.css','editor.css','tooltip.css','menu.css','progress.css','utility.css','style.css'), FRONTBASE);?>" rel="stylesheet" type="text/css" />


<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card simple-card">
                    <div class="card-body">
                        <h2 class="text-center mt-2 m-b-0"> Membership/subscription</h2>
                        <p class="text-center ">Your payment info, adding funds, transactions, recurring payments and subscriptions on Adublisher</p>
                        <?php
                        echo loader();
                        $m_id = App::Session()->get('membership_id');

                        if($m_id == 0){
                            ?>
                            <div class="row m-0 p-10">
                                    <div class="col-md-12"><div class="alert alert-warning">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span> </button>
                                                <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning
                                                </h3>You must have to select membership to continue use our services
                                    </div>
                            </div>
                            <?php
                        }else{
                            $trial = "";
                            $mem_expire     =   date("Y-m-d" , strtotime(App::Session()->get('mem_expire')));
                            $current        =   date("Y-m-d");
                            $renew_link     = ", <a href='#' class='add-cart' data-id='".$m_id."'>Click here to renew</a>"; 
                                $days = daysBetween($mem_expire, $current);
                                if(App::Session()->get('trial_used') == 0){
                                    if($days > 0){
                                        $trial  =  "<div class='alert alert-warning'>Your free trial period will end in ".$days ." days". $renew_link."</div>";
                                    }else if($days < 0){
                                        $trial  =  "<div class='alert alert-danger'>Your free trial period expired ".abs($days) ." days ago". $renew_link."</div>";
                                    }else if($days == "0"){
                                        $trial  =  "<div class='alert alert-warning'>Your free trial period will expire today". $renew_link."</div>";
                                    }
                                }else{
                                
                                if($days > 0 && $days < 11){

                                    $trial  =  "<div class='alert alert-warning' >Your membership will expire in ".$days ."days ". $renew_link."</div>";
                                }else if($days < 0){
                                    $trial  =  "<div class='alert alert-danger' >Your membership expired ".abs($days) ."days ago ". $renew_link."</div>";
                                }else if($days == "0"){
                                    $trial  =  "<div class='alert alert-warning' >Your membership will expire today". $renew_link."</div>";
                                }

                                }

                                echo '<div class="col-md-12">'.$trial.'</div>';
                        }
                        ?>

                        <div class="row m-0 p-10">
                        <div class="col-md-12">
                       
                        <div class="card simple-card">
                           
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#subscription" role="tab" aria-selected="true"> <span class=""> Subscription</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#transections" role="tab" aria-selected="false"><span class="">History</span></a> </li>
                               <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#paymentmethods" role="tab" aria-selected="false"><span class="">Deposit funds</span></a> </li>-->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="subscription" role="tabpanel">
                                    <div class="p-3">
                                        <h4>Hi, <?php echo $user->fname;?>  <small> select any subscription which suits you </small>  </h4>
                                    </div>
                                    <div class="row  m-0 p-10 ">
                                      <?php
                                            foreach($packages as $key => $row){
                                                $current = "";
                                                if($m_id == $row->id){
                                                
                                                    $current    = "<div class='ribbon ribbon-success'>Current</div>";
                                                    $current   .= "<input type='hidden' value='".$row->id."' id='current_mem'/>";
                                                    
                                                }
                                                ?>
                                            <div class="col-lg-4 col-md-6 col-xlg-4 col-xs-12">
                                                <div class="card">
                                                    <div class="card-body ribbon-content">
                                                        <?=$current;?>
                                                        <h3 class="card-title text-success text-uppercase text-center"><?=$row->title;?></h3>
                                                        <h1 class="card-price text-center">$<?=$row->price;?></h1>
                                                        <h5 class="card-price text-center" ><span class="period">Per Month</span></h5>
                                                        <hr>
                                                        <?php 
                                                        if($user->membership_id == $row->id){
                                                            ?>
                                                            <p class="ribbon-content text-center mb-2"><button class="btn btn-outline-secondary add-cart" data-id="<?=$row->id?>">Renew</button> <button class="btn btn-outline-danger cancel-membership">Cancel</button></p>

                                                            <?php
                                                            
                                                        }else{
                                                            ?>
                                                                <p class="ribbon-content text-center mb-2"><button class="btn btn-outline-secondary add-cart" data-id="<?=$row->id?>">Select</button></p>
                                                            
                                                            <?php
                                                        }
                                                        ?>
                                                        <hr>
                                                       
                                                        <ul class="fa-ul">
                                                            <?php 
                                                            foreach($row->features as $inKey => $feature){
                                                            $class="fa-check text-success";
                                                            if($feature['status'] != "active"){
                                                                $class="fa-times text-danger";
                                                            }
                                                            if($feature['limit'] == 0){
                                                                $feature['limit'] = '';
                                                            }
                                                            echo '<li class="py-1"><span class="fa-li"><i class="fa '.$class.'"></i></span>'.$feature['limit'].' '.$feature['name'].'</li>';
                                                            }
                                                            ?>
                                                            </ul>
                                                    </div>
                                                </div>
                                            </div>

                                   
                                            <?php 
                                            }
                                            ?>
                                            <div id="mResult" class="col-md-12"></div>

                                    </div>
                                    
                                </div>
                                <div class="tab-pane p-3" id="transections" role="tabpanel">
                                    <div class="p-3">
                                        <h4>Hi, <?php echo $user->fname;?> <small>your subscription history</small> </h4>
                                        <div class="row m-0 p-10 d-block">
                                            <div class="col-12">
                                                    <div class="table-responsive card card-body" >

                                                        <?php if($data):?>
                                                            <table class="wojo simple segment table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><?php echo Lang::$word->NAME;?></th>
                                                                        <th><?php echo Lang::$word->MEM_ACT;?></th>
                                                                        <th><?php echo Lang::$word->MEM_EXP;?></th>
                                                                        <th><?php echo Lang::$word->MEM_REC1;?></th>
                                                                        <th> INVOICE</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <?php foreach ($data as $mrow):?>
                                                                    <tr>
                                                                    <td><?php echo $mrow->title;?></td>
                                                                    <td><?php echo Date::doDate("long_date", $mrow->activated);?></td>
                                                                    <td><?php echo Date::doDate("long_date", $mrow->expire);?></td>
                                                                    <td class="center aligned"><?php echo Utility::isPublished($mrow->recurring);?></td>
                                                                    <td class="center aligned"><a href="<?php echo FRONTVIEW;?>/controller.php?getInvoice=1&amp;id=<?php echo $mrow->tid;?>"><i class="icon download"></i></a></td>
                                                                    </tr>
                                                                    <?php endforeach;?>
                                                            </table>
                                                            <div class="wojo small primary passive inverted button"><?php echo Lang::$word->TRX_TOTAMT;?>
                                                                <?php echo Utility::formatMoney($totals);?></div>
                                                            <?php endif;?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="paymentmethods" role="tabpanel">
                                    <div class="p-3">
                                        <h4>Hi, <?php echo $user->fname;?> <small>make hassle free payments in just few clicks</small> </h4>
                                    </div>
                                    <div class="row m-0 p-10">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-paypal"></i> PayPal</h4>
                                                <p class="card-text">Speedy checkout on millions of stores and apps worldwide.</p>
                                                <a href="<?=SITEURL?>personal-info" class="btn btn-outline-success">Add Funds</a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-cc-stripe"></i> Stripe</h4>
                                                <p class="card-text">Stripe allows individuals and businesses to make payments.</p>
                                                <a href="#" class="btn btn-outline-secondary disabled" >Coming Soon</a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->

        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================-->
<?php $this->load->view('templates/publisher/footer'); ?>

<script type="text/javascript" src="<?=BASEURL?>accounts/view/front/js/master.js"></script> 

<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $.Master({
		url: "<?=BASEURL?>accounts/view/front",
		surl: "<?=BASEURL?>accounts",
        lang: {
            button_text: "Browse...",
            empty_text: "No file...",
        }
    });

    $(".cancel-membership").click(function(){

       
        swal({   
            title: "Are you sure?",   
            text: "You are going to cancel your membership plan!!!",   
            type: "warning",
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, cancel it!",   
            closeOnConfirm: true 
        }, function(){   

                      $.ajax({
                        type: "POST",
                        url: SITEURL + "affiliate_cancelmembership",
                        data: null,
                        dataType: "json",
                        success: function(response){
							if (response) {
                                $.wNotice(response.message, {
                                    autoclose: 12000,
                                    type: "success",
                                    title: "Success"
                                });

							
								setTimeout(() => {
									window.location.reload();
								}, 5000);
							}else{
                                
								$.wNotice("Nothing has been Changed.", {
                                    autoclose: 12000,
                                    type: "error",
                                    title: "Error"
                                });
							}
                        },
                        error: function() {
                            $.wNotice("Nothing has been Changed.", {
                                    autoclose: 12000,
                                    type: "error",
                                    title: "Error"
                                });
                        }
                      });    


        });
      })
});
// ]]>
</script>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>