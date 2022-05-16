AOS.init({
    offset: 200,
    duration: 1000,
});

const navSlide = () => {
    const menuIcon = document.querySelector('.menu-icon');
    const navLink = document.querySelector('.nav-link');
    const navLinks = document.querySelectorAll('.nav-link li');

    menuIcon.addEventListener('click', () => {
        navLink.classList.toggle('nav-active');

        navLinks.forEach((link, index) => {
            if(link.style.animation){
                link.style.animation='';
            }else{
                link.style.animation = `navLinkFade 0.5s ease-out ${index / 8}s`;
            }
            
        });

        menuIcon.classList.toggle('togge');
    });

}
navSlide();