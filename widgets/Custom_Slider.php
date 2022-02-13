<?php


use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Custom_Slider Widget
 */
class Custom_Slider extends \Elementor\Widget_Base {
  /**
   * Get widget name.
   *
   * Retrieve list widget name.
   *
   * @return string Widget name.
   * @since 1.0.0
   * @access public
   */
  public function get_name() {
    return 'custom-slider';
  }

  /**
   * Get widget title.
   *
   * Retrieve list widget title.
   *
   * @return string Widget title.
   * @since 1.0.0
   * @access public
   */
  public function get_title() {
    return esc_html__( 'Custom Slider', 'elementor-addon' );
  }

  /**
   * Get widget icon.
   *
   * Retrieve list widget icon.
   *
   * @return string Widget icon.
   * @since 1.0.0
   * @access public
   */
  public function get_icon() {
    return 'eicon-bullet-list';
  }

  /**
   * Get custom help URL.
   *
   * Retrieve a URL where the user can get more information about the widget.
   *
   * @return string Widget help URL.
   * @since 1.0.0
   * @access public
   */
  public function get_custom_help_url() {
    return 'https://developers.elementor.com/docs/widgets/';
  }

  /**
   * Get widget categories.
   *
   * Retrieve the list of categories the list widget belongs to.
   *
   * @return array Widget categories.
   * @since 1.0.0
   * @access public
   */
  public function get_categories() {
    return [ 'general' ];
  }

  /**
   * Get widget keywords.
   *
   * Retrieve the list of keywords the list widget belongs to.
   *
   * @return array Widget keywords.
   * @since 1.0.0
   * @access public
   */
  public function get_keywords() {
    return [ 'custom', 'slider', 'carousel' ];
  }

  public function get_script_depends() {
    wp_register_script( 'custom-slider-script', plugins_url( 'assets/js/custom-slider.js', __FILE__ ), [ 'swiper' ] );
    wp_register_script( 'swiper', plugins_url( 'assets/js/vendor/swiper.min.js', __FILE__ ) );

    return [ 'custom-slider-script' ];
  }

  public function get_style_depends() {
    wp_register_style( 'custom-slider-style', plugins_url( 'assets/dist/custom-slider.css', __FILE__ ),
      [ 'swiper-style' ] );
    wp_register_style( 'swiper-style', plugins_url( 'assets/css/vendor/swiper-bundle.min.css', __FILE__ ) );

    return [
      'custom-slider-style',
    ];
  }

  protected function register_controls() {

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__( 'Content', 'elementor-addon' ),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'image',
      [
        'label'       => esc_html__( 'Choose Image', 'elementor-addon' ),
        'type'        => Controls_Manager::MEDIA,
        'label_block' => true,
        'dynamic'     => [
          'active' => true,
        ],
        'default'     => [
          'url' => Utils::get_placeholder_image_src(),
        ],
      ]
    );

    $repeater->add_control(
      'slider_title', [
        'label'       => esc_html__( 'Title', 'elementor-addon' ),
        'type'        => Controls_Manager::TEXT,
        'default'     => esc_html__( 'List Title', 'elementor-addon' ),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'slider_content', [
        'label'      => esc_html__( 'Content', 'elementor-addon' ),
        'type'       => Controls_Manager::WYSIWYG,
        'default'    => esc_html__( 'List Content', 'elementor-addon' ),
        'show_label' => false,
      ]
    );

    $repeater->add_control(
      'slider_link_text', [
        'label'       => esc_html__( 'Link Text', 'elementor-addon' ),
        'type'        => Controls_Manager::TEXT,
        'default'     => esc_html__( 'See More', 'elementor-addon' ),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'slider_link', [
        'label'       => esc_html__( 'Link Url', 'elementor-addon' ),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
        'default'     => [
          'url'               => '',
          'is_external'       => true,
          'nofollow'          => true,
          'custom_attributes' => '',
        ],
        'label_block' => true,
      ]
    );

    $this->add_control(
      'list',
      [
        'label'       => esc_html__( 'Repeater List', 'elementor-addon' ),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'default'     => [
          [
            'image'            => [
              'url' => Utils::get_placeholder_image_src(),
            ],
            'slider_title'     => esc_html__( 'Title #1', 'elementor-addon' ),
            'slider_content'   => esc_html__( 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
              'elementor-addon' ),
            'slider_link_text' => esc_html__( 'See More', 'elementor-addon' ),
            'slider_link'      => esc_html__( 'https://your-link.com', 'elementor-addon' ),
          ],
          [
            'image'            => [
              'url' => Utils::get_placeholder_image_src(),
            ],
            'slider_title'     => esc_html__( 'Title #2', 'elementor-addon' ),
            'slider_content'   => esc_html__( 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
              'elementor-addon' ),
            'slider_link_text' => esc_html__( 'See More', 'elementor-addon' ),
            'slider_link'      => esc_html__( 'https://your-link.com', 'elementor-addon' ),
          ],
        ],
        'title_field' => '{{{ slider_title }}}',
      ]
    );

    $this->end_controls_section();

  }

  protected function render() {
    $settings = $this->get_settings_for_display();

    if ( $settings['list'] ) {
      echo '<div class="swiper custom-slider-wrapper">';
      echo '<div class="swiper-wrapper">';
      foreach ( $settings['list'] as $item ) {
        echo '<div class="swiper-slide" style="background-image: url(' . esc_url( $item['image']['url'] ) . ')">';
        echo '<div class="elementor-background-overlay"></div>';
        echo '<div class="content">';
        echo '<div class="elementor-divider-separator"></div>';

        if ( $item['slider_title'] ) {
          echo '<h2 class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . '">' . $item['slider_title'] . '</h2>';
        }

        if ( $item['slider_content'] ) {
          echo '<p>' . $item['slider_content'] . '</p>';
        }

        if ( $item['slider_link_text'] || $item['slider_link']['url'] ) {
          echo '<a href="' . $item['slider_link']['url'] . '" class="" role="button">' . $item['slider_link_text'] . '</a>';
        }

        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
      echo '<div class="swiper-button-next"></div><div class="swiper-button-prev"></div>';
      echo '</div>';
    }
  }

  protected function content_template() {
    ?>
    <# if ( settings.list.length ) { #>
    <div class="swiper custom-slider-wrapper">
      <div class="swiper-wrapper">
        <# _.each( settings.list, function( item ) { #>
        <div class="swiper-slide" style="background-image: url('{{{ item.image.url }}}')">
          <# if ( item.slider_title ) { #>
            <h2 class="elementor-repeater-item-{{ item._id }}">{{{ item.slider_title }}}</h2>
          <# } #>

          <# if ( item.slider_content ) { #>
            <p>{{{ item.slider_content }}}</p>
          <# } #>

          <# if ( item.slider_link_text || item.slider_link.url ) { #>
            <a href="{{{ item.slider_link.url }}}" class="" role="button">{{{ item.slider_link_text }}}</a>
          <# } #>
        </div>
        <# }); #>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
    <# } #>
    <?php
  }
}
