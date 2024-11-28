const button = document.querySelector('.moreEventeButton');
const post4 = document.querySelector('.post3');

button.addEventListener('click', () => {
    post4.classList.toggle('show');
    if (post4.classList.contains('show')) {
        button.textContent = "Mbylle kete pjesen"; 
    } else {
        button.textContent = "Kliko per te shfaqur me shum"; 
    }
});