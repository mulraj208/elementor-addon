(function ($) {
  var swiper = new Swiper('.custom-slider-wrapper', {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
})(jQuery);
