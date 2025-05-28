<?php
/**
 * BLogs
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: blogs.tpl.php, v1.00 2020-05-05 10:12:05 gewa Exp $
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
        <h2>Blog Management</h2>
    </div>
    <div class="columns right aligned mobile-50 phone-100 mobile-order-2">
        <a href="<?php echo Url::url(Router::$path, "new/"); ?>" class="wojo small primary stacked button"><i
                class="icon plus alt"></i>New Blog</a>
    </div>

</div>
<?php if (!$this->data): ?>
    <div class="content-center"><img src="<?php echo ADMINVIEW; ?>/images/notfound.png" alt="">
        <!-- <p class="wojo small thick caps text">No Blog available!</p> -->
    </div>
<?php else: ?>
    <div class="wojo segment">
        <table class="wojo basic responsive table" id="editable">
            <thead>
                <tr>
                    <th>TITLE</th>
                    <th>STATUS</th>
                    <th>PUBLISHED</th>
                    <th class="disabled center aligned"><?php echo Lang::$word->ACTIONS; ?></th>
                </tr>
            </thead>
            <?php foreach ($this->data as $row): ?>
                <tr id="item_<?php echo $row->id; ?>">
                    <td>
                        <a href="<?php echo Url::url(Router::$path, "edit/" . $row->id); ?>"><?php echo $row->title; ?></a>
                    </td>
                    <td>
                        <span class="wojo small label">
                            <?php echo $row->status ? "Published" : "Draft"; ?>
                        </span>
                    </td>
                    <td>
                        <?php echo !empty($row->published_at) ? date('Y/m/d', strtotime($row->published_at)) . ' at ' . date('H:i A', strtotime($row->published_at)) : '-'; ?>
                    </td>
                    <td class="auto">
                        <a href="<?php echo Url::url(Router::$path, "edit/" . $row->id); ?>"
                            class="wojo icon circular inverted positive button">
                            <i class="icon note"></i>
                        </a>
                        <a data-set='{"option":[{"delete":"deleteBlog","title": "<?php echo Validator::sanitize($row->title, "chars"); ?>","id": "<?php echo $row->id; ?>"}],"action":"delete","subtext":"<?php echo Lang::$word->DELCONFIRM3; ?>","parent":"#item_<?php echo $row->id; ?>"}'
                            class="item wojo data icon circular inverted negative button">
                            <i class="icon trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>