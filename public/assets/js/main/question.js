const faqs = document.querySelectorAll('.faq');

faqs.forEach(faq => {
	faq.addEventListener('click', () =>{
		faq.classList.toggle('open');

		/*change icon*/

		const icon = faq.querySelector('.faq-icon i');
		if(icon.className === 'fa fa-circle-plus'){
			icon.className = 'fa fa-circle-minus';
			icon.parentNode.classList.add('startAligne');

		}else{
			icon.className = 'fa fa-circle-plus';
            icon.parentNode.classList.remove('startAligne');
		}
	})
})