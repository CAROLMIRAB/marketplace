<?php ob_start();

if (!defined('ABSPATH')) exit;


function marketplace_database_install()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'products_services';

    $sql = "CREATE TABLE '$table_name' (
  'id' int(11) NOT NULL,
  'title' varchar(100) NOT NULL,
  'description' text NOT NULL,
  'img' varchar(255) NOT NULL,
  'price_before' int(10) NOT NULL,
  'price_after' int(10) NOT NULL,
  'categories' text NOT NULL,
  'type' int(2) NOT NULL,
  'slug' varchar(255) NOT NULL,
  'current_publish' datetime NOT NULL,
  'current_review' datetime NOT NULL,
  'current_unpublish' datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE 'wp_products_services'
  ADD PRIMARY KEY ('id'),
  ADD UNIQUE KEY 'slug' ('slug'),
  ADD KEY 'type' ('type');


ALTER TABLE 'wp_products_services'
  MODIFY 'id' int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE 'wp_products_services'
  ADD CONSTRAINT 'wp_products_services_ibfk_1' FOREIGN KEY ('type') REFERENCES 'wp_types_ps' ('id');

	);";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    update_option("marketplace_db_version", MARKETPLACE_BBDD_VERSION);
}


function marketplace_insert($title, $description, $status, $price, $categories, $type, $slug, $img, $user, $tags)
{


    global $wpdb;
    $table_name = $wpdb->prefix . "products_services";
    $category = get_category_by_slug('marketplace');

// Create post object
    $my_post = array();
    $my_post['post_title'] = $title;
    $my_post['post_content'] = '';
    $my_post['post_status'] = 'publish';
    $my_post['post_type'] = 'marketplace';
    $my_post['post_parent'] = 3943;
    $my_post['post_author'] = 1;
    $my_post['post_name'] = $slug;
    $my_post['comment_status'] = 'open';
    $my_post_id = wp_insert_post($my_post);

    $data = array(
        'ID' => $my_post_id,
        'guid' => get_option('siteurl') . '/?p=' . $my_post_id,
    );

    wp_update_post($data);

    update_post_meta($my_post_id, '_wp_page_template', 'template-details.php');

    wp_set_post_tags($my_post_id, $tags, true);


    $inserted = $wpdb->insert(
        $table_name,
        array(
            'current_publish' => date("Y-m-d h:i:s", time()),
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'type' => $type,
            'img' => $img,
            'slug' => $slug,
            'categories' => $categories,
            'status' => $status,
            'id_user' => $user,
            'post_id' => $my_post_id
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d'
        )
    );


    if ($inserted) {
        return $wpdb->insert_id;
    } else {
        return false;
    }
}

function marketplace_register_insert($name, $lastname1, $lastname2, $rut, $mail, $username, $pass1, $pass2)
{

    global $wpdb;


    $random_pass = wp_generate_password(12, false);
    if ($pass1 == '') {
        $pass1 = $random_pass;
    }


    $userdata = array(
        'user_pass' => $pass1,
        'user_login' => $username,
        'user_url' => '',
        'user_email' => $mail,
        'user_nicename' => $username,
        'user_registered' => time(),
        'user_status' => 0,
        'user_url' => '',
        'user_activation_key' => '',
        'display_name' => $name . " " . $lastname1,
        'role' => 'subscriber'
    );


    // insertamos
    $user_id = wp_insert_user($userdata);


    $table_name = $wpdb->prefix . "adherent";
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'lastname' => $lastname1,
            'lastname2' => $lastname2,
            'rut' => $rut,
            'id_user' => $user_id

        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        )
    );


    $table_nameb = $wpdb->prefix . "business";
    $insertedb = $wpdb->insert(
        $table_nameb,
        array(
            'name' => '',
            'address' => '',
            'workers' => '',
            'rut' => $rut,
            'video' => '',
            'description' => '',
            'phone' => '',
            'image' => '',
            'id_user' => $user_id

        ),
        array(
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        )
    );

    if ($inserted) {
        return $wpdb->insert_id;
    } else {
        return false;
    }

}


