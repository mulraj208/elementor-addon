(function ($) {
  var swiper = new Swiper('.custom-slider-wrapper', {
    loop: true,
    autoplay: {
      delay: 8000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
})(jQuery);
