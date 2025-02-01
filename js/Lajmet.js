document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.slider').forEach((slider) => {
        const container = slider.querySelector('.slider-container');
        const nextBtn = slider.querySelector('.nxt-btn');
        const prevBtn = slider.querySelector('.pre-btn');

        const slideWidth = container.querySelector('.post-card').getBoundingClientRect().width;
        
        nextBtn.addEventListener('click', () => {
            if (container.scrollLeft + container.offsetWidth < container.scrollWidth) {
                container.scrollLeft += slideWidth;
            }
        });

     
        prevBtn.addEventListener('click', () => {
          
            if (container.scrollLeft > 0) {
                container.scrollLeft -= slideWidth; 
            }
        });
    });
});