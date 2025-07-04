<?php
/**
 * User Manager
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: users.tpl.php, v1.00 2020-01-08 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
  die('Direct access to this location is not allowed.');

if (!Auth::hasPrivileges('manage_users')):
  print Message::msgError(Lang::$word->NOACCESS);
  return;
endif;
?>
<?php
$sgement_array = ['active', 'inactive'];

if (in_array($this->segments[2], $sgement_array)) {
  if (isset($this->segments[3])) {
    switch ($this->segments[3]):
      case "edit":
        include ("_users_edit.tpl.php");
        break;
    endswitch;
  } 
  else {
    include ("_users_list.tpl.php");
  }
} 
else {
  ?>
  <?php switch (Url::segment($this->segments)):
    case "edit": ?>
      <!-- Start edit -->
      <?php include ("_users_edit.tpl.php"); ?>
      <?php break; ?>
      <!-- Start new -->
    <?php case "new": ?>
      <?php include ("_users_new.tpl.php"); ?>
      <?php break; ?>
      <!-- Start history -->
    <?php case "history": ?>
      <?php include ("_users_history.tpl.php"); ?>
      <?php break; ?>
      <!-- Start grid -->
    <?php case "grid": ?>
      <?php include ("_users_grid.tpl.php"); ?>
      <?php break; ?>
      <!-- Start default -->
    <?php default: ?>
      <?php include ("_users_list.tpl.php"); ?>
      <?php break; ?>
  <?php endswitch; ?>
<?php
}
?>