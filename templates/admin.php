<div class="wrap">
<h1>Optifile Online Plugin</h1>
<form method="post" action="options.php" >

<?php 
if (isset($_POST['test_button']) && check_admin_referer('addpage_button_clicked')) {
    // the button has been pressed AND we've passed the security check    
   $page = $_POST['test_button'];
   $post_details = null;
    if ($page == 'customer'){
        $post_details = array(
            'post_title'    => 'Mijn gegevens',
            'post_content'  => '[OptifileOnline page="customer.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
    if ($page == 'customerappointments'){
        $post_details = array(
            'post_title'    => 'Mijn afspraken',
            'post_content'  => '[OptifileOnline page="customerappointments.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
    if ($page == 'customerorders'){
        $post_details = array(
            'post_title'    => 'Mijn bestellingen',
            'post_content'  => '[OptifileOnline page="customerorders.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }

    if ($page == 'customersavings'){
        $post_details = array(
            'post_title'    => 'Mijn spaarplan',
            'post_content'  => '[OptifileOnline page="customersavings.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
    if ($page == 'customerreorderlens'){
        $post_details = array(
            'post_title'    => 'Mijn lenzen herbestellen',
            'post_content'  => '[OptifileOnline page="customerreorderlens.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
    if ($page == 'newappointment'){
        $post_details = array(
            'post_title'    => 'Afspraak maken',
            'post_content'  => '[OptifileOnline page="newappointment.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
	if ($page == 'Afmelden'){
        $post_details = array(
            'post_title'    => 'Afmelden',
            'post_content'  => '[OptifileOnline page="signout.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }
   
	
	
	
		
    
    if (post_details!= null)
    {
        $id = wp_insert_post( $post_details );

        $options = get_option('optifileSettings');
        $options["OptifileOnline_pages_$page"] = $id;

        update_option('optifileSettings', $options);
    }
  }
  else
  {
      
  }


?>


<?php settings_fields('OptifileOnline_basic_group'); ?>
<?php do_settings_sections('OptifileOnline_basic_group'); ?>
<?php submit_button(); ?>
</form>

<form method="post" >
<?php wp_nonce_field('addpage_button_clicked');		?>
Nieuwe pagina aanmaken: 
<select name="test_button">
  <option value="newappointment">Nieuwe afspraak</option>
  <option value="customer">Mijn naw gegevens</option>
  <option value="customerappointments">Mijn afspraken</option>
  <option value="customerorders">Mijn orders</option>
  <option value="customerreorderlens">Mijn lenzen herbestellen</option>
  <option value="customersavings">Mijn spaarplan</option>      
  <option value="signout">afmelden</option>      
</select>
<input type="submit" name="submit" id="submit" class="button button-primary" value="Toevoegen" >
</form>


</div>

