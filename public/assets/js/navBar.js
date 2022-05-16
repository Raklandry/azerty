/*changer navbar style*/
const nav = document.querySelector('nav');
window.addEventListener('scroll', () => {
	nav.classList.toggle('window-scroll', window.scrollY > 0);
});

window.addEventListener('load', () => {
	const scrollY = window.scrollY;
	if(scrollY){
		nav.classList.add('window-scroll')
	}
})

/* show hide nav menu */
const body = document.querySelector('body');
const menu = document.querySelector('.nav-menu');
const openBtn = document.querySelector('#open-menu');
const closeBtn = document.querySelector('#close-menu');


openBtn.addEventListener('click', () => {
	menu.style.display = 'flex';
	closeBtn.style.display = 'inline-block';
	openBtn.style.display = 'none';
});

const closeNav = () => {
	menu.style.display = 'none';
	closeBtn.style.display = 'none';
	openBtn.style.display = 'inline-block';
};

closeBtn.addEventListener('click', closeNav);
