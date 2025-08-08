<?php
    $title = '';
    if($social == 'facebook'){
        $title = "Page";
    }
?>

<option value="">Select <?php echo $title; ?></option>
<?php 
    foreach($sub_accounts AS $key => $account){
?>
        <option value="<?php echo $account->page_id; ?>"><?php echo $account->page_name; ?></option>
<?php
    }
?>