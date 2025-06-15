<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * EST Img Tooltip Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class EST_Img_Tooltip_Widget extends \Elementor\Widget_Base {
	private $version = '1.0.4';
	/**
	 * Get widget name and version.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */

	public function get_name() {
		return 'esttooltip';
	}

	public function get_version() {
		return $this->version;
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */

	public function get_title() {
		return esc_html__( 'EST Image Tooltip', 'est-img-tooltip' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */

	public function get_icon() {
		return 'eicon-product-related';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */

	public function get_categories() {
		return [ 'woocommerce-elements' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */

	public function get_keywords() {
		return [ 'est', 'est-widget', 'tooltip' ];
	}

	public function get_style_depends() {
	   return [ 'est-style-handle' ];
	}

	public function get_script_depends() {
	   return [ 'est-script-handle' ];
	}

	public function get_product_by_title($product_title, $type = "product", $output = OBJECT) {
		global $wpdb;
		$product_title = endash_transform($product_title);
		$product = $wpdb->get_var ( $wpdb->prepare ( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='$type'", $product_title ) );
		return $product? get_post ( $product, $output ) : null;
	}

	/**
	 * Register widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/* Start Image Tooltip */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Image Link To Products', 'est-img-tooltip' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'est-img-tooltip' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],				
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

		/* Repeater */
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Product', 'est-img-tooltip' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Product Title', 'est-img-tooltip' ),
				'default' => esc_html__( 'Product Title', 'est-img-tooltip' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'sub_text',
			[
				'label' => esc_html__( 'Sub-text', 'est-img-tooltip' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Sub-text', 'est-img-tooltip' ),								
			]
		);

		/* End repeater */
		$this->add_control(
			'list_products',
			[
				'label' => esc_html__( 'Products', 'est-img-tooltip' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),           /* Use our repeater */
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		/* End Image Tooltip */
		/* Start Styling Tab */
		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__( 'Image', 'est-img-tooltip' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'elementor' ),
					'fill' => esc_html__( 'Fill', 'elementor' ),
					'cover' => esc_html__( 'Cover', 'elementor' ),
					'contain' => esc_html__( 'Contain', 'elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-position',
			[
				'label' => esc_html__( 'Object Position', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'center center' => esc_html__( 'Center Center', 'elementor' ),
					'center left' => esc_html__( 'Center Left', 'elementor' ),
					'center right' => esc_html__( 'Center Right', 'elementor' ),
					'top center' => esc_html__( 'Top Center', 'elementor' ),
					'top left' => esc_html__( 'Top Left', 'elementor' ),
					'top right' => esc_html__( 'Top Right', 'elementor' ),
					'bottom center' => esc_html__( 'Bottom Center', 'elementor' ),
					'bottom left' => esc_html__( 'Bottom Left', 'elementor' ),
					'bottom right' => esc_html__( 'Bottom Right', 'elementor' ),
				],
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'object-fit' => 'cover',
				],
			]
		);

		$this->end_controls_section();
		/* End Styling Tab */
	}

	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$img_tooltip_width = $settings["width"]["size"];
		$img_tooltip_height = $settings["height"]["size"];

		if( !empty($settings['list_products']) ):
			echo '<div class="wpb_single_image wpb_content_element vc_align_center link2products" style="width:'.$img_tooltip_width.'px;height:auto;">';
			echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
		  $product_html = '		  
		      <div class="est-btn-tooltip view-prod-list">
		        <button class="btn btn-primary btn-icon btn-icon-left small">
		          <span class="btn-tooltip-icon">
		            <svg xmlns="http://www.w3.org/2000/svg" class="icon-up" fill="#000000" width="22px" height="22px" viewBox="0 0 32 32">
		            	<path d="M26.531 20.469l-10.001-9.999c-0.136-0.136-0.323-0.22-0.53-0.22s-0.395 0.084-0.53 0.22l-10 9.999c-0.135 0.136-0.218 0.323-0.218 0.529 0 0.415 0.336 0.751 0.751 0.751 0.206 0 0.393-0.083 0.528-0.218l9.47-9.471 9.469 9.471c0.136 0.136 0.324 0.22 0.531 0.22 0.415 0 0.751-0.336 0.751-0.751 0-0.207-0.084-0.395-0.22-0.531v0z"></path>
		            </svg>
		            <svg xmlns="http://www.w3.org/2000/svg" class="icon-down" fill="#000000" width="22px" height="22px" viewBox="0 0 32 32">
		            	<path d="M26.531 10.47c-0.136-0.136-0.324-0.22-0.531-0.22s-0.395 0.084-0.531 0.22v0l-9.469 9.469-9.47-9.469c-0.135-0.131-0.319-0.212-0.523-0.212-0.414 0-0.75 0.336-0.75 0.75 0 0.203 0.081 0.388 0.213 0.523l10 10.001c0.136 0.135 0.323 0.219 0.53 0.219s0.394-0.084 0.53-0.219l10.001-10.001c0.135-0.136 0.218-0.323 0.218-0.53s-0.083-0.394-0.218-0.53l0 0z"></path>
		            </svg>
		          </span>
		          <span class="text-button">View products</span>
		        </button>
		      </div>
		      <div class="est-tooltip-content">
		        <!-- <span class="btn-close"></span> -->
		        <div class="wrap-container">
		          <div class="experience-block">';			
		?>
		<?php
			foreach ( $settings['list_products'] as $index => $item ) {

				$prod_title = $item['text'];
				$shc = $item['__dynamic__']['text'];
            $atts = est_shortcode_parse_atts($shc);
            preg_match_all('!\d+!', $atts["settings"], $matches);
            $prod_id = $matches[0][0];			
				$prod_link = esc_url( get_permalink($prod_id) );
				$prod_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $prod_id ), 'thumbnail' );
				$prod_subtext = $item['sub_text']; 
				ob_start(); ?>
       		<div class="experience-component">
       			<figure class="popover-content">
       			  <div class="product-block">
       			    <div class="product-img">
       			      <img src="<?php echo $prod_image_url[0]; ?>" alt="">
       			    </div>
       			    <div class="product-desc">
       			      <div class="product-title"><?php echo $prod_title; ?></div>
       			      <div class="product-subtext"><?php echo $prod_subtext; ?></div>
       			    </div>
       			    <a class="product-link" href="<?php echo $prod_link; ?>"></a>
       			  </div>
       			</figure>
       		</div> 					
				<?php
				$product_html .= ob_get_clean();
			}
			$product_html .= '</div></div></div>';

		endif;
		echo $product_html.'</div>';
	}
	
	/**
	 * Render list widget output for reporting.
	 *
	 * Written in PHP and used to generate the final results.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_img_tooltip_data() {
		$img_tooltip_data = array();
		$settings = $this->get_settings_for_display();
		$img_tooltip_data['image_url'] = $settings['image']['url'];
		if( !empty($settings['list_products']) ){
			foreach ( $settings['list_products'] as $index => $item ) {
				$img_tooltip_data['products'] = array();
				$title = $settings['list_products'][$index]['text'];
				$product = $this->get_product_by_title($title);
				$img_tooltip_data['products'][] = $product->ID;
			}
		}
		return $img_tooltip_data;
	}
}