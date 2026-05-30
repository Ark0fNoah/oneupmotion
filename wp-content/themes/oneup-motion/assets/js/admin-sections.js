(function () {
	'use strict';

	function escapeHtml(value) {
		return String(value || '').replace(/[&<>"']/g, function (match) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			}[match];
		});
	}

	function bindMedia(root) {
		root.querySelectorAll('[data-oum-media-button]').forEach(function (button) {
			if (button.dataset.oumBound) {
				return;
			}

			button.dataset.oumBound = '1';
			button.addEventListener('click', function () {
				const field = button.closest('label') || button.closest('.oum-section-field');
				const input = field.querySelector('[data-oum-media-input]');
				const preview = field.querySelector('[data-oum-media-preview]');
				const frame = wp.media({
					title: 'Choose image',
					button: { text: 'Use image' },
					multiple: false
				});

				frame.on('select', function () {
					const attachment = frame.state().get('selection').first().toJSON();
					input.value = attachment.id;
					preview.innerHTML = attachment.sizes && attachment.sizes.thumbnail
						? '<img src="' + attachment.sizes.thumbnail.url + '" alt="">'
						: '<span>' + escapeHtml(attachment.filename) + '</span>';
				});

				frame.open();
			});
		});

		root.querySelectorAll('[data-oum-media-clear]').forEach(function (button) {
			if (button.dataset.oumBound) {
				return;
			}

			button.dataset.oumBound = '1';
			button.addEventListener('click', function () {
				const field = button.closest('label') || button.closest('.oum-section-field');
				field.querySelector('[data-oum-media-input]').value = '';
				field.querySelector('[data-oum-media-preview]').innerHTML = '';
			});
		});
	}

	function fieldHtml(sectionIndex, key, field) {
		const base = 'oum_sections[' + sectionIndex + '][' + key + ']';
		let control = '';

		if (field.type === 'textarea') {
			control = '<textarea name="' + base + '" rows="4"></textarea>';
		} else if (field.type === 'select') {
			control = '<select name="' + base + '">' + Object.keys(field.choices || {}).map(function (value) {
				return '<option value="' + escapeHtml(value) + '">' + escapeHtml(field.choices[value]) + '</option>';
			}).join('') + '</select>';
		} else if (field.type === 'checkbox') {
			control = '<input type="checkbox" name="' + base + '" value="1"' + (field.default === '1' ? ' checked' : '') + '>';
		} else if (field.type === 'media') {
			control = '<input type="hidden" name="' + base + '" value="" data-oum-media-input>' +
				'<button type="button" class="button" data-oum-media-button>Choose image</button> ' +
				'<button type="button" class="button-link" data-oum-media-clear>Remove</button>' +
				'<span class="oum-media-preview" data-oum-media-preview></span>';
		} else if (field.type === 'repeater') {
			control = repeaterHtml(sectionIndex, key, field);
		} else {
			control = '<input type="' + (field.type === 'url' ? 'url' : 'text') + '" name="' + base + '" value="">';
		}

		return '<div class="oum-section-field oum-section-field--' + escapeHtml(field.type || 'text') + '">' +
			'<label><span>' + escapeHtml(field.label || key) + '</span>' + control + '</label></div>';
	}

	function repeaterHtml(sectionIndex, key, field) {
		return '<div class="oum-repeater" data-oum-repeater="' + escapeHtml(key) + '" data-oum-repeater-fields="' + encodeURIComponent(JSON.stringify(field.fields || {})) + '">' +
			'<div class="oum-repeater__items" data-oum-repeater-items></div>' +
			'<button type="button" class="button" data-oum-repeater-add>Add item</button></div>';
	}

	function repeaterItemHtml(sectionIndex, repeaterKey, itemIndex, fields) {
		return '<div class="oum-repeater__item" data-oum-repeater-item>' +
			'<button type="button" class="button-link-delete" data-oum-repeater-remove>Remove item</button>' +
			Object.keys(fields).map(function (key) {
				return '<label><span>' + escapeHtml(fields[key]) + '</span>' +
					'<textarea name="oum_sections[' + sectionIndex + '][' + repeaterKey + '][' + itemIndex + '][' + key + ']" rows="2"></textarea></label>';
			}).join('') +
			'</div>';
	}

	function bindBuilder(builder) {
		const list = builder.querySelector('[data-oum-sections-list]');
		const select = builder.querySelector('[data-oum-section-type]');
		const add = builder.querySelector('[data-oum-add-section]');
		const empty = builder.querySelector('[data-oum-empty-state]');
		const data = window.oumSectionBuilder || { types: {}, fields: {}, i18n: {} };

		function updateEmptyState() {
			if (!empty) {
				return;
			}

			empty.hidden = list.querySelectorAll('[data-oum-section]').length > 0;
		}

		function sectionSummary(section) {
			const heading = section.querySelector('input[name$="[heading]"], textarea[name$="[heading]"]');
			const eyebrow = section.querySelector('input[name$="[eyebrow]"], textarea[name$="[eyebrow]"]');
			const summary = section.querySelector('[data-oum-section-summary]');
			const value = (heading && heading.value) || (eyebrow && eyebrow.value) || '';

			if (summary) {
				summary.textContent = value ? value.slice(0, 90) : 'No heading yet';
			}
		}

		add.addEventListener('click', function () {
			const type = select.value;
			const sectionIndex = Date.now();
			const fields = data.fields[type] || {};
			const title = data.types[type] || data.i18n.newSection || 'New Section';
			const body = Object.keys(fields).map(function (key) {
				return fieldHtml(sectionIndex, key, fields[key]);
			}).join('');

			list.insertAdjacentHTML('beforeend',
				'<div class="oum-section-panel" data-oum-section>' +
				'<div class="oum-section-panel__header"><div class="oum-section-panel__title"><strong>' + escapeHtml(title) + '</strong><span data-oum-section-summary>No heading yet</span></div><div class="oum-section-panel__controls">' +
				'<button type="button" class="button" data-oum-move-up>Move Up</button> ' +
				'<button type="button" class="button" data-oum-move-down>Move Down</button> ' +
				'<button type="button" class="button" data-oum-toggle>Collapse</button> ' +
				'<button type="button" class="button-link-delete" data-oum-remove>Remove</button>' +
				'</div></div><div class="oum-section-panel__body">' +
				'<input type="hidden" name="oum_sections[' + sectionIndex + '][type]" value="' + escapeHtml(type) + '">' +
				'<input type="hidden" name="oum_sections[' + sectionIndex + '][id]" value="oum_' + sectionIndex + '">' +
				body + '</div></div>'
			);
			bindMedia(list);
			updateEmptyState();
		});

		builder.addEventListener('click', function (event) {
			const section = event.target.closest('[data-oum-section]');

			if (event.target.matches('[data-oum-remove]') && section) {
				section.remove();
				updateEmptyState();
			}

			if (event.target.matches('[data-oum-toggle]') && section) {
				section.classList.toggle('is-collapsed');
			}

			if (event.target.matches('[data-oum-move-up]') && section && section.previousElementSibling) {
				section.parentNode.insertBefore(section, section.previousElementSibling);
			}

			if (event.target.matches('[data-oum-move-down]') && section && section.nextElementSibling) {
				section.parentNode.insertBefore(section.nextElementSibling, section);
			}

			if (event.target.matches('[data-oum-repeater-remove]')) {
				event.target.closest('[data-oum-repeater-item]').remove();
			}

			if (event.target.matches('[data-oum-repeater-add]')) {
				const repeater = event.target.closest('[data-oum-repeater]');
				const parentSection = event.target.closest('[data-oum-section]');
				const typeInput = parentSection.querySelector('input[name$="[type]"]');
				const match = typeInput.name.match(/oum_sections\[([^\]]+)\]/);
				const sectionIndex = match ? match[1] : Date.now();
				const repeaterKey = repeater.dataset.oumRepeater;
				const fields = repeater.dataset.oumRepeaterFields
					? JSON.parse(decodeURIComponent(repeater.dataset.oumRepeaterFields))
					: ((data.fields[typeInput.value] || {})[repeaterKey] || {}).fields || {};
				const itemIndex = Date.now();

				repeater.querySelector('[data-oum-repeater-items]').insertAdjacentHTML('beforeend', repeaterItemHtml(sectionIndex, repeaterKey, itemIndex, fields));
			}
		});

		builder.addEventListener('input', function (event) {
			const section = event.target.closest('[data-oum-section]');

			if (section && event.target.matches('input[name$="[heading]"], textarea[name$="[heading]"], input[name$="[eyebrow]"], textarea[name$="[eyebrow]"]')) {
				sectionSummary(section);
			}
		});

		updateEmptyState();
	}

	document.addEventListener('DOMContentLoaded', function () {
		bindMedia(document);
		document.querySelectorAll('[data-oum-sections-builder]').forEach(bindBuilder);
	});
})();
