<?php
// Добавление хука в файл functions.php вашей темы
function display_product_attributes() {
    global $product;

    // Получаем все атрибуты товара
    $attributes = $product->get_attributes();

    // Удаляем атрибут 'srok-proizvodstva' из массива атрибутов
    if (isset($attributes['pa_srok-proizvodstva'])) {
        unset($attributes['pa_srok-proizvodstva']);
    }

    // Переменные для значений атрибутов
    $color_attribute = '';
    $other_attributes_html = '';

    // Перебираем атрибуты и выводим их значения
    if ($attributes) {
        foreach ($attributes as $attribute) {
            $attribute_name = $attribute->get_name();
            $attribute_value = $product->get_attribute($attribute_name);

            // Проверяем, чтобы не выводить пустые значения
            if (!empty($attribute_value)) {
                // Если атрибут "Цвет", то добавляем его к другим атрибутам
                if ($attribute_name === 'pa_color') {
                    $color_attribute = '<li class="product-attributes-item"><div class="attribute-label">Цвет:</div><div class="attribute-value">' . esc_html($attribute_value) . '</div></li>';
                } else {
                    $other_attributes_html .= '<li class="product-attributes-item"><div class="attribute-label">' . wc_attribute_label($attribute_name) . ':</div><div class="attribute-value">' . esc_html($attribute_value) . '</div></li>';
                }
            }
        }
    }

    // Выводим блок для атрибутов

    // Выводим блок для атрибута "Срок производства" и "Артикул"
    $production_time_value = $product->get_attribute('srok-proizvodstva');
    $sku = $product->get_sku();
   
    echo '<div class="attributes-title">Информация о товаре </div>';
    echo '<ul class="product-attributes-marker">'; 
    echo !empty($production_time_value) ? '<li class="product-attributes-item"><div class="attribute-label">Срок производства:</div><div class="attribute-value">' . esc_html($production_time_value) . '</div></li>' : '';
    echo '</ul>';

    // Выводим блок для характеристик
    echo '<div class="attributes-title">Характеристики </div>';
    echo '<ul class="product-attributes">';
    echo !empty($sku) ? '<li class="product-attributes-item"><div class="attribute-label">Артикул:</div><div class="attribute-value">' . esc_html($sku) . '</div></li>' : '';
    echo $color_attribute;
    echo $other_attributes_html;
    echo '</ul>';



    echo '</div>'; // Закрываем блок для атрибутов
}

remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);


