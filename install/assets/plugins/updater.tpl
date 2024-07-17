//<?php
/**
 * Updater
 *
 * show message about outdated CMS version
 *
 * @category    plugin
 * @version     0.9.1
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @package     evo
 * @author      Dmi3yy (dmi3yy.com)
 * @internal    @events OnManagerWelcomeHome,OnPageNotFound,OnSiteRefresh
 * @internal    @modx_category Manager and Admin
 * @internal    @properties &wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Show only to this role id:;string;;;enter the role id &ThisUser=Show only to this username:;string;;;enter the username &showButton=Show Update Button:;menu;show,hide,AdminOnly;AdminOnly
 * @internal    @legacy_names MODX.Evolution.updateNotify
 * @internal    @installset base
 * @internal    @disabled 0
 */


require MODX_BASE_PATH.'assets/plugins/updater/plugin.updater.php';
