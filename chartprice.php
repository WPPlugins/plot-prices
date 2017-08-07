<?php 
/**
* Plugin Name:Plot prices 
* Plugin URI:http://cristaly.ir/
* Description: Chart plugin to view price changes of woocommerce product
* Version: 1.1.0
* Author: behzad rohizadeh
* Author URI: http://cristaly.ir/
*
 * @package plot
 * @category WooCommerce
 * @author behzad rohizadeh
*
*/
add_action('init','Behzad_localization_init');
add_action( 'save_post', 'Behzad_wp_wooc_789' );
add_action( 'post_updated', 'Behzad_wp_wooc_987'); 
add_action('wp_enqueue_scripts','Behzad_wp_wooc_968_css_and_js');
add_shortcode('chartprice', 'Behzad_wp_wooc_968_chartprice');

function Behzad_localization_init()
{
	 $path = dirname(plugin_basename( __FILE__ )) . '/language/';
	$loaded = load_plugin_textdomain( 'chartprice', false, $path);

}
	function Behzad_wp_wooc_789()
	{
	$post_id=( isset( $_POST['ID'] ) ) ? intval($_POST['ID']) : 0; 
	 $saleprice=get_post_meta($post_id, '_chart_sale_price'); 	
	 if (isset($_POST['post_type']) && $_POST['post_type']=='product' && empty($saleprice)) {
	 	 $date='';
		 if (function_exists('jdate')) {
		 	$date=jdate('Y-m-d'); 
		 	}
		 	if (function_exists('parsidate')) {
		 			 $date=parsidate('Y-m-d');
		 	}
		 	if (empty($date)) {
		 	         $date=date('Y-m-d'); 
		 		}	
		 $sale_price=( isset( $_POST['_sale_price'] ) ) ? intval($_POST['_sale_price']) : 0;
	     $regular_price=( isset( $_POST['_regular_price'] ) ) ? intval($_POST['_regular_price']) : 0; 
		 add_post_meta($post_id, '_chart_sale_price', $sale_price); 
		 add_post_meta($post_id, '_chart_regular_price', $regular_price);
		 add_post_meta($post_id, '_chart_date',$date); 
		}

}
function Behzad_wp_wooc_987()
{
	 if (isset($_POST['post_type']) && $_POST['post_type']=='product') {
	 	$date='';
		 if (function_exists('jdate')) {
		 	$date=jdate('Y-m-d'); 
		 	}
		 	if (function_exists('parsidate')) {
		 			 $date=parsidate('Y-m-d');
		 	}
		 	if (empty($date)) {
		 	         $date=date('Y-m-d'); 
		 		}
		  $sale_price=( isset( $_POST['_sale_price'] ) ) ? intval($_POST['_sale_price']) : 0;
	      $regular_price=( isset( $_POST['_regular_price'] ) ) ? intval($_POST['_regular_price']) : 0; 
	      $post_id=( isset( $_POST['ID'] ) ) ? intval($_POST['ID']) : 0; 		
		  $saleprice=get_post_meta($post_id, '_sale_price'); 
		  $regularprice=get_post_meta($post_id,'_regular_price');	
			if (!empty($saleprice) && !empty($regularprice)) {
				$saleprice=intval($saleprice[0]);
				$regularprice=intval($regularprice[0]);
				if ($saleprice!=$sale_price || $regularprice!=$regular_price) {
				 add_post_meta( $post_id, '_chart_sale_price', $sale_price); 
			     add_post_meta( $post_id, '_chart_regular_price',$regular_price);
			     add_post_meta( $post_id, '_chart_date',$date);
				}
				
			}
	   }
}
function Behzad_wp_wooc_968_css_and_js()
{
	wp_register_style('behzad-css-style', plugins_url('css/chart.css', __FILE__) );
	wp_enqueue_style( 'behzad-css-style' );
    wp_enqueue_script( "behzad1-js", plugin_dir_url( __FILE__ ) . 'js/Chart.bundle.js', array( 'jquery' ) );
    wp_enqueue_script( "behzad3-js", plugin_dir_url( __FILE__ ) . 'js/uutils.js', array( 'behzad1-js' ) );
    wp_enqueue_script( "behzad-js", plugin_dir_url( __FILE__ ) . 'js/remodal.js', array( 'behzad3-js' ) );


}
function Behzad_wp_wooc_968_chartprice()
{
    //echo get_the_ID().'-'.the_title();
	$saleprice=get_post_meta(get_the_ID(), '_chart_sale_price'); 
	$regularprice=get_post_meta(get_the_ID(), '_chart_regular_price');
	$dates=get_post_meta(get_the_ID(), '_chart_date');
	$rprice=( !empty( $regularprice ) ) ? implode(',',$regularprice) : '';
	$sprice=( !empty( $saleprice ) ) ? implode(',',$saleprice) : ''; 
	$dates=( !empty( $regularprice ) ) ? implode(',',$dates) : '';
	?>
	    <input type="hidden" value="<?php echo esc_attr(the_title()); ?>" id="title-pro">
	    <input type="hidden" value="<?php echo esc_attr($rprice); ?>" id="regular-price">
	    <input type="hidden" value="<?php echo esc_attr($sprice); ?>" id="sale-price">
	    <input type="hidden" value="<?php echo esc_attr($dates); ?>" id="dates-product">
        <input type="hidden" value="<?php _e('Regular price','chartprice'); ?>" id="reg">
	    <input type="hidden" value="<?php _e('Sale price','chartprice'); ?>" id="sale">
	    <input type="hidden" value="<?php _e('Price (per unit)','chartprice'); ?>" id="pole">
	    <input type="hidden" value="<?php _e('Product price change charts','chartprice'); ?>" id="title-chart">
	    <div class="remodal-bg">
	           <a href="javascript:;" title="<?php _e('Product price change charts','chartprice'); ?>">
	              <img id="showchart" width="60px"  src="<?php echo plugins_url('img/images.png', __FILE__); ?>">
	           </a>
	    </div>
        <div class="remodal"  role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
             <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
            
                <canvas id="canvas"></canvas>
    </div>

       
<?php }
