document.getElementById('moreEventsButton').addEventListener('click', function() {
    var post3 = document.getElementById('post3');
    if (post3.style.display === 'none' || post3.style.display === '') {
        post3.style.display = 'flex'; // Bën të dukshëm postimin e tretë
    } else {
        post3.style.display = 'none'; // Mund ta fshehësh përsëri nëse dëshiron
    }
});
