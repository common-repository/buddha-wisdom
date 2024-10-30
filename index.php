<?php 
/*
Plugin Name: Buddha Wisdom Plugin
Description: Show Daily Buddha Quotes
Version: 1.1
Author: rigmorhansson
Author URI: http://buddhawisdom.se
License: GPLv2
*/



class buddhaWisdom extends WP_Widget {
     
    function __construct() {
    	parent::__construct(
         
	        // base ID of the widget
	        'buddhaWisdom',
	         
	        // name of the widget
	        __('Buddha Wisdom Widget', 'buddhaWisdomPlugin' ),
	         
	        // widget options
	        array (
	            'description' => __( 'Widget to display Daily Quotes.', 'buddhaWisdomPlugin' )
	        )
	         
	    );
    }
     
    function form( $instance ) {
    }
     
    function update( $new_instance, $old_instance ) {       
    }
     
    function widget( $args, $instance ) {

    	$content = array();

        $file = plugin_dir_path(__FILE__) . 'dailyquotes.txt';
		
		$date = Date('d-m-Y');

		$cont = explode("\n", file_get_contents($file));

		$content = str_replace(".", "", $cont);

		$res = json_decode(get_option('row_name'),true);

		if(isset($res["date"]) && Date('d-m-Y') == $res["date"]){
			
			$imgpath = plugin_dir_path(__FILE__) . 'buddha.png';

			echo "<div class='Buddha Wisdom Widget'>";

			echo "<img style='display: block;margin: auto;' src='".plugins_url('buddha.png',__FILE__)."' alt='Buddha' align='middle'>";
			
			echo "<blockquote>".$res['content']."</blockquote>";
            
            echo '<a href="http://buddhawisdom.se">Buddha Wisdom</a>';

			echo "</div>";

		}else{
			$rand_keys = array_rand($content);

			$newoption = sanitize_text_field($content[$rand_keys]);

			$data["date"] =  Date('d-m-Y');
			$data["content"] = $newoption;

			update_option( 'row_name', json_encode($data));

			echo "<div class='Buddha Wisdom Widget'>";

			echo "<img style='display: block;margin: auto;' src='".plugins_url('buddha.png',__FILE__)."' alt='Buddha' align='middle'>";
			
			echo "<p>".$newoption."</p>";
            
			echo "</div>";
		}

    }
     
}

function daily_buddha_widget() {
 
    register_widget( 'buddhaWisdom' );
 
}

add_action( 'widgets_init', 'daily_buddha_widget' );




?>