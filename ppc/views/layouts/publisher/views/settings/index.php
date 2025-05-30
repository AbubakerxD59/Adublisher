<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-address-card"></i> Personal info</h4>
                <p class="card-text">Update personal details like name, contact, email timezone that you use on Adublisher.</p>
                <a href="<?= SITEURL ?>personal-info" class="btn btn-outline-secondary">Goto page</a>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-key"></i> Security</h4>
                <p class="card-text">Security settings and recommendations to help you keep your account secure on Adublisher.</p>
                <a href="<?= SITEURL ?>security-settings" class="btn btn-outline-secondary">Goto page</a>

            </div>
        </div>
    </div>
    <?php
    if (App::Session()->get('team_role') == 'owner') {
    ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa fa-credit-card"></i> Payments & subscriptions</h4>
                    <p class="card-text">Your payment info, adding funds, transactions, payments and subscriptions on Adublisher.</p>
                    <a href="<?= SITEURL ?>payments-and-subscriptions" class="btn btn-outline-secondary">Goto page</a>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa fa-paypal"></i> Payments methods</h4>
                    <p class="card-text">Update/Add payment details so your employeer can send you payment.</p>
                    <a href="<?= SITEURL ?>payment-method" class="btn btn-outline-secondary">Goto page</a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>