function marketplace_insert_business($bname, $baddress, $bworkers, $brut, $bvideo, $bdescription, $bphone, $id_user, $img, $bphone2, $bweb, $bmail)
{

    global $wpdb;

    $table_name = $wpdb->prefix . "business";

    /*   $data = array();
       $datab = array();

       if ($baddress != '') {
           //$datab .= ' address = ' . $baddress . ', ';
           $data['address'] = $baddress;
           $datab[] = '%s';
       }

       if ($bname != '') {
           //$datab .= ' name = ' . $bname . ', ';
           $data['name'] = $bname;
           $data[] = '%s';

       }

       if ($bworkers != '') {
           //$datab .= ' workers = ' . $bworkers . ', ';
           $data['workers'] = $bworkers;
           $datab[] = '%d';
       }

       if ($brut != '') {
           //$datab .= ' rut = ' . $brut . ', ';
           $data['rut'] = $brut;
           $datab[] = '%s';
       }


       if ($bdescription != '') {
           //$datab .= ' description = ' . $bdescription . ' ';
           $data['description'] = $bdescription;
           $datab[] = '%s';

       }

       if ($bphone != '') {
           //$datab .= ' phone = ' . $bphone . ' ';
           $data['phone'] = $bphone;
           $datab[] = '%s';
       }

       if ($img != '') {
           // $datab .= ' image = ' . $img . ' ';
           $data['image'] = $img;
           $datab[] = '%s';
       }


       $wpdb->update(
           $table_name,
           $data,
           array('id_user' => $id_user),
           $datab,
           array('%d')
       );*/


    $query = $wpdb->query("UPDATE $table_name set name='$bname', address='$baddress', rut='$brut', workers = '$bworkers', video='$bvideo', description= '$bdescription', phone='$bphone', image='$img', phone2 = '$bphone2',  web ='$bweb', email ='$bmail'   where id_user = $id_user");


    return true;
    /* if ($updated) {
         return $wpdb->insert_id;
     } else {
         return false;
     }*/
}

function marketplace_rating_insert($id_adherent, $id_product, $rating)
{
    global $wpdb;

    $table_name = $wpdb->prefix . "rating";

    $queryb = "SELECT * FROM $table_name where id_adherent = $id_adherent and id_product= $id_product";
    $contentb = $wpdb->get_results($queryb);

    if (empty($contentb)) {

        $inserted = $wpdb->insert(
            $table_name,
            array(
                'id_adherent' => $id_adherent,
                'id_product' => $id_product,
                'rating' => $rating,
            ),
            array(
                '%d',
                '%d',
                '%d'
            )
        );

    } else {
        $wpdb->update(
            $table_name,
            array(
                'rating' => $rating,
            ),
            array('id_adherent' => $id_adherent, 'id_product' => $id_product),
            array(
                '%d',
            ),
            array('%d', '%d')
        );
    }

}


function marketplace_publish_insert($id)
{
    global $wpdb;

    $table_name2 = $wpdb->prefix . "products_services";

    $my_post = array(
        'ID' => $id,
        'post_status' => 'publish',
    );

// Update the post into the database
    wp_publish_post($id);


    $wpdb->update(
        $table_name2,
        array(
            'status' => 1,  // string
        ),
        array('post_id' => $id),
        array(
            '%d',   // value1
        ),
        array('%d')
    );


}


/**
 * Comprueba si ha cambiado la versión de la base de datos
 * y ejecuta la función encuesta_database_install en caso afirmativo
 */
function marketplace_update_db_check()
{
    $installed_ver = get_option("marketplace_db_version", '1.0');
    if ($installed_ver != MARKETPLACE_BBDD_VERSION) {
        marketplace_database_install();
    }
}

add_action('plugins_loaded', 'marketplace_update_db_check');

ob_end_flush();
