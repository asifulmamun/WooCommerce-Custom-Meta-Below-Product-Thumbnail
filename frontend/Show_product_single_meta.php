<?php

namespace Frontend;

/* 
 * Data Showing
 */
class CustomJSAndCSSForSingleProduct {
    public function __construct() {
        // Add the custom JS and CSS to the wp_footer action
        add_action('wp_footer', array($this, 'add_custom_js_css_for_single_product'));
    }

    public function add_custom_js_css_for_single_product() {
        global $product;

        // Ensure $product is a valid instance and has the get_meta method
        if (!is_a($product, 'WC_Product') || !method_exists($product, 'get_meta')) {
            return;
        }

        // Get the demo URL from product meta
        $demo_url = $product->get_meta('demo_url');
        $video_url = $product->get_meta('video_url');

        // Display the content if demo URL is not empty
        if (!empty($demo_url)) :
            ?>
            <script>
                // Add the View Demo button dynamically after DOMContentLoaded
                document.addEventListener('DOMContentLoaded', function () {
                    contentLoad('view_demo_btn_below_product_thumb', '<a class="view_demo_btn" href="<?php echo esc_url($demo_url); ?>" target="_blank">Sales Page</a>&nbsp;&nbsp;<a class="view_demo_btn" href="<?php echo esc_url($video_url); ?>" target="_blank">Watch Video</a>', '100%', 4);
                });
            </script>
            <style>
                /* Add your existing CSS styles for the View Demo button */
                .view_demo_btn {
                    padding: .8rem 1rem;
                    border-radius: var(--btn-accented-brd-radius);
                    color: var(--btn-accented-color);
                    box-shadow: var(--btn-accented-box-shadow);
                    background-color: var(--btn-accented-bgcolor);
                    text-transform: var(--btn-accented-transform, var(--btn-transform));
                    font-weight: var(--btn-accented-font-weight, var(--btn-font-weight));
                    font-family: var(--btn-accented-font-family, var(--btn-font-family));
                    font-style: var(--btn-accented-font-style, var(--btn-font-style));
                    order: 20;
                }
            </style>
        <?php endif; ?>

        <script type="text/javascript">
            // Function to dynamically add content to the product gallery
            function contentLoad(customID, contentHTML, flexBasis, flexOrder) {
                var galleryWithImages = document.querySelector('.woocommerce-product-gallery--with-images');
                if (galleryWithImages) {
                    var newElement = document.createElement('div');
                    newElement.id = customID;
                    newElement.style.flexBasis = flexBasis;
                    if (flexOrder > 0) {
                        newElement.style.order = flexOrder;
                    }
                    newElement.innerHTML = contentHTML;
                    galleryWithImages.appendChild(newElement);
                }
            }
        </script>
        <style>
            /* Additional CSS styles for the product gallery */
            .woocommerce-product-gallery--with-images {
                display: flex !important;
                flex-wrap: wrap !important;
            }

            .woocommerce-product-gallery--with-images>div:nth-child(1),
            .woocommerce-product-gallery--with-images>div:nth-child(1) {
                flex-basis: fit-content;
            }
        </style>
    <?php }
}