document.addEventListener('DOMContentLoaded', () => {
	const toggle = document.querySelector('.mobile-menu-toggle');
	const menu = document.querySelector('#mobile-menu');

	if (!toggle || !menu) {
		return;
	}

	toggle.addEventListener('click', () => {
		const isOpen = toggle.getAttribute('aria-expanded') === 'true';

		toggle.setAttribute('aria-expanded', String(!isOpen));
		toggle.querySelector('.sr-only').textContent = isOpen ? 'Fungua menyu' : 'Funga menyu';
		menu.hidden = isOpen;
	});

	menu.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', () => {
			toggle.setAttribute('aria-expanded', 'false');
			toggle.querySelector('.sr-only').textContent = 'Fungua menyu';
			menu.hidden = true;
		});
	});
});
