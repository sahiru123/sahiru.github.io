<?php
/**
 * Seva Lite Customizer Typography Control
 *
 * @package Seva_Lite
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Seva_Lite_Typography_Control' ) ) {
    
    class Seva_Lite_Typography_Control extends WP_Customize_Control {
    
    	public $tooltip = '';
    	public $js_vars = array();
    	public $output = array();
    	public $option_type = 'theme_mod';
    	public $type = 'seva-lite-typography';
    
    	/**
    	 * Refresh the parameters passed to the JavaScript via JSON.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function to_json() {
    		parent::to_json();
    
    		if ( isset( $this->default ) ) {
    			$this->json['default'] = $this->default;
    		} else {
    			$this->json['default'] = $this->setting->default;
    		}
    		$this->json['js_vars'] = $this->js_vars;
    		$this->json['output']  = $this->output;
    		$this->json['value']   = $this->value();
    		$this->json['choices'] = $this->choices;
    		$this->json['link']    = $this->get_link();
    		$this->json['tooltip'] = $this->tooltip;
    		$this->json['id']      = $this->id;
    		$this->json['l10n']    = apply_filters( 'seva_lite_il8n_strings', array(
    			'on'                 => esc_attr__( 'ON', 'seva-lite' ),
    			'off'                => esc_attr__( 'OFF', 'seva-lite' ),
    			'all'                => esc_attr__( 'All', 'seva-lite' ),
    			'cyrillic'           => esc_attr__( 'Cyrillic', 'seva-lite' ),
    			'cyrillic-ext'       => esc_attr__( 'Cyrillic Extended', 'seva-lite' ),
    			'devanagari'         => esc_attr__( 'Devanagari', 'seva-lite' ),
    			'greek'              => esc_attr__( 'Greek', 'seva-lite' ),
    			'greek-ext'          => esc_attr__( 'Greek Extended', 'seva-lite' ),
    			'khmer'              => esc_attr__( 'Khmer', 'seva-lite' ),
    			'latin'              => esc_attr__( 'Latin', 'seva-lite' ),
    			'latin-ext'          => esc_attr__( 'Latin Extended', 'seva-lite' ),
    			'vietnamese'         => esc_attr__( 'Vietnamese', 'seva-lite' ),
    			'hebrew'             => esc_attr__( 'Hebrew', 'seva-lite' ),
    			'arabic'             => esc_attr__( 'Arabic', 'seva-lite' ),
    			'bengali'            => esc_attr__( 'Bengali', 'seva-lite' ),
    			'gujarati'           => esc_attr__( 'Gujarati', 'seva-lite' ),
    			'tamil'              => esc_attr__( 'Tamil', 'seva-lite' ),
    			'telugu'             => esc_attr__( 'Telugu', 'seva-lite' ),
    			'thai'               => esc_attr__( 'Thai', 'seva-lite' ),
    			'serif'              => _x( 'Serif', 'font style', 'seva-lite' ),
    			'sans-serif'         => _x( 'Sans Serif', 'font style', 'seva-lite' ),
    			'monospace'          => _x( 'Monospace', 'font style', 'seva-lite' ),
    			'font-family'        => esc_attr__( 'Font Family', 'seva-lite' ),
    			'font-size'          => esc_attr__( 'Font Size', 'seva-lite' ),
    			'font-weight'        => esc_attr__( 'Font Weight', 'seva-lite' ),
    			'line-height'        => esc_attr__( 'Line Height', 'seva-lite' ),
    			'font-style'         => esc_attr__( 'Font Style', 'seva-lite' ),
    			'letter-spacing'     => esc_attr__( 'Letter Spacing', 'seva-lite' ),
    			'text-align'         => esc_attr__( 'Text Align', 'seva-lite' ),
    			'text-transform'     => esc_attr__( 'Text Transform', 'seva-lite' ),
    			'none'               => esc_attr__( 'None', 'seva-lite' ),
    			'uppercase'          => esc_attr__( 'Uppercase', 'seva-lite' ),
    			'lowercase'          => esc_attr__( 'Lowercase', 'seva-lite' ),
    			'top'                => esc_attr__( 'Top', 'seva-lite' ),
    			'bottom'             => esc_attr__( 'Bottom', 'seva-lite' ),
    			'left'               => esc_attr__( 'Left', 'seva-lite' ),
    			'right'              => esc_attr__( 'Right', 'seva-lite' ),
    			'center'             => esc_attr__( 'Center', 'seva-lite' ),
    			'justify'            => esc_attr__( 'Justify', 'seva-lite' ),
    			'color'              => esc_attr__( 'Color', 'seva-lite' ),
    			'select-font-family' => esc_attr__( 'Select a font-family', 'seva-lite' ),
    			'variant'            => esc_attr__( 'Variant', 'seva-lite' ),
    			'style'              => esc_attr__( 'Style', 'seva-lite' ),
    			'size'               => esc_attr__( 'Size', 'seva-lite' ),
    			'height'             => esc_attr__( 'Height', 'seva-lite' ),
    			'spacing'            => esc_attr__( 'Spacing', 'seva-lite' ),
    			'ultra-light'        => esc_attr__( 'Ultra-Light 100', 'seva-lite' ),
    			'ultra-light-italic' => esc_attr__( 'Ultra-Light 100 Italic', 'seva-lite' ),
    			'light'              => esc_attr__( 'Light 200', 'seva-lite' ),
    			'light-italic'       => esc_attr__( 'Light 200 Italic', 'seva-lite' ),
    			'book'               => esc_attr__( 'Book 300', 'seva-lite' ),
    			'book-italic'        => esc_attr__( 'Book 300 Italic', 'seva-lite' ),
    			'regular'            => esc_attr__( 'Normal 400', 'seva-lite' ),
    			'italic'             => esc_attr__( 'Normal 400 Italic', 'seva-lite' ),
    			'medium'             => esc_attr__( 'Medium 500', 'seva-lite' ),
    			'medium-italic'      => esc_attr__( 'Medium 500 Italic', 'seva-lite' ),
    			'semi-bold'          => esc_attr__( 'Semi-Bold 600', 'seva-lite' ),
    			'semi-bold-italic'   => esc_attr__( 'Semi-Bold 600 Italic', 'seva-lite' ),
    			'bold'               => esc_attr__( 'Bold 700', 'seva-lite' ),
    			'bold-italic'        => esc_attr__( 'Bold 700 Italic', 'seva-lite' ),
    			'extra-bold'         => esc_attr__( 'Extra-Bold 800', 'seva-lite' ),
    			'extra-bold-italic'  => esc_attr__( 'Extra-Bold 800 Italic', 'seva-lite' ),
    			'ultra-bold'         => esc_attr__( 'Ultra-Bold 900', 'seva-lite' ),
    			'ultra-bold-italic'  => esc_attr__( 'Ultra-Bold 900 Italic', 'seva-lite' ),
    			'invalid-value'      => esc_attr__( 'Invalid Value', 'seva-lite' ),
    		) );
    
    		$defaults = array( 'font-family'=> false );
    
    		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
    	}
    
    	/**
    	 * Enqueue scripts and styles.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function enqueue() {
    		wp_enqueue_style( 'seva-lite-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.css', null );
            
            wp_enqueue_script( 'jquery-ui-core' );
    		wp_enqueue_script( 'jquery-ui-tooltip' );
    		wp_enqueue_script( 'jquery-stepper-min-js' );
    		wp_enqueue_script( 'seva-lite-selectize', get_template_directory_uri() . '/inc/js/selectize.js', array( 'jquery' ), false, true );
    		wp_enqueue_script( 'seva-lite-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.js', array( 'jquery', 'seva-lite-selectize' ), false, true );
    
    		$google_fonts   = Seva_Lite_Fonts::get_google_fonts();
    		$standard_fonts = Seva_Lite_Fonts::get_standard_fonts();
    		$all_variants   = Seva_Lite_Fonts::get_all_variants();
    
    		$standard_fonts_final = array();
    		foreach ( $standard_fonts as $key => $value ) {
    			$standard_fonts_final[] = array(
    				'family'      => $value['stack'],
    				'label'       => $value['label'],
    				'is_standard' => true,
    				'variants'    => array(
    					array(
    						'id'    => 'regular',
    						'label' => $all_variants['regular'],
    					),
    					array(
    						'id'    => 'italic',
    						'label' => $all_variants['italic'],
    					),
    					array(
    						'id'    => '700',
    						'label' => $all_variants['700'],
    					),
    					array(
    						'id'    => '700italic',
    						'label' => $all_variants['700italic'],
    					),
    				),
    			);
    		}
    
    		$google_fonts_final = array();
    
    		if ( is_array( $google_fonts ) ) {
    			foreach ( $google_fonts as $family => $args ) {
    				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
    				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
    
    				$available_variants = array();
    				foreach ( $variants as $variant ) {
    					if ( array_key_exists( $variant, $all_variants ) ) {
    						$available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
    					}
    				}
    
    				$google_fonts_final[] = array(
    					'family'   => $family,
    					'label'    => $label,
    					'variants' => $available_variants
    				);
    			}
    		}
    
    		$final = array_merge( $standard_fonts_final, $google_fonts_final );
    		wp_localize_script( 'seva-lite-typography', 'all_fonts', $final );
    	}
    
    	/**
    	 * An Underscore (JS) template for this control's content (but not its container).
    	 *
    	 * Class variables for this control class are available in the `data` JS object;
    	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
    	 *
    	 * I put this in a separate file because PhpStorm didn't like it and it fucked with my formatting.
    	 *
    	 * @see    WP_Customize_Control::print_template()
    	 *
    	 * @access protected
    	 * @return void
    	 */
    	protected function content_template(){ ?>
    		<# if ( data.tooltip ) { #>
                <a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
            <# } #>
            
            <label class="customizer-text">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            
            <div class="wrapper">
                <# if ( data.default['font-family'] ) { #>
                    <# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
                    <# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
                    <div class="font-family">
                        <h5>{{ data.l10n['font-family'] }}</h5>
                        <select id="seva-lite-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}"></select>
                    </div>
                    <div class="variant seva-lite-variant-wrapper">
                        <h5>{{ data.l10n['style'] }}</h5>
                        <select class="variant" id="seva-lite-typography-variant-{{{ data.id }}}"></select>
                    </div>
                <# } #>   
                
            </div>
            <?php
		} 
		
		protected function render_content(){
			
		}
    }
}