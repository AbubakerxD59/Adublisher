<?php
  /**
   * System
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: system.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
	  
  if (!Auth::checkAcl("owner")) : print Message::msgError(Lang::$word->NOACCESS); return; endif;
?>
<h2><?php echo Lang::$word->SYS_TITLE;?></h2>
<p class="wojo small text"><?php echo str_replace("[VER]", $this->core->wojov, Lang::$word->SYS_INFO);?></p>
<div class="wojo tabs">
  <ul class="nav">
    <li class="active"><a data-tab="cms"><i class="icon wojologo alt"></i>
      <?php echo Lang::$word->SYS_CMS_INF;?></a>
    </li>
    <li><a data-tab="php"><i class="icon code"></i>
      <?php echo Lang::$word->SYS_PHP_INF;?></a>
    </li>
    <li><a data-tab="server"><i class="icon desktop"></i>
      <?php echo Lang::$word->SYS_SER_INF;?></a>
    </li>
    <li><a data-tab="dbtables" class="last"><i class="icon data"></i>
      <?php echo Lang::$word->SYS_DBTABLE_INF;?></a>
    </li>
  </ul>
  <div class="wojo segment tab">
    <div data-tab="cms" class="item">
      <table class="wojo two basic column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->SYS_CMS_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->SYS_CMS_VER;?>:</td>
            <td>v<?php echo $this->core->wojov;?>
              <span id="version">
              </span></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_ROOT_URL;?>:</td>
            <td><?php echo SITEURLMM;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_ROOT_PATH;?>:</td>
            <td><?php echo BASEPATHMM;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_UPL_URL;?>:</td>
            <td><?php echo UPLOADURL;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_UPL_PATH;?>:</td>
            <td><?php echo UPLOADS;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_ADMVIEW;?>:</td>
            <td><?php echo ADMINBASE;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_DEF_LANG;?>:</td>
            <td><?php echo strtoupper($this->core->lang);?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div data-tab="php" class="item">
      <table class="wojo two basic column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->SYS_PHP_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->SYS_PHP_VER;?>:</td>
            <td><?php echo phpversion();?></td>
          </tr>
          <tr>
            <?php $gdinfo = gd_info();?>
            <td><?php echo Lang::$word->SYS_GD_VER;?>:</td>
            <td><?php echo $gdinfo['GD Version'];?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_MQR;?>:</td>
            <td><?php echo (ini_get('magic_quotes_gpc')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_LOG_ERR;?>:</td>
            <td><?php echo (ini_get('log_errors')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_MEM_LIM;?>:</td>
            <td><?php echo ini_get('memory_limit');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_RG;?>:</td>
            <td><?php echo (ini_get('register_globals')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_SM;?>:</td>
            <td><?php echo (ini_get('safe_mode')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td>Mb String:</td>
            <td><?php echo (extension_loaded('mbstring')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td>Intl:</td>
            <td><?php echo (extension_loaded('intl')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td>cURL:</td>
            <td><?php echo (extension_loaded('curl')) ? Lang::$word->ON : Lang::$word->OFF;?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_UMF;?>:</td>
            <td><?php echo ini_get('upload_max_filesize'); ?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_PMF;?>:</td>
            <td><?php echo ini_get('post_max_size');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_SSP;?>:</td>
            <td><?php echo ini_get('session.save_path');?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div data-tab="server" class="item">
      <table class="wojo two basic column table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Lang::$word->SYS_SER_INF;?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo Lang::$word->SYS_SER_OS;?>:</td>
            <td><?php echo php_uname('s')." (".php_uname('r').")";?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_SER_API;?>:</td>
            <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_SER_DB;?>:</td>
            <td><?php echo Db::run()->getAttribute(PDO::ATTR_CLIENT_VERSION);?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_DBV;?>:</td>
            <td><?php echo Db::run()->getAttribute(PDO::ATTR_SERVER_VERSION);?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_MEMALO;?>:</td>
            <td><?php echo ini_get('memory_limit');?></td>
          </tr>
          <tr>
            <td><?php echo Lang::$word->SYS_STS;?>:</td>
            <td><?php echo File::getSize(disk_free_space("."));?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div data-tab="dbtables" class="item">
      <?php print dbTools::optimizeDb();?>
    </div>
  </div>
</div>