import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    const configs = {
        certificates: {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 },
            },
            loop: false,
        },
    };

    document.querySelectorAll('.swiper').forEach((el) => {
        const key = el.getAttribute('data-swiper-key');
        const extra = key && configs[key] ? configs[key] : {};
        const base = {
            loop: true,
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        };
        // eslint-disable-next-line no-new
        new Swiper(el, { ...base, ...extra });
    });
});