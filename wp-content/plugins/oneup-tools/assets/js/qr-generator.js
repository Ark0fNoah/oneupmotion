(function () {
	'use strict';

	const tools = document.querySelectorAll('[data-oneup-qr-generator]');

	tools.forEach(function (tool) {
		const button = tool.querySelector('[data-oneup-qr-generate]');
		const preview = tool.querySelector('[data-oneup-qr-preview]');
		const url = tool.querySelector('[name="oneup_qr_url"]');
		const foreground = tool.querySelector('[name="oneup_qr_foreground"]');
		const background = tool.querySelector('[name="oneup_qr_background"]');

		if (!button || !preview || !url || !foreground || !background) {
			return;
		}

		button.addEventListener('click', function () {
			const label = url.value.trim() || 'oneupmotion.com';

			preview.classList.add('is-generated');
			preview.style.color = foreground.value;
			preview.style.backgroundColor = background.value;
			preview.style.backgroundImage = [
				'linear-gradient(90deg, ' + foreground.value + ' 10px, transparent 10px)',
				'linear-gradient(' + foreground.value + ' 10px, transparent 10px)'
			].join(',');
			preview.querySelector('span').textContent = 'Preview for ' + label;

			// TODO: Replace this placeholder with a real QR rendering library.
		});
	});
})();
