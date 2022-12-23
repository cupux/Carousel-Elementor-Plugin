<?php

/**
 * Effects Flickity Image Carousel Widget Add-on
 * 
 * @package effects
 */

namespace Effects\ElementorWidgets\Widgets;

use \Elementor\Widget_Base;

class Effects_ImageCarousel extends Widget_Base
{

  public function get_name()
  {
    return 'effects-image-carousel';
  }

  public function get_title()
  {
    return __('Effects Image Carousel', 'effects');
  }

  public function get_icon()
  {
    return 'eicon-elementor';
  }

  public function get_categories()
  {
    return ['effects', 'basic'];
  }

  public function get_style_depends()
  {
    wp_register_style('effects-style', plugins_url('scss/effects.css', __FILE__));
    wp_register_style('flickity-style', plugins_url('scss/flickity.css', __FILE__));

    return ['effects-style', 'flickity-style'];
  }

  public function get_script_depends()
  {
    wp_register_script('bootstrap-script', plugins_url('js/bootstrap.min.js', __FILE__));
    wp_register_script('flickity-script', plugins_url('js/flickity.pkgd.min.js', __FILE__));
    wp_register_script('effects-script', plugins_url('js/effects.js', __FILE__));

    return ['bootstrap-script', 'flickity-script', 'effects-script'];
  }

  public function register_controls()
  {

    $this->start_controls_section(
      'content-section',
      [
        'label' => __('Content', 'effects'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_title',
      [
        'label' => __('Image Title', 'effects'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Image Item #1', 'effects'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'list_image',
      [
        'label' => __('Image', 'effects'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );

    $repeater->add_control(
      'link',
      [
        'label' => __('Link', 'effects'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __('https://example.com', 'effects'),
        'default' => [
          'url' => __('#', 'effects'),
        ],
        'dynamic' => [
          'active' => true,
        ],
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => __('Image List', 'effects'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'list_title' => __('Image Title #1', 'effects'),
          ],
          [
            'list_title' => __('Image Title #2', 'effects'),
          ],
          [
            'list_title' => __('Image Title #3', 'effects'),
          ],
        ],
        'title_field' => '{{{ list_title }}}'
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $list = $settings['list'];
?>
    <div class="effectsimagecarousel-area">
      <div class="effectsimagecarousel " style="height: 420px;">

        <?php
        if ($list) {
          foreach ($list as $index => $item) {
        ?>
            <a href="<?php echo esc_url($item['link']['url']); ?>" class="cell-link" aria-hidden="true" style="position: absolute; left: 0px; transform: translateX(-100%);height: 100%;">
              <div class="featured-categories-card" style="background-image:url('<?php echo esc_url($item['list_image']['url']); ?>'); height: 100%;margin-right: 15px;">
                <div class="featured-categories-overlay d-flex align-items-end ps-4 pb-3" style="height: 100%;width: 300px; background: rgba(0, 0, 0, 0.4);">
                  <h3 class="featured-categories-item-title" style="color:white;"> <?php echo $item['list_title']; ?>         </h3>
                </div>
              </div>
            </a>
        <?php
          }
        }
        ?>

      </div>
    </div>
  <?php
  }

  protected function content_template()
  {
  ?>
    <div class="effectsimagecarousel-area">
      <div class="effectsimagecarousel owl-carousel d-block">
        <# if(settings.list){ _.each(settings.list,function(item,index){ #>
          <div class="item">
            <img src="{{{item.list_image.url}}}" class="effectscarouselimage">
          </div>
          <# }); } #>
      </div>
    </div>
<?php
  }
}



