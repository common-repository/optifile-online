<?php

$page = $_GET['page'];

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
            'post_title'    => 'Mijn afspraken',
            'post_content'  => '[OptifileOnline page="customerorders.aspx"]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'page'
            );
    }

    if ($page == 'customersavings'){
        $post_details = array(
            'post_title'    => 'Mijn spaarplan',
            'post_content'  => '[OptifileOnline page="customerorders.aspx"]',
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