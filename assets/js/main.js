//Перемещение блока header__socials-list
function moveSocialsBetweenBlocks() {
    const headerMiddle = document.querySelector('.header__middle');
    const headerSocialsList = document.querySelector('.header__socials-list');
    const blockBeforeTop = document.querySelector('.header__hamburger'); // Замените на селектор блока перед header__top

    if (window.innerWidth < 868) { // Изменено условие на < 678px
        // Перемещаем header__socials-list между блоками
        blockBeforeTop.insertAdjacentElement('afterend', headerSocialsList);
    } else {
        // Если экран становится шире 678px, возвращаем блок на исходное место
        headerMiddle.insertBefore(headerSocialsList, document.querySelector('.header__logo').nextSibling);
    }
}

window.addEventListener('load', moveSocialsBetweenBlocks);
window.addEventListener('resize', moveSocialsBetweenBlocks);

document.addEventListener('DOMContentLoaded', function () {
  // Весь ваш JavaScript-код здесь

  // Header mobile menu
  const hamburger = document.querySelector('.header__hamburger');
  const nav = document.querySelector('.header__mobile');
  const overlay = document.querySelector('.overlay');
  
  hamburger.addEventListener('click', function () {
    hamburger.classList.toggle('active');
    nav.classList.toggle('active');
    
    // Добавляем или удаляем класс scroll-lock в зависимости от состояния меню
    if (nav.classList.contains('active')) {
      overlay.style.display = 'block';
      document.body.classList.add('scroll-lock'); // Блокируем скролл контента
    } else {
      overlay.style.display = 'none';
      document.body.classList.remove('scroll-lock'); // Разблокируем скролл контента
    }
  });

  // Закрывать меню при клике вне него
  document.addEventListener('click', function (e) {
    if (!hamburger.contains(e.target) && !nav.contains(e.target)) {
      hamburger.classList.remove('active');
      nav.classList.remove('active');
      overlay.style.display = 'none';
      document.body.classList.remove('scroll-lock'); // Разблокируем скролл контента при закрытии меню
    }
  });

// Получаем элементы для открытия поиска при наведении на иконку
const searchIcon = document.getElementById('search-icon');
const searchInput = document.getElementById('search-input');

// Обработчик события для наведения мыши
searchIcon.addEventListener('mouseenter', () => {
  searchInput.style.display = 'block';
});

// Обработчик события для клика на мобильных устройствах (touchstart)
searchIcon.addEventListener('touchstart', () => {
  searchInput.style.display = 'block';
});

// Обработчик события для ухода мыши
searchInput.addEventListener('mouseleave', () => {
  searchInput.style.display = 'none';
});

// Обработчик события для клика на мобильных устройствах (touchstart)
searchIcon.addEventListener('click', () => {
  searchInput.style.display = 'block';
});
});

  // Показать модальное окно
  document.addEventListener('DOMContentLoaded', function() {
    var shareButton = document.getElementById('shareButton');
    var shareModal = document.getElementById('shareModal');
  
    if (shareButton && shareModal) {
      shareButton.addEventListener('click', function() {
        shareModal.style.display = 'block';
      });
  
      // Скрыть модальное окно при клике вне него
      document.addEventListener('click', function(event) {
        if (!event.target.closest('#shareModal') && event.target.id !== 'shareButton') {
          shareModal.style.display = 'none';
        }
      });
  
      // Функции для "поделиться" в социальных сетях
      function shareOnFacebook() {
        // Логика для поделиться на Facebook
        alert('Поделиться на Facebook');
      }
  
      function shareOnTwitter() {
        // Логика для поделиться на Twitter
        alert('Поделиться на Twitter');
      }
    }
  });
jQuery(document).ready(function($) {
    function quantity_upd() {
        // Получите селекторы по классу
        let quantitySelects = $('.custom-quantity-select');
        let quantityInputs = $('.qty');
        let updateCartButton = $('button[name="update_cart"]');

        // Отключите кнопку "Обновить корзину" по умолчанию
        updateCartButton.prop('disabled', true);

        // Удалим предыдущие обработчики событий
        quantitySelects.off('change', handleSelectChange);

        // Обработчик события для изменения селекта
        function handleSelectChange() {
            let index = quantitySelects.index(this);
            let selectedValue = $(this).val();

            // Обновим значение соответствующего input
            quantityInputs.eq(index).val(selectedValue);

            updateCartButton.prop('disabled', false);
            updateCartButton.click();
        }

        // Добавьте новые обработчики событий
        quantitySelects.on('change', handleSelectChange);
    }

    // Вызовите функцию quantity_upd сразу после загрузки страницы
    $(window).on('load', quantity_upd);

    // Обработчик события после обновления корзины
    $(document).on('updated_cart_totals', function() {
        quantity_upd();
    });
});





// Получаем URL текущей страницы
var productURL = window.location.href;

// Извлекаем название товара из URL
var productName = getProductTitleFromURL(productURL);

// Получаем все элементы с классом .image-variable-item
var variationItems = document.querySelectorAll('.image-variable-item');

// Обходим каждый элемент в цикле
variationItems.forEach(function(item) {
    // Добавляем обработчик события клика на каждый элемент
    item.addEventListener('click', function(event) {
        // Получаем значение вариации из атрибута data-value
        var variationValue = this.getAttribute('data-value');

        // Создаем базовый URL товара
        var baseURL = 'http://ambia.local/product';

        // Генерируем ссылку с выбранной вариацией и названием товара
        var generatedLink = generateLink(baseURL, productName, variationValue);

        // Выводим сгенерированную ссылку в консоль
        console.log('Сгенерированная ссылка:', generatedLink);

        // Предотвращаем стандартное действие ссылки (переход по ней)
        event.preventDefault();

        // Здесь вы можете использовать сгенерированную ссылку для чего угодно, кроме перехода по ней
    });
});

// Функция для извлечения названия товара из URL
function getProductTitleFromURL(url) {
    var lastSegment = url.split('/').filter(Boolean).pop();
    return decodeURIComponent(lastSegment); 
}

// Функция для генерации ссылки с выбранной вариацией
function generateLink(baseURL, productName, variationValue) {
    return baseURL + '/' + productName.toLowerCase().replace(/ /g, '-') + '/?attribute_pa_color=' + variationValue;
}
jQuery(document).ready(function($) {
  // Слушаем изменения вариаций
  $('.variations select').change(function() {
      // Получаем выбранное значение вариации
      var selected_option = $(this).val();

      // Находим соответствующий блок с ценой вариации
      var variation_price = $('.woocommerce-variation-price[data-value="' + selected_option + '"]').html();

      // Обновляем блок с ценой товара
      $('.product-price').html(variation_price);
  });
});
