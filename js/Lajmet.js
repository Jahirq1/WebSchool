document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.slider').forEach((slider) => {
        const container = slider.querySelector('.slider-container');
        const nextBtn = slider.querySelector('.nxt-btn');
        const prevBtn = slider.querySelector('.pre-btn');

        const containerWidth = container.getBoundingClientRect().width;

        nextBtn.addEventListener('click', () => {
            container.scrollLeft += containerWidth;
        });

        prevBtn.addEventListener('click', () => {
            container.scrollLeft -= containerWidth;
        });
    });
});