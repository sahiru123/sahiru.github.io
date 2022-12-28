jQuery(document).ready(function ($) {

//   $("#yoga-slider").owlCarousel({
// 	animateOut: 'slideOutDown',
//         animateIn: 'flipInX',
//         navigation: true, // Show next and prev buttons
//         slideSpeed: 200,
//         pagination: true,
//         paginationSpeed: 400,
//         singleItem: true,
//         autoPlay: true,
//         navigationText: [
//             "<i class='fa fa-angle-left'></i>",
//             "<i class='fa fa-angle-right'></i>"
//         ]
//   });
function homeslider() {
  const Homemain = new Swiper('#yoga-slider', {
      direction: 'horizontal',
      loop: true,
      autoplay: true,

      slidesPerView: 1,
      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
      },
  });
}
homeslider();
 });






