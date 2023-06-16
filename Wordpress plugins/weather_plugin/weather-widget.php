<?php
/*
* creating widget 'Weather'
*/
class WeatherWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'weather_widget',
			__( 'Weather', 'ww' ), // widget name
			array( 'description' => __( 'Allows display weather in Kharkov', 'ww' ) )
		);
	}

	// frontend of widget (in sidebar)
	public function widget( $args, $instance ) {
        $city = $instance['city'];
        $url = 'https://api.openweathermap.org/data/2.5/weather';
        $appid = '742d646860766409234d8ff5e42c9f7c';
        $units = 'metric';
        $url .= '?q=' . $city . '&appid=' . $appid . '&units=' . $units;
        $js_str = file_get_contents($url);
        if (!empty($js_str)) {
           $arr = json_decode($js_str, true)['main'];
           ?>
           <div class="info_weather">
             <h3><?php _e('Weather info', 'ww'); ?></h3>
             <p><b><?php _e('City: ', 'ww'); ?></b><?php echo $city; ?></p>
             <p><b><?php _e('Temperature: ', 'ww'); ?></b><?php echo $arr['temp']; ?></p>
             <p><b><?php _e('Humidity: ', 'ww'); ?></b><?php echo $arr['humidity']; ?></p>
           </div>
           <?php
        } else {
           die("Error!");
        }

}

// backend of widget (visible in appearance->widgets)
	public function form( $instance ) {
		$city = $instance['city'] ?? 'Kharkov';

		?>
            <label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e("Choose city:", "ww"); ?></label>
            <input id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>" />
		<?php
	}

	// to save widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['city'] = (!empty($new_instance['city'])) ? strip_tags($new_instance['city']) : '';
		return $instance;
	}
}

// registration of widget
add_action( 'widgets_init', 'weather_widget_load' );
function weather_widget_load() {
	register_widget( 'WeatherWidget' );
}

