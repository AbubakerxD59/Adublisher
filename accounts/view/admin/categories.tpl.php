<?php
/**
 * Categories
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: categories.tpl.php, v1.00 2020-05-05 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');

if (!Auth::checkAcl("owner")):
    print Message::msgError(Lang::$word->NOACCESS);
    return;
endif;
?>
<div class="row gutters align middle">
    <div class="columns auto mobile-100 mobile-order-1">
        <h2>Category Management</h2>
    </div>
    <div class="columns right aligned mobile-50 phone-100 mobile-order-2">
        <a href="<?php echo Url::url(Router::$path, "new/"); ?>" class="wojo small primary stacked button"><i
                class="icon plus alt"></i>New Category</a>
    </div>

</div>
<?php if (!$this->data): ?>
    <div class="content-center"><img src="<?php echo ADMINVIEW; ?>/images/notfound.png" alt="">
    </div>
<?php else: ?>
    <div class="wojo segment">
        <table class="wojo basic responsive table" id="editable">
            <thead>
                <tr>
                    <th>TITLE</th>
                    <th>SLUG</th>
                    <th>STATUS</th>
                    <th class="disabled center aligned"><?php echo Lang::$word->ACTIONS; ?></th>
                </tr>
            </thead>
            <?php foreach ($this->data as $row): ?>
                <tr id="item_<?php echo $row->id; ?>">
                    <td>
                        <a href="<?php echo Url::url(Router::$path, "edit/" . $row->id); ?>"><?php echo $row->title; ?></a>
                    </td>
                    <td>
                        <?php echo $row->slug; ?>
                    </td>
                    <td>
                        <span class="wojo small label">
                            <?php echo $row->status ? "Active" : "Inactive"; ?>
                        </span>
                    </td>
                    <td class="auto">
                        <a href="<?php echo Url::url(Router::$path, "edit/" . $row->id); ?>"
                            class="wojo icon circular inverted positive button">
                            <i class="icon note"></i>
                        </a>
                        <a data-set='{"option":[{"delete":"deleteCategory","title": "<?php echo Validator::sanitize($row->title, "chars"); ?>","id": "<?php echo $row->id; ?>"}],"action":"delete","subtext":"<?php echo Lang::$word->DELCONFIRM3; ?>","parent":"#item_<?php echo $row->id; ?>"}'
                            class="item wojo data icon circular inverted negative button">
                            <i class="icon trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>