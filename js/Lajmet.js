document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.slider').forEach((slider) => {
        const container = slider.querySelector('.slider-container');
        const nextBtn = slider.querySelector('.nxt-btn');
        const prevBtn = slider.querySelector('.pre-btn');

        // Merrn gjeresin e nje slajdi individual
        const slideWidth = container.querySelector('.post-card').getBoundingClientRect().width;
        
        // Event për butonin 'Next'
        nextBtn.addEventListener('click', () => {
            // Kontrollomi  nese ka më shum per te levizur ne te djathte
            if (container.scrollLeft + container.offsetWidth < container.scrollWidth) {
                container.scrollLeft += slideWidth; // Leviz per nje slajd
            }
        });

        // Event për butonin 'Previous'
        prevBtn.addEventListener('click', () => {
            // Kontrollo nëse ka me shume per te levizur ne te majte
            if (container.scrollLeft > 0) {
                container.scrollLeft -= slideWidth; // Leviz per nje slajd
            }
        });
    });
});