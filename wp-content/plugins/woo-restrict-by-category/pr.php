<?php

//add_action( 'personal_options', 'show_restriction_tab' );
function show_restriction_tab( $user ) {
    $userId=$user->get('user_nicename');
    global $wpdb;
    $results= $wpdb->get_results($wpdb->prepare("SELECT privilege_slug FROM ".WC_RESTRICT_BY_CATEGORY_TABLE." WHERE (type='user' and target_slug =%s)",$userId),"ARRAY_A");
    $orderby = 'name';
    $order = 'asc';
    $hide_empty = false ;
    $cat_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
    );
    $product_categories = get_terms( 'product_cat', $cat_args );
    if(is_wp_error($product_categories))
        $product_categories=array();
    $category=array();
    foreach($product_categories as $product)
    {
        $checked=false;
        foreach($results as $result)
        {
            if($product->slug==$result['privilege_slug'])
            {
                $checked=true;
            }
        }
        $category[]=array('slug'=>$product->slug,
            'name'=>$product->name,
            'checked'=>$checked);
    }



    ?>

        <tr>
            <th colspan="2"><h3>WooCommerce Category Access</h3></th>
        </tr>
        <tr>
            <th colspan="">Show These Categories</th>
            <td>
                <div style="width:100%;max-height: 500px;overflow:auto;">
                    <table>
                        <?php foreach($category as $cat)
                        {?>
                            <tr>
                                <td style="padding:0">
                                    <input <?php if($cat['checked'])echo 'checked="checked"' ?> type="checkbox" id="<?php echo esc_html($cat['slug'])?>" name="wcrbc_privileges[]" value="<?php echo esc_html($cat['slug'])?>"/>
                                    <label for="<?php echo esc_html($cat['slug'])?>"><?php echo esc_html($cat['name']) ?></label>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </td>
        </tr>
    <?php
    /*
    $roles = implode(',', $roles);
    global $wpdb;




    global $restrict_categories_load;
    $rc_user_options=$restrict_categories_load->populate_user_opts();
    $userOptions=array();
    foreach ($rc_user_options as $option)
        if($option["id"]==$user->get('user_nicename').'_user_cats')
        {
            array_push($userOptions, $option);
        }

    $selectedOptions=get_option( 'RestrictCats_user_options' );
    $singleUserSelectedOptions=array();
    if(isset($selectedOptions[$user->get('user_nicename').'_user_cats']))
        $singleUserSelectedOptions[$user->get('user_nicename').'_user_cats']=$selectedOptions[$user->get('user_nicename').'_user_cats'];
    else
        $singleUserSelectedOptions=array();
    $boxes = new RestrictCats_User_Role_Boxes();
    echo("<h3>Categories</h3>");
    $boxes->start_box( $singleUserSelectedOptions, $userOptions, 'RestrictCats_user_options' );*/


}
//add_action( 'personal_options_update', 'profile_updated' );
//add_action( 'edit_user_profile_update', 'profile_updated' );
function profile_updated( $user_id ) {
    $user=get_user_by('id',$user_id);
    if($user==null)
        return;
    $privileges=array();
    if(isset($_POST["wcrbc_privileges"]))
        $privileges=$_POST["wcrbc_privileges"];
    global $wpdb;
    $wpdb->delete(WC_RESTRICT_BY_CATEGORY_TABLE, array('type' => 'user', 'target_slug' => $user->get('user_nicename')));
    $dataToInsert = array();
    foreach ($privileges as $privilege)
    {
        if(strlen($privilege)<=0){
            continue;
        }

        $dataToInsert = array('type' =>'user', 'target_slug' => $user->get('user_nicename'), 'privilege_slug' => sanitize_text_field($privilege));
        $wpdb->insert(WC_RESTRICT_BY_CATEGORY_TABLE, $dataToInsert);

    }



    $catOptions=$_POST["RestrictCats_user_options"];
    if(!isset($catOptions[strtolower($user->get('user_nicename')).'_user_cats']))
        return;

    $userCategories=$catOptions[strtolower($user->get('user_nicename')).'_user_cats'];

    $savedOptions=get_option( 'RestrictCats_user_options' );
    $savedOptions[$user->get('user_nicename').'_user_cats']=$userCategories;
    update_option('RestrictCats_user_options',$savedOptions);
}