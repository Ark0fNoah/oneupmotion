(function () {
	'use strict';

	const toggle = document.querySelector('.nav-toggle');
	const nav = document.querySelector('.primary-nav');

	if (!toggle || !nav) {
		return;
	}

	toggle.addEventListener('click', function () {
		const isOpen = toggle.getAttribute('aria-expanded') === 'true';
		toggle.setAttribute('aria-expanded', String(!isOpen));
		nav.classList.toggle('is-open', !isOpen);
	});
})();
