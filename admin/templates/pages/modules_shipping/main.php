<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  $osC_DirectoryListing = new osC_DirectoryListing('includes/modules/shipping');
  $osC_DirectoryListing->setIncludeDirectories(false);
  $files = $osC_DirectoryListing->getFiles();
?>

<h1><?php echo osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule()), $osC_Template->getPageTitle()); ?></h1>

<?php
  if ( $osC_MessageStack->size($osC_Template->getModule()) > 0 ) {
    echo $osC_MessageStack->output($osC_Template->getModule());
  }
?>

<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable">
  <thead>
    <tr>
      <th><?php echo TABLE_HEADING_MODULES; ?></th>
      <th><?php echo TABLE_HEADING_SORT_ORDER; ?></th>
      <th width="150"><?php echo TABLE_HEADING_ACTION; ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th colspan="3">&nbsp;</th>
    </tr>
  </tfoot>
  <tbody>

<?php
  $installed_modules = array();

  foreach ( $files as $file ) {
    include('includes/modules/shipping/' . $file['name']);

    $class = substr($file['name'], 0, strrpos($file['name'], '.'));

    if ( class_exists('osC_Shipping_' . $class) ) {
      $osC_Language->injectDefinitions('modules/shipping/' . $class . '.xml');

      $module = 'osC_Shipping_' . $class;
      $module = new $module();
?>

    <tr onmouseover="rowOverEffect(this);" onmouseout="rowOutEffect(this);" <?php echo ( $module->isInstalled() && !$module->isEnabled() ? 'class="deactivatedRow"' : '') ?>>
      <td><?php echo $module->getTitle(); ?></td>
      <td><?php echo $module->getSortOrder(); ?></td>
      <td align="right">

<?php
    if ( $module->isInstalled() ) {
      echo osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&module=' . $module->getCode() . '&action=save'), osc_icon('configure.png', IMAGE_EDIT)) . '&nbsp;' .
           osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&module=' . $module->getCode() . '&action=uninstall'), osc_icon('stop.png', IMAGE_MODULE_REMOVE));
    } else {
      echo osc_image('images/pixel_trans.gif', '', '16', '16') . '&nbsp;' .
           osc_link_object(osc_href_link_admin(FILENAME_DEFAULT, $osC_Template->getModule() . '&module=' . $module->getCode() . '&action=install'), osc_icon('play.png', IMAGE_MODULE_INSTALL));
    }
?>

      </td>
    </tr>

<?php
    }
  }
?>

  </tbody>
</table>

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td style="opacity: 0.5; filter: alpha(opacity=50);"><?php echo '<b>' . TEXT_LEGEND . '</b> ' . osc_icon('configure.png', IMAGE_EDIT) . '&nbsp;' . IMAGE_EDIT . '&nbsp;&nbsp;' . osc_icon('play.png', IMAGE_MODULE_INSTALL) . '&nbsp;' . IMAGE_MODULE_INSTALL .  '&nbsp;&nbsp;' . osc_icon('stop.png', IMAGE_MODULE_REMOVE) . '&nbsp;' . IMAGE_MODULE_REMOVE; ?></td>
  </tr>
</table>