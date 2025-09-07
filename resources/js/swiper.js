import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    const swipers = document.querySelectorAll('.swiper');
    swipers.forEach((el) => {
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
        let extra = {};
        const opts = el.getAttribute('data-swiper-options');
        if (opts) {
            try { extra = JSON.parse(opts); } catch (e) { /* ignore */ }
        }
        // eslint-disable-next-line no-new
        new Swiper(el, Object.assign({}, base, extra));
    });
});