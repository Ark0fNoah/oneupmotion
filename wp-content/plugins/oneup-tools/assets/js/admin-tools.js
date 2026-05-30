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


	function bindTabs() {
		const tabs = document.querySelectorAll('[data-oneup-tools-tab]');
		const panels = document.querySelectorAll('[data-oneup-tools-panel]');

		if (!tabs.length || !panels.length) {
			return;
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function (event) {
				event.preventDefault();

				const target = document.querySelector(tab.getAttribute('href'));

				tabs.forEach(function (item) {
					item.classList.remove('nav-tab-active');
				});

				panels.forEach(function (panel) {
					panel.hidden = true;
					panel.classList.remove('is-active');
				});

				tab.classList.add('nav-tab-active');

				if (target) {
					target.hidden = false;
					target.classList.add('is-active');
				}
			});
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		bindTabs();
		document.querySelectorAll('.oneup-tools-media-field').forEach(bindMediaField);
	});
})();
