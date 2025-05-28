<?php
  /**
   * Index
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2020
   * @version $Id: index.tpl.php, v1.00 2020-03-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<h2><?php echo Lang::$word->META_T27;?></h2>
<div class="row gutters">
  <div class="columns screen-25 tablet-50 mobile-50 phone-100">
    <div class="wojo segment">
      <div class="center aligned"><span class="wojo positive massive text"><?php echo $this->counters[0];?></span></div>
      <div class="center aligned wojo positive text"><?php echo Lang::$word->AD_RUSER;?></div>
    </div>
  </div>
  <div class="columns screen-25 tablet-50 mobile-50 phone-100">
    <div class="wojo segment">
      <div class="center aligned"><span class="wojo secondary massive text"><?php echo $this->counters[1];?></span></div>
      <div class="center aligned wojo secondary text"><?php echo Lang::$word->AD_AUSER;?></div>
    </div>
  </div>
  <div class="columns screen-25 tablet-50 mobile-50 phone-100">
    <div class="wojo segment">
      <div class="center aligned"><span class="wojo negative massive text"><?php echo $this->counters[2];?></span></div>
      <div class="center aligned wojo negative text"><?php echo Lang::$word->AD_PUSER;?></div>
    </div>
  </div>
  <div class="columns screen-25 tablet-50 mobile-50 phone-100">
    <div class="wojo segment">
      <div class="center aligned"><span class="wojo primary massive text"><?php echo $this->counters[3];?></span></div>
      <div class="center aligned wojo primary text"><?php echo Lang::$word->AD_AMEM;?></div>
    </div>
  </div>
</div>
<?php if(Auth::checkAcl("owner")):?>
<h4><?php echo Lang::$word->AD_TYEAR;?></h4>
<div class="row gutters">
  <div class="columns screen-80 tablet-70 mobile-100 phone-100">
    <div id="legend" class="wojo small horizontal list"></div>
    <div id="payment_chart" style="height:350px" class="wojo segment"></div>
  </div>
  <div class="columns align self middle screen-20 tablet-30 mobile-100 phone-100">
    <div class="wojo segment">
      <p><?php echo Utility::formatMoney($this->stats['totalsum']);?></p>
      <div id="chart1"></div>
    </div>
    <div class="wojo secondary attached basic segment">
      <p><?php echo $this->stats['totalsales'];?>
        <?php echo Lang::$word->TRX_SALES;?></p>
      <div id="chart2"></div>
    </div>
  </div>
</div>
<h4><?php echo Lang::$word->TRX_POPMEM;?></h4>
<div id="legend2" class="wojo small horizontal list align-right"></div>
<div id="payment_chart2" style="height:350px" class="wojo segment"></div>
<?php endif;?>
<?php if(Auth::checkAcl("owner")):?>
<script type="text/javascript" src="<?php echo SITEURLMM;?>/assets/morris.min.js"></script>
<script type="text/javascript" src="<?php echo SITEURLMM;?>/assets/raphael.min.js"></script>
<script type="text/javascript" src="<?php echo SITEURLMM;?>/assets/sparkline.min.js"></script>
<script src="<?php echo ADMINVIEW;?>/js/index.js"></script> 
<script type="text/javascript"> 
// <![CDATA[	
  $(document).ready(function() {
        $('.massive.text').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 3500,
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

        $("#payment_chart").addClass('loading');
        $("#payment_chart2").addClass('loading');
        $.ajax({
            type: 'GET',
            url: "<?php echo ADMINVIEW;?>/helper.php?action=getIndexStats",
            dataType: 'json'
        }).done(function(json) {
            var legend = '';
            json.legend.map(function(val) {
                legend += val;
            });
            $("#legend").html(legend);
            Morris.Line({
                element: 'payment_chart',
                data: json.data,
                xkey: 'm',
                ykeys: json.label,
                labels: json.label,
                parseTime: false,
                lineWidth: 4,
                pointSize: 6,
                lineColors: json.color,
                gridTextColor: "rgba(0,0,0,0.6)",
                gridTextSize: 14,
                fillOpacity: '.75',
                hideHover: 'auto',
                xLabelAngle: 35,
                smooth: true,
                resize: true,
            });
            $("#payment_chart").removeClass('loading');
        });

        $.ajax({
            type: 'GET',
            url: "<?php echo ADMINVIEW;?>/helper.php?action=getMainStats",
            dataType: 'json'
        }).done(function(json) {
            var data = json.data;
            json.legend.map(function(v) {
                return $("#legend2").append(v);
            });
            Morris.Area({
                element: 'payment_chart2',
                data: data,
                xkey: 'm',
                ykeys: json.label,
                labels: json.label,
                parseTime: false,
                lineWidth: 4,
                pointSize: 5,
                lineColors: json.color,
                gridTextColor: "rgba(0,0,0,0.6)",
                fillOpacity: '.65',
                hideHover: 'auto',
                xLabelAngle: 35,
                preUnits: json.preUnits,
                smooth: true,
                resize: true,
            });

            $("#payment_chart2").removeClass('loading');
        });

        var sparkline = function() {
            $('.sparkline').sparkline('html', {
                enableTagOptions: true,
                tagOptionsPrefix: "data"
            });
        };
        var sparkResize;
        $(window).resize(function() {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparkline, 500);
            chart1();
            chart2();
        });
        sparkline();


        var barEl1 = $("#chart1");
        var barValues1 = [<?php echo $this->stats['amount_str'];?>];
        var barValueCount1 = barValues1.length;
        var barSpacing1 = 4;
        var chart1 = function() {
            barEl1.sparkline(barValues1, {
                type: 'bar',
                height: 55,
                barWidth: Math.round((barEl1.parent().width() - (barValueCount1 - 1) * barSpacing1) / barValueCount1),
                barSpacing: barSpacing1,
                zeroAxis: false,
                barColor: '#667eea'
            });
        };

        var barEl2 = $("#chart2");
        var barValues2 = [<?php echo $this->stats['sales_str'];?>];
        var barValueCount2 = barValues2.length;
        var barSpacing2 = 5;
        var chart2 = function() {
            barEl2.sparkline(barValues2, {
                type: 'bar',
                height: 55,
                barWidth: Math.round((barEl2.parent().width() - (barValueCount2 - 1) * barSpacing2) / barValueCount2),
                barSpacing: barSpacing2,
                zeroAxis: false,
                barColor: '#ed64a6'
            });
        };

        chart1();
        chart2();
  });
// ]]>
</script> 
<?php endif;?>