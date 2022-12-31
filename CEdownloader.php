<?php
 

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile, //Plugin id
	'CE Plugin Downloader', 	//Plugin name
	'1.0', 		//Plugin version
	'Multicolor',  //Plugin author
	'', //author website
	'This plugin is to download plugins that supports php8.x', //Plugin description
	'plugins', //page type - on which admin tab to display
	'downloader'  //main function (administration)
);

 
# add a link in the admin tab 'theme'
add_action('plugins-sidebar','createSideMenu',array($thisfile,'CE Downloader'));

 

function downloader() {
include(GSPLUGINPATH.'CEdownloader/downloader.php'); 
};
?>