function custom_content_in_summary() {
    global $product;

    // Блок "В избранное" и "Поделиться"
    echo '<div class="custom-content-in-summary">';
    echo '<div class="product-content">';



    echo '<div class="share-block">';
    echo '<div class="favorite-button">' . do_shortcode('[ti_wishlists_addtowishlist loop=yes]') . '</div>';
    echo '<button id="shareButton" class="share-button">Поделиться</button>';
    echo '</div>';
        // Получаем значения атрибутов new и srok-proizvodstva
        $new = $product->get_attribute('new');
    

        // Проверяем, существуют ли значения атрибутов
        if (!empty($new)) {
            echo '<div class="product-attributes-top">';      
            echo '<div class="attribute-value">' . esc_html($new) . '</div>';
          
        }
    
    
    // Получаем метку атрибута "srok-proizvodstva"
    $srok_proizvodstva_label = $product->get_attribute('srok-proizvodstva');
    
    // Проверяем наличие атрибута "ot-2-dnej" у товара
    if (has_term('ot-2-dnej', 'pa_srok-proizvodstva', $product_id)) {
        // Если атрибут присутствует, выводим блок
    
        echo '<div class="attribute-value">Производтсво ' . esc_html($srok_proizvodstva_label) . '</div>';
    
    }
    echo '<div class="discount-percentage">' . do_shortcode('[discount_percentage]') . '</div>';
    
    
// Если товар не вариативный, выводим закрывающий тег div
if (!$product->is_type('variable')) {

    echo '</div>'; // Закрываем блок "product-content"
}

    
    
echo '<h2 class="product-title">' . get_the_title($product->get_id()) . '</h2>';
global $product;

// Проверяем, является ли товар вариативным
if ($product->is_type('variable')) {
    // Получаем доступные вариации товара
    $variations = $product->get_available_variations();

    // Создаем массив для хранения цен вариаций
    $variation_prices = array();

    // Проходим по каждой вариации
    foreach ($variations as $variation) {
        // Получаем цену вариации
        $variation_price = $variation['display_price'];

        // Добавляем цену в массив
        $variation_prices[] = $variation_price;
    }

    // Находим максимальную цену среди всех вариаций
    $max_price = max($variation_prices);

    // Выводим максимальную цену
    echo '<p class="product-price">' . wc_price($max_price) . '</p>';

    // Вставляем блок с ценой вариации в конец контейнера с ценой товара
    echo '<div class="woocommerce-variation-price" style="display:none;"><span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>' . wc_price($max_price) . '&nbsp;<span class="woocommerce-Price-currencySymbol">₽</span></bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi>' . wc_price($max_price) . '&nbsp;<span class="woocommerce-Price-currencySymbol">₽</span></bdi></span></ins></span></div>';
} else {
    // Если товар не вариативный, выводим цену со скидкой, если она есть, или обычную цену
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    if ($sale_price) {
        echo '<span class="regular-price">' . wc_price($regular_price) . '</span>';
        echo '<span class="sale-price">' . wc_price($sale_price) . '</span>';
    } else {
        echo '<p class="product-price">' . wc_price($product->get_price()) . '</p>';
    }
}





    // Блок "Информация о товаре"
    echo '<div class="product-info-block">';
    
    // Вывод вариаций
    if ($product->is_type('variable')) {
        echo '<div class="variations-block">';
        // Ваш код для вывода вариаций
        woocommerce_variable_add_to_cart();
        echo '</div>';
    } else {
        // Если товар не вариативный, выводим кнопку "В корзину" здесь
        echo '<div class="single-add-to-cart-button">';
        woocommerce_template_single_add_to_cart();
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="attributes-block">';
    
    // Вывод атрибутов товара
    display_product_attributes();
    
  
 echo '</div>';  
    echo '</div>'; // Закрытие блока "custom-content-in-summary"
}

// Добавляем новый хук для вывода похожих товаров после блока single-product
add_action( 'woocommerce_after_single_product', 'custom_output_related_products', 1);

add_action('init', 'remove_product_meta');

function remove_product_meta() {
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
}
// Ваша функция для вывода похожих товаров
function custom_output_related_products() {
    // Получаем похожие товары
    $related_products = wc_get_related_products(get_the_ID(), 16);

    if ($related_products) {
        echo '<section class="related products">';
        
        echo '<div class="related-bottom">';
        echo '<h2 class="related-title">Похожие товары</h2>';
        echo '<div class="swiper-container mySecondSwiper related-products-slider">';
        echo '<div class="swiper-wrapper">';

        foreach ($related_products as $related_product_id) {
            $related_product = wc_get_product($related_product_id);

            // Выводим карточку похожего товара
            echo '<div class="swiper-slide slide-margin">';
            echo '<div class="products__item">';
            echo '<a href="' . esc_url(get_permalink($related_product_id)) . '" class="related-product-link products__link">';  
            echo $related_product->get_image(array(400, 400), array('class' => 'products__img'));
            echo '<h2 class="products__item-title related-product-title">' . esc_html($related_product->get_title()) . '</h2>';
            echo '<p class="products__item-price related-product-price">' . $related_product->get_price_html() . '</p>';
            echo '</a>';                 
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

function remove_default_variations( $product_id ) {
    $product = wc_get_product( $product_id );

    // Проверяем, является ли товар переменным
    if ( $product && $product->is_type( 'variable' ) ) {
        // Удаление стандартных вариаций
        $variations = $product->get_children();

        foreach ( $variations as $variation_id ) {
            $variation_data = wc_get_product( $variation_id );
            $variation_data->delete( true );
        }
    }
}

add_action( 'woocommerce_new_product', 'remove_default_variations' );



// Добавление хуков
add_action('woocommerce_single_product_summary', 'custom_content_in_summary', 15);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action('woocommerce_after_single_product', 'custom_content_after_single_product', 15);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

// Удаление вкладок табов описание, детали
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );       // Remove the description tab
    unset( $tabs['reviews'] );           // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab
    return $tabs;
}

add_filter('wpcf7_autop_or_not', '__return_false');
function customize_product_card_classes($classes, $product) {
    // Добавляем свой класс к каждой карточке товара
    $classes[] = 'products__item';

    // Дополнительные примеры:
    // Добавляем класс, если товар имеет скидку
    if ($product->is_on_sale()) {
        $classes[] = 'on-sale';
    }

    // Добавляем класс, если товар новый
    if ($product->is_new()) {
        $classes[] = 'new';
    }

    return $classes;
}
add_filter('woocommerce_product_get_class', 'customize_product_card_classes', 10, 2);


function get_popular_products() {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6, // Количество товаров для отображения
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
    );

    $popular_products = new WP_Query($args);

    return $popular_products;
}


// Обработчик AJAX для проверки статуса корзины
add_action('wp_ajax_check_cart_status', 'check_cart_status_callback');
add_action('wp_ajax_nopriv_check_cart_status', 'check_cart_status_callback');

function check_cart_status_callback() {
    if (WC()->cart->is_empty()) {
        echo 'empty';
    } else {
        echo 'not_empty';
    }
    wp_die();
}


add_filter( 'loop_shop_per_page', function ( $cols ) {
    return 25;
  }, 25 );


