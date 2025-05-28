
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/manageownerrates.js"></script>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" ng-controller="adubpublisherprofile">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div>
			<div>
				<div class="card simple-card">
					<div class="card-body">
						<h2 class="text-center mt-4"> Pay per click rates</h2>
						<p class="text-center text-muted">You can set default ppc rates for every country, moreover you can set rates for every campaign, user and domain.</p>
						<div class="row p-10 m-0">
	                    					<div class="col-md-12">
						<div class="card">
                        <div class="card-body">
                        <h3 class="p-2 rounded-title">Set rates and press save button
                        <button type="button" id="saverates" class="btn btn btn-outline-secondary pull-right"> <i class="fa fa-floppy-o"></i> Save Rates</button>
                        </h3>
                        <table id="myTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Country</th>
								<th class="no-sort">Rate Per Click</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="item in ratestable">
								<td><img src='assets/general/flags/{{item.code}}.png'> {{item.name}}</td>
								<td><input data-cid={{item.id}}  class="ratesinputs input-sm" value="{{item.rate}}" ></td>
							</tr>
						</tbody>
					    </table>
                        </div>
				        </div>
						</div>
				        </div>
						<input type="hidden"  value="<?=App::Session()->get('team_id');?>"  id="team_id"/>
					</div>
				</div>
			</div>
			<!-- Column -->
		</div>
	</div>
	
</div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
<?php 
$this->load->view('templates/publisher/footer'); 
?>
<script>    
$(function () {

	$(document).on('click', '#saverates', function () {

		var ratesarray = [];
		$(".ratesinputs").each(function () {
			ratesarray.push({
				id: $(this).data('cid'),
				value: $(this).val()
			});
		});
		$.ajax({
			url: 'add_update_rate_owner',
			type: 'POST',
			data: {
				res_id: $('#team_id').val(),
				identifier: 'team',
				rates: JSON.stringify(ratesarray)
			},
			success: function (data) {
				alertbox("Success", "Settings Updated Successfully", "success");
				
			},
			error: function (data) {

				alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

			}
		});

	});
	
});
</script>
