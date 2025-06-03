<h2 class="text-center">Traffic Report</h2>
<p class="text-center text-muted">Traffic Report for your account, Filter by date, affiliate,
    country and campaigns.</p>
<div class="row d-flex justify-content-between mt-4">
    <div class="form-group col-md-3">
        <select class="form-control" name="report_filter" id="report_filter">
            <option value="affiliate">AFFILIATE</option>
            <option value="campaign" selected>CAMPAIGN</option>
            <option value="country">COUNTRY</option>
        </select>
    </div>
    <div class="form-group col-md-3 info_tab text-center" style="display: none;">
        <small>EARNING:</small>
        <b><span class="earning"></span></b>
    </div>
    <div class="form-group col-md-3 info_tab text-center" style="display: none;">
        <small>TOTAL CLICKS:</small>
        <b><span class="total_clicks"></span></b>
    </div>
    <div id="usersdaterange" class="col-md-3 form-control p-2">
        <i class="fa fa-calendar"></i> &nbsp; <span></span> &nbsp;<b
            class="fa fa-caret-down"></b>&nbsp;
    </div>
</div>
<div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="60%">Name</th>
                <th width="20%">Clicks</th>
                <th width="20%">Earning</th>
            </tr>
        </thead>
        <tbody id="report_data">
        </tbody>
    </table>
</div>