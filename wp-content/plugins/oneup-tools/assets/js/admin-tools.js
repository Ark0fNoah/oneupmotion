(function () {
	'use strict';

	function bindMediaField(field) {
		const input = field.querySelector('[data-oneup-tools-media-input]');
		const preview = field.querySelector('[data-oneup-tools-media-preview]');
		const choose = field.querySelector('[data-oneup-tools-media-button]');
		const clear = field.querySelector('[data-oneup-tools-media-clear]');

		if (!input || !preview || !choose || !window.wp || !wp.media) {
			return;
		}

		choose.addEventListener('click', function () {
			const frame = wp.media({
				title: 'Choose logo',
				button: { text: 'Use logo' },
				multiple: false
			});

			frame.on('select', function () {
				const attachment = frame.state().get('selection').first().toJSON();
				input.value = attachment.id;
				preview.innerHTML = attachment.sizes && attachment.sizes.thumbnail
					? '<img src="' + attachment.sizes.thumbnail.url + '" alt="">'
					: '<span>' + attachment.filename + '</span>';
			});

			frame.open();
		});

		clear.addEventListener('click', function () {
			input.value = '';
			preview.innerHTML = '';
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.oneup-tools-media-field').forEach(bindMediaField);
	});
})();
