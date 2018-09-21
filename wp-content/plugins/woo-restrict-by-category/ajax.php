<?php
add_action( 'wp_ajax_rednao_wcrbc_search_roles', 'rednao_wcrbc_search_roles' );
function rednao_wcrbc_search_roles(){
    $searchTerm='';
    if(isset($_POST['searchTerm']))
    {
        $searchTerm=sanitize_text_field(stripslashes($_POST['searchTerm']));
    }
    global $wp_roles;
    $all_roles = $wp_roles->roles;
    foreach($all_roles as $key=>$role)
    {
        if(trim($searchTerm)!=''&&strpos(strtolower($role['name']),strtolower($searchTerm))===false)
            continue;
        $roles[]=array(
            'slug'=>$key,
            'type'=>'role',
            'name'=>$role['name'],
            'currentPrivileges'=>array()
        );
    }

    $roles[]=array('slug'=>'WCRC_guest','type'=>'none','name'=>'*Guest User','currentPrivileges'=>array());

    global $wpdb;
    $results=$wpdb->get_results("select distinct target_slug,privilege_slug from ".WC_RESTRICT_BY_CATEGORY_TABLE." where type='role' or type='none'",'ARRAY_A');
    foreach($roles as &$role)
    {
        foreach($results as $result)
        {
            if($role['type']=='none'&&$results['type']=='none')
                array_push($role['currentPrivileges'],$result['privilege_slug']);
            else
            if($role['slug']==$result['target_slug'])
                array_push($role['currentPrivileges'],$result['privilege_slug']);
        }
    }
    echo json_encode($roles);
    die();
}




add_action( 'wp_ajax_rednao_wcrbc_search_user', 'rednao_wcrbc_search_user' );
function rednao_wcrbc_search_user(){
    $searchTerm='';
    if(isset($_POST['searchTerm']))
    {
        $searchTerm=sanitize_text_field(stripslashes($_POST['searchTerm']));
    }

    $users = get_users( array(
        "number"=>50,
        "search"=>'*'.$searchTerm.'*'
    ));

    $usersToReturn=array();
    $usersToReturn[]=array('slug'=>'WCRC_guest','type'=>'none','name'=>'*Guest User','currentPrivileges'=>array());
    foreach($users as $user)
    {
        $usersToReturn[]=array(
            'slug'=>$user->get('user_nicename'),
            'type'=>'user',
            'name'=>$user->get('display_name'),
            'currentPrivileges'=>array()
        );
    }

    global $wpdb;
    $results=$wpdb->get_results("select distinct target_slug,privilege_slug,type from ".WC_RESTRICT_BY_CATEGORY_TABLE." where type='user' or type='none'",'ARRAY_A');
    foreach($usersToReturn as &$user)
    {
        foreach($results as $result)
        {
            if($user['type']=='none'&&$result['type']=='none')
            {
                array_push($user['currentPrivileges'], $result['privilege_slug']);
            }
            else
                if($user['slug']==$result['target_slug'])
                    array_push($user['currentPrivileges'],$result['privilege_slug']);
        }
    }
    echo json_encode($usersToReturn);

    /*global $wp_roles;

    $roles[]=array('slug'=>'WCRC_guest','type'=>'none','name'=>'*Guest User','currentPrivileges'=>array());

    */
    die();
}



add_action( 'wp_ajax_rednao_wcrbc_save_roles', 'rednao_wcrbc_save_roles' );
function rednao_wcrbc_save_roles(){
    if(!isset($_POST['data'])||!isset($_POST['type']))
    {
        die();
    }

    $type=sanitize_text_field(stripslashes($_POST['type']));
    $dataToSave=json_decode(stripslashes($_POST['data']),true);
    if($dataToSave==false)
        die();

    global $wpdb;
    foreach ($dataToSave as $data)
    {
        if (($data['type'] !== 'role' && $data['type'] !== 'user' && $data['type'] !== 'none') || strlen($data['slug']) <= 0)
        {
            continue;
        }
        $wpdb->delete(WC_RESTRICT_BY_CATEGORY_TABLE, array('type' => sanitize_text_field($data['type']), 'target_slug' => sanitize_text_field($data['slug'])));
        $dataToInsert = array();
        foreach ($data['currentPrivileges'] as $privilege)
        {
            if(strlen($privilege)<=0){
                continue;
            }

            $dataToInsert = array('type' => sanitize_text_field($data['type']), 'target_slug' => sanitize_text_field($data['slug']), 'privilege_slug' => sanitize_text_field($privilege));
            $wpdb->insert(WC_RESTRICT_BY_CATEGORY_TABLE, $dataToInsert);

        }

    }

    echo json_encode(array('success'=>true));
    die();
}


