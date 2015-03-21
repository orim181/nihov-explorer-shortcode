<?php
defined( 'ABSPATH' ) or die( 'No access' );

/*
 * Plugin Name: Nihov Shortcode
 * Plugin URI: https://github.com/orim181/nihov-explorer-shortcode
 * Description: Easily call the Nihov API
 * Author: Miro Samawil
 * Version: 1.0.0
 * Author URI: https://github.com/orim181
 * License: GPL2
 */

class Nihov {
    protected $apiUrl = 'http://directory.nihov.org/api/v1/';
    
    public function __construct() {
        add_shortcode('nihov', array($this, 'shortcode'));
    }
     
    // This function executes when the blogger
    // uses the shortcode [nihov type="clergy" id="123" detail="name"]
    public function shortcode($attributes, $content = null) {
        $a = shortcode_atts(array(
                'type' => 'clergy',
                'id' => '1',
                'detail' => 'name',
            ), $attributes);
        $response = wp_remote_get($this->apiUrl . "{$a['type']}.json/{$a['id']}");
	$entity = json_decode($response['body'],true);
        if(!isset($entity[$a['detail']])) {return '';}
        //output handler
	switch ($a['detail']){
            case 'profile_photo': echo "<img src='".$entity[$a['detail']]."'>"; break;
            default: echo $entity[$a['detail']];
	}
    }
    
}

$nihov = new Nihov();
