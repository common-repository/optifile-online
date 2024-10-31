<?php
/**
* @package OptifileOnline
* @version 1.0.8
*/
/*
Plugin Name: Optifile Online
Plugin URI: https://Optifile.net/
Description: Plugin used for Optifile Online
Version: 1.0.8
Author: Optifile Automatisering
Author URI: https://Optifile.net
License: GPLv2 or later
Text Domain: Optifile-Online
 */

/*  copyright 2019 Optifile Automatisering

  This program is free software; you can redistribute it and/or 
  modify it under the terms of the GNU General Public License
  as published by the Free Softwar Foundation; either version 2
  of the license, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die( 'Hey, you can\t access this file, you silly human' );

//global $OptifileOnline_options;
//$OptifileOnline_options = array (
	//'CustomerId' => '',
	//'Page_NewAppointment' => '',
	//'Page_Customer' => '',
	//'Page_CustomerAppointments' => '',
	//'Page_CustomerOrders' => '',
	//'Page_CustomerReOrderLens' => '',
	//'Page_CustomerSavings' => ''	
//);

class OptifileOnlinePlugin 
{
	public $plugin;
	
	function register() {
		add_action( 'wp_head', array($this,'add_link_in_head'));
		add_action( 'admin_menu', array($this, 'add_admin_pages' ));			
		add_filter( "plugin_action_links_$this->plugin", array($this, 'settings_link'));
		add_filter( 'wp_enqueue_scripts', array($this,'insert_jquery'),1);
		add_action( 'admin_init', array($this, 'register_settings' ));

		add_shortcode('OptifileOnline', array($this, 'InsertCode'));
	}

	function insert_jquery(){
		wp_enqueue_script('jquery', false, array(), false, false);
		}

	public function add_link_in_head()
	{
		
		$options = get_option( 'optifileSettings' );
		
		?>		        
			<script type="text/javascript" src="https://<?php echo $options['OptifileOnline_basic_CustomerId']; ?>.optifile.net/demo/Scripts/iframeResizer.min.js" ></script>
			<script type="text/javascript" src="https://<?php echo $options['OptifileOnline_basic_CustomerId']; ?>.optifile.net/demo/Scripts/_Safari_fix_Script.aspx" ></script>
		<?php
	}

	public function InsertCode($atts = array( 'page' => 'customer.aspx' ))
	{
		$content = "";
		$options = get_option( 'optifileSettings' );
		
		if ($atts['page'] == 'newappointment.aspx' && $_GET['action'] == ''){
			
			$content .= "<span id='optifilelogintext' style='visibility:hidden; display:none;'><a href=\"?action=newappointment\">" . $options['OptifileOnline_texts_NoCustomerAppointmentTip'] . "</a></span>" . "\r\n";		

			
		}
		else
		{			
			if ($_GET['action'] != '')
			{
				$atts['page'] = "signin.aspx";
			}
			$content .= "<span id='optifilelogintext' style='visibility:hidden; display:none;'>" . $options['OptifileOnline_texts_LoginTip'] . "</span>". "\r\n";
			
		}
		
		$content .= " <script type=\"text/javascript\"> ". "\r\n";
		$content .= "	function DisplayText() ". "\r\n";
		$content .= "	{ ". "\r\n";
		$content .= "		try { ". "\r\n";
		$content .= "			jQuery.ajax({ ". "\r\n";
		$content .= "				type: 'GET', ". "\r\n";
		$content .= "				url: 'https://" . $options['OptifileOnline_basic_CustomerId'] . ".optifile.net/SessionInfo.aspx?command=loginname', ". "\r\n";
		$content .= "				xhrFields: { ". "\r\n";
		$content .= "					withCredentials: true ". "\r\n";
		$content .= "				}, ". "\r\n";
		$content .= "			}).done(function (res) { ". "\r\n";
		$content .= " ". "\r\n";
		$content .= "				if (res == '')	". "\r\n";
		$content .= "				{ ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.visibility =''; ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.display =''; ". "\r\n";
		$content .= "				} ". "\r\n";
		$content .= "				else ". "\r\n";
		$content .= "				{ ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.visibility ='hidden'; ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.display ='none'; ". "\r\n";
		$content .= "				} ". "\r\n";
		$content .= "			}).fail(function (jqXHR, textStatus, errorThrown) { ". "\r\n";
		$content .= "			}); ". "\r\n";
		$content .= "		} ". "\r\n";
		$content .= "		catch(err) ". "\r\n";
		$content .= "		{ ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.visibility =''; ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').style.display =''; ". "\r\n";
		$content .= "					document.getElementById('optifilelogintext').innerHTML = err.message; ". "\r\n";
		$content .= "		} ". "\r\n";
		$content .= "	} ". "\r\n";
		$content .= " </script> ". "\r\n";
		$content .= "". "\r\n";
		$content .= " <iframe loading=\"eager\" style=\"width:1px; min-width:100%; min-height:400px;\" frameborder=\"0\" name=\"myIframe\" id=\"myIframe\" scrolling=\"no\" src=\"about:blank\"  ></iframe> ". "\r\n";
		$content .= " ". "\r\n";
		$content .= " <script type=\"text/javascript\"> ". "\r\n";		
		$content .= "     var localsession = window.localStorage.getItem('OptifileSessionId'); ". "\r\n";
		$content .= "     var sessionurl = \"\"; \r\n";
        $content .= "     if (localsession != null && localsession != '') { ". "\r\n";
        $content .= "       sessionurl = \"/\" + localsession; ". "\r\n";
        $content .= "     } ". "\r\n";
		$content .= "	querystring = \"?\" + window.location.search.substring(1); ";
		$content .= "	if (querystring != \"?\") { document.getElementById(\"myIframe\").src = \"https://" . $options['OptifileOnline_basic_CustomerId'] . ".optifile.net\" + sessionurl +  \"/" . $atts['page'] ."\" + querystring; ". " } \r\n";
		$content .= "	else { document.getElementById(\"myIframe\").src = \"https://" . $options['OptifileOnline_basic_CustomerId'] . ".optifile.net\" + sessionurl +  \"/" . $atts['page'] ."\"; "."  } \r\n";
		$content .= " document.getElementById(\"myIframe\").onload = function() { iFrameResize(); DisplayText();}  \r\n";
		$content .= " </script> ". "\r\n";			

		return $content;
	}

    public function register_settings(){
		register_setting( 'OptifileOnline_basic_group', 'optifileSettings');
		add_settings_section('OptifileOnline_basic_group_section', 'Algemeen', array( $this, 'GetOptifileOnlineBasicGroupSection'), 'OptifileOnline_basic_group');
		add_settings_field('OptifileOnline_basic_CustomerId','Klantnummer', array( $this, 'GetOptifileOnlineBasicGroupSection_CustomerId'),'OptifileOnline_basic_group','OptifileOnline_basic_group_section');

		add_settings_section('OptifileOnline_texts_group_section', 'Teksten', array( $this, 'GetOptifileOnlineTextsGroupSection'), 'OptifileOnline_basic_group');
		add_settings_field('OptifileOnline_texts_LoginTip','Login tip', array( $this, 'GetOptifileOnline_text'),'OptifileOnline_basic_group','OptifileOnline_texts_group_section',array('LoginTip'));
		add_settings_field('OptifileOnline_texts_NoCustomerAppointmentTip','Niet ingelogt nieuwe afspraak', array( $this, 'GetOptifileOnline_text'),'OptifileOnline_basic_group','OptifileOnline_texts_group_section',array('NoCustomerAppointmentTip'));

		add_settings_section('OptifileOnline_pages_group_section', 'Pagina\'s', array( $this, 'GetOptifileOnlinePagesGroupSection'), 'OptifileOnline_basic_group');
		add_settings_field('OptifileOnline_pages_newappointment','Nieuwe afspraak', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('newappointment'));
		
		add_settings_field('OptifileOnline_pages_customer','Mijn naw gegevens', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('customer'));
		add_settings_field('OptifileOnline_pages_customerappointment','Mijn afspraak', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('customerappointment'));
		//add_settings_field('OptifileOnline_pages_customerappointments','Mijn nieuwe afspraak', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('customerappointments'));
		add_settings_field('OptifileOnline_pages_customerorders','Mijn orders', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('customerorders'));
		add_settings_field('OptifileOnline_pages_customerreorderlens','Mijn lenzen herbestellen', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section',array('customerreorderlens'));
		add_settings_field('OptifileOnline_pages_customersavings','Mijn spaarplan', array( $this, 'GetOptifileOnline_page'),'OptifileOnline_basic_group','OptifileOnline_pages_group_section', array('customersavings'));
		
		
	}

	public function GetOptifileOnline_text($textId)
	{		
		$id = $textId[0];		
		$options = get_option('optifileSettings');
		$value = $options["OptifileOnline_texts_$id"];
		if ($value == null || value == '')
		{
			if ($id == "newappointment")
			{

			}
			if ($id == "LoginTip")
			{
				$value = "Standaard is uw gebruikersnaam uw klantnummer en uw wachtwoord uw geboortedatum als (dd-mm-yyyy)";
				
			}
			if ($id == "NoCustomerAppointmentTip")
			{
				$value = "Bent u al klant bij ons log dan eerst in.";
			}
		}
		?>	
		<input type='text' style='width:100%;' name='optifileSettings[<?php echo "OptifileOnline_texts_$id" ?>]' value='<?php echo $value; ?>'>
		<?php
	}

	public function GetOptifileOnline_page($page)
	{
		
		$currentpage = $page[0];
		$options = get_option('optifileSettings');	
		?>
		Id <input type='text' style='width:50px;' readonly name='optifileSettings[<?php echo "OptifileOnline_pages_$currentpage" ?>]' value='<?php echo $options["OptifileOnline_pages_$currentpage"]; ?>'>
		<?php		
		if ($options["OptifileOnline_pages_$currentpage"] == ''){							
			echo '<i>Geen pagina bekend</i>';
			echo '</td><td>';						
		}
		else {				
			$post= null;
			$post = get_post($options["OptifileOnline_pages_$currentpage"]);
			echo ($post->post_title);
			echo '</td><td>';
			edit_post_link( 'Bewerken', '', '',  $options["OptifileOnline_pages_$currentpage"], 'post-edit-link btn btn-default' ); 

		}	
	}
	

	public function GetOptifileOnlinePagesGroupSection()
	{
		echo __( 'Door deze plugin aangemaakte pagina\'s', 'wordpress');
	}
	public function GetOptifileOnlineBasicGroupSection()
	{
		echo __( 'Het is verplicht om uw klantnummer in te vullen voor een juiste werking van deze plugin.', 'wordpress' );
	}
	public function GetOptifileOnlineBasicGroupSection_CustomerId()
	{
		$options = get_option( 'optifileSettings' );
    ?>
    <input type='text' name='optifileSettings[OptifileOnline_basic_CustomerId]' value='<?php echo $options['OptifileOnline_basic_CustomerId']; ?>'>
    <?php		
	}

	public function settings_link( $links ){
		$settings_link = '<a href="admin.php?page=optifile_online_plugin">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}
	
	public function add_admin_pages() {
		add_menu_page( 'Optifile Online plugin', 'Optifile', 'manage_options', 'optifile_online_plugin', array( $this, 'admin_index'), 'dashicons-admin-tools', 110);
	}
	
	public function admin_index() {
		require_once plugin_dir_path(__FILE__ ). 'templates/admin.php';
	}
	
	function __construct() {
		$this->plugin = plugin_basename(__FILE__);				
	}
	function activate() {	
		global $OptifileOnline_options;
	
		// Create the required options...
		//foreach ($OptifileOnline_options as $name => $val) {
		//	add_option($name,$val);
		//}
		
	}
	
	function deactivate() {
		
	}
	
	function uninstall() {
	
	}
	
	
	
}

if (class_exists('OptifileOnlinePlugin')) {
	$optifileOnlinePlugin = new OptifileOnlinePlugin();
	$optifileOnlinePlugin->register();
}

// activation
register_activation_hook( __FILE__, array($optifileOnlinePlugin, 'activate') );

// deactivate
register_activation_hook( __FILE__, array($optifileOnlinePlugin, 'deactivate') );

// uninstall





