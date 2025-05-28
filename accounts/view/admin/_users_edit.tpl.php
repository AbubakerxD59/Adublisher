<?php
/**
 * User Manager
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: _users_edit.tpl.php, v1.00 2020-02-08 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
  die('Direct access to this location is not allowed.');
?>
<h2><?php echo Lang::$word->META_T3; ?></h2>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (count($this->facebook_count) > 0) {
  include('facebook_pages_users.tpl.php');
}
if (count($this->pinterest_count) > 0) {
  include('pinterest_pages_users.tpl.php');
}
if (count($this->youtube_count) > 0) {
  include('youtube_pages_users.tpl.php');
}
?>
<form method="post" id="wojo_form" name="wojo_form">
  <div class="wojo segment form">
    <div class="wojo fields">
      <div class="field three wide">
        <label><?php echo "USERNAME"; ?>
        </label>
        <input type="text" placeholder="Username" value="<?php echo $this->data->username; ?>" name="username" readonly>
      </div>
      <div class="field three wide">
        <label><?php echo Lang::$word->M_SUB8; ?>
        </label>
        <select name="membership_id">
          <option value="0">-/-</option>
          <?php echo Utility::loopOptions($this->mlist, "id", "title", $this->data->membership_id); ?>
        </select>
      </div>
      <!-- <div class="field two wide">
        <label><?php echo Lang::$word->M_SUB8; ?>
        </label>
        <div class="wojo fitted inline toggle checkbox">
          <input name="update_membership" type="checkbox" value="1" id="update_membership">
          <label for="update_membership"><?php echo Lang::$word->YES; ?></label>
        </div>
      </div> -->
      <div class="field four wide">
        <label><?php echo Lang::$word->M_SUB15; ?></label>
        <input placeholder="<?php echo Lang::$word->TO; ?>" name="mem_expire" type="text"
          value="<?php echo date("m/d/Y", strtotime($this->data->mem_expire)); ?>" readonly class="datepick">
        <!-- <input placeholder="<?php echo Lang::$word->TO; ?>" name="mem_expire" type="text" value="<?php echo Date::doDate("MM/dd/yyyy", Date::NumberOfDays('+ 30 day')); ?>" readonly class="datepick"> -->
      </div>
      <!-- <div class="field two wide">
        <label><?php echo Lang::$word->M_SUB15; ?></label>
        <div class="wojo fitted inline toggle checkbox">
          <input name="extend_membership" type="checkbox" value="1" id="extend_membership">
          <label for="extend_membership"><?php echo Lang::$word->YES; ?></label>
        </div>
      </div> -->
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_SUB23; ?></label>
        <div class="wojo fitted inline checkbox">
          <input name="add_trans" type="checkbox" value="1" id="add_trans">
          <label for="add_trans"><?php echo Lang::$word->YES; ?></label>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field three wide">
        <div class="field" style="padding: 0px;">
          <label><?php echo Lang::$word->CREATED; ?></label>
          <?php echo Date::doDate("long_date", $this->data->created); ?>
        </div>
        <div class="field" style="padding: 0px;">
          <label><?php echo Lang::$word->M_LASTLOGIN; ?></label>
          <?php echo $this->data->lastlogin ? Date::doDate("long_date", $this->data->lastlogin) : Lang::$word->NEVER; ?>
        </div>
        <div class="field" style="padding: 0px;">
          <label><?php echo "LOGIN COUNTRY"; ?></label>
          <?php
          $ip = $this->data->lastip;
          $ip_details = 'NA';
          if ($ip != '000.000.000.000') {
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            if (!empty($details) && isset($details->city)) {
              $ip_details = $details->city . ', ' . $details->country;
            }
          }
          echo $ip_details;
          ?>
        </div>
      </div>
      <div class="field four wide">
        <div class="field" style="padding: 0px;">
          <label><?php echo Lang::$word->STATUS; ?></label>
          <div class="wojo checkbox radio fitted inline">
            <input name="active" type="radio" value="y" id="active_y" <?php Validator::getChecked($this->data->active, "y"); ?>>
            <label for="active_y"><?php echo Lang::$word->ACTIVE; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="active" type="radio" value="n" id="active_n" <?php Validator::getChecked($this->data->active, "n"); ?>>
            <label for="active_n"><?php echo Lang::$word->INACTIVE; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="active" type="radio" value="t" id="active_t" <?php Validator::getChecked($this->data->active, "t"); ?>>
            <label for="active_t"><?php echo Lang::$word->PENDING; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="active" type="radio" value="b" id="active_b" <?php Validator::getChecked($this->data->active, "b"); ?>>
            <label for="active_b"><?php echo Lang::$word->BANNED; ?></label>
          </div>
        </div>
        <div class="field" style="padding: 0px;">
          <label><?php echo Lang::$word->M_SUB9; ?></label>
          <div class="wojo checkbox radio fitted inline">
            <input name="type" type="radio" value="staff" id="staff" <?php Validator::getChecked($this->data->type, "staff"); ?>>
            <label for="staff"><?php echo Lang::$word->STAFF; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="type" type="radio" value="editor" id="editor" <?php Validator::getChecked($this->data->type, "editor"); ?>>
            <label for="editor"><?php echo Lang::$word->EDITOR; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="type" type="radio" value="member" id="member" <?php Validator::getChecked($this->data->type, "member"); ?>>
            <label for="member"><?php echo Lang::$word->MEMBER; ?></label>
          </div>
        </div>
        <div class="field" style="padding: 0px;">
          <label><?php echo Lang::$word->M_SUB10; ?></label>
          <div class="wojo checkbox radio fitted inline">
            <input name="newsletter" type="radio" value="1" id="newsletter_1" <?php Validator::getChecked($this->data->newsletter, 1); ?>>
            <label for="newsletter_1"><?php echo Lang::$word->YES; ?></label>
          </div>
          <div class="wojo checkbox radio fitted inline">
            <input name="newsletter" type="radio" value="0" id="newsletter_0" <?php Validator::getChecked($this->data->newsletter, 0); ?>>
            <label for="newsletter_0"><?php echo Lang::$word->NO; ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_FNAME; ?>
          <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->M_FNAME; ?>" value="<?php echo $this->data->fname; ?>"
          name="fname">
      </div>
      <div class="field five wide">
        <label><?php echo Lang::$word->M_LNAME; ?>
          <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->M_LNAME; ?>" value="<?php echo $this->data->lname; ?>"
          name="lname">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field five wide">
        <label><?php echo Lang::$word->M_EMAIL; ?>
          <i class="icon asterisk"></i></label>
        <input type="text" placeholder="<?php echo Lang::$word->M_EMAIL; ?>" value="<?php echo $this->data->email; ?>"
          name="email">
      </div>
      <div class="field">
        <label><?php echo Lang::$word->NEWPASS; ?></label>
        <div class="wojo input icon">
          <input type="text" name="password">
          <i class="lock icon"></i>
        </div>
      </div>
    </div>
    <!-- <div class="wojo simple segment">
      <h5><?php echo Lang::$word->CSF_TITLE; ?></h5>
      <?php echo $this->custom_fields; ?>
    </div> -->
    <div class="wojo fields">
      <div class="field three wide">
        <label><?php echo Lang::$word->M_ADDRESS; ?>
          <input type="text" placeholder="<?php echo Lang::$word->M_ADDRESS; ?>"
            value="<?php echo $this->data->address; ?>" name="address">
      </div>
      <div class="field three wide">
        <label><?php echo Lang::$word->M_CITY; ?>
          <input type="text" placeholder="<?php echo Lang::$word->M_CITY; ?>" value="<?php echo $this->data->city; ?>"
            name="city">
      </div>
      <div class="field four wide">
        <label><?php echo Lang::$word->M_STATE; ?>
          <input type="text" placeholder="<?php echo Lang::$word->M_STATE; ?>" value="<?php echo $this->data->state; ?>"
            name="state">
      </div>
    </div>
    <div class="wojo fields">
      <div class="field three wide">
        <label><?php echo Lang::$word->M_ZIP; ?>
          <input type="text" placeholder="<?php echo Lang::$word->M_ZIP; ?>" value="<?php echo $this->data->zip; ?>"
            name="zip">
      </div>
      <div class="field three wide">
        <label><?php echo Lang::$word->M_COUNTRY; ?>
          <select name="country">
            <?php echo Utility::loopOptions($this->clist, "abbr", "name", $this->data->country); ?>
          </select>
      </div>
    </div>
    <div class="wojo auto divider"></div>
    <div class="wojo fields">
      <div class="field">
        <textarea placeholder="<?php echo Lang::$word->M_SUB11; ?>"
          name="notes"><?php echo $this->data->notes; ?></textarea>
      </div>
    </div>
    <div class="center aligned">
      <a href="<?php echo Url::url("/admin/users"); ?>"
        class="wojo small simple button"><?php echo Lang::$word->CANCEL; ?></a>
      <button type="button" data-action="processUser" name="dosubmit"
        class="wojo primary button"><?php echo Lang::$word->M_UPDATE; ?></button>
    </div>
  </div>
  <input type="hidden" name="id" value="<?php echo $this->data->id; ?>">
</form>