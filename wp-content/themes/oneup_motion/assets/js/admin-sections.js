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

	function getData() {
		return window.oumSectionBuilder || { types: {}, fields: {}, i18n: {} };
	}

	function isAdvancedKey(key) {
		return ['section_anchor', 'background_style', 'layout_width', 'section_spacing', 'text_alignment', 'custom_class'].indexOf(key) !== -1;
	}

	function isCompactField(key, field) {
		var type = field && field.type ? field.type : 'text';

		return type === 'select' || type === 'checkbox' || key.indexOf('button_') === 0 || key.indexOf('_url') !== -1 || key === 'url';
	}

	function closestField(element) {
		return element ? element.closest('.oum-section-field') : null;
	}

	function findSiblingField(iconSelectField, key) {
		var parent = iconSelectField ? iconSelectField.parentElement : null;

		while (parent) {
			var field = parent.querySelector(':scope > .oum-section-field[data-oum-field-key="' + key + '"]');

			if (field) {
				return field;
			}

			parent = parent.parentElement;
		}

		return null;
	}

	function updateSingleIconGroup(select) {
		var iconSelectField = closestField(select);

		if (!iconSelectField) {
			return;
		}

		var value = select.value || 'none';
		var visibility = {
			icon_text: value === 'text',
			icon_image_id: value === 'media',
			icon_url: value === 'url',
			icon_svg: value === 'svg',
			icon_alt: value === 'media' || value === 'url' || value === 'svg'
		};

		Object.keys(visibility).forEach(function (key) {
			var field = findSiblingField(iconSelectField, key);

			if (!field) {
				return;
			}

			var show = visibility[key];

			field.hidden = !show;
			field.style.display = show ? '' : 'none';
			field.classList.toggle('is-hidden-by-icon-type', !show);
			field.setAttribute('aria-hidden', show ? 'false' : 'true');
		});
	}

	function updateIconVisibility(root) {
		root.querySelectorAll('.oum-section-field[data-oum-field-key="icon_type"] select').forEach(updateSingleIconGroup);
	}

	function media(root) {
		root.querySelectorAll('[data-oum-media-button]').forEach(function (button) {
			if (button.dataset.oumBound) {
				return;
			}

			button.dataset.oumBound = '1';
			button.addEventListener('click', function () {
				var field = button.closest('label') || button.closest('.oum-section-field');
				var input = field.querySelector('[data-oum-media-input]');
				var preview = field.querySelector('[data-oum-media-preview]');

				if (!window.wp || !wp.media) {
					return;
				}

				var frame = wp.media({
					title: 'Choose image',
					button: { text: 'Use image' },
					multiple: false
				});

				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
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
				var field = button.closest('label') || button.closest('.oum-section-field');
				field.querySelector('[data-oum-media-input]').value = '';
				field.querySelector('[data-oum-media-preview]').innerHTML = '';
			});
		});
	}

	function repeaterMarkup(sectionIndex, key, field) {
		return '<div class="oum-repeater" data-oum-repeater="' + escapeHtml(key) + '" data-oum-repeater-fields="' + encodeURIComponent(JSON.stringify(field.fields || {})) + '"><div class="oum-repeater__items" data-oum-repeater-items></div><button type="button" class="button" data-oum-repeater-add>Add item</button></div>';
	}

	function fieldMarkup(sectionIndex, key, field) {
		var base = 'oum_sections[' + sectionIndex + '][' + key + ']';
		var content = '';
		var type = field.type || 'text';
		var classes = 'oum-section-field oum-section-field--' + escapeHtml(type);

		if (isAdvancedKey(key)) {
			classes += ' oum-section-field--advanced';
		}

		if (isCompactField(key, field)) {
			classes += ' oum-section-field--compact';
		}

		if (type === 'textarea' || type === 'svg') {
			content = '<textarea class="' + (type === 'svg' ? 'oum-code-field' : '') + '" name="' + base + '" rows="' + (type === 'svg' ? '7' : '4') + '"></textarea>';
			if (type === 'svg') {
				content += '<small class="description">Paste inline SVG code. Script/event attributes are stripped when saved.</small>';
			}
		} else if (type === 'select') {
			content = '<select name="' + base + '">' + Object.keys(field.choices || {}).map(function (value) {
				return '<option value="' + escapeHtml(value) + '">' + escapeHtml(field.choices[value]) + '</option>';
			}).join('') + '</select>';
		} else if (type === 'checkbox') {
			content = '<input type="checkbox" name="' + base + '" value="1">';
		} else if (type === 'media') {
			content = '<input type="hidden" name="' + base + '" value="" data-oum-media-input><button type="button" class="button" data-oum-media-button>Choose image</button> <button type="button" class="button-link" data-oum-media-clear>Remove</button><span class="oum-media-preview" data-oum-media-preview></span>';
		} else if (type === 'repeater') {
			content = repeaterMarkup(sectionIndex, key, field);
		} else {
			content = '<input type="' + (type === 'url' ? 'url' : 'text') + '" name="' + base + '" value="">';
			if (type === 'url') {
				content += '<button type="button" class="button button-secondary oum-link-picker-button" data-oum-link-picker>Choose link</button>';
			}
		}

		return '<div class="' + classes + '" data-oum-field-key="' + escapeHtml(key) + '" data-oum-field-type="' + escapeHtml(type) + '"><label><span>' + escapeHtml(field.label || key) + '</span>' + content + '</label></div>';
	}

	function repeaterItemMarkup(sectionIndex, repeaterKey, itemIndex, fields) {
		var prefix = sectionIndex + '][' + repeaterKey + '][' + itemIndex;

		return '<div class="oum-repeater__item" data-oum-repeater-item><button type="button" class="button-link-delete" data-oum-repeater-remove>Remove item</button><div class="oum-section-fields-grid">' + Object.keys(fields).map(function (key) {
			return fieldMarkup(prefix, key, fields[key]);
		}).join('') + '</div></div>';
	}

	function createSectionPanel(sectionIndex, type) {
		var data = getData();
		var fields = data.fields[type] || {};
		var title = data.types[type] || 'New Section';
		var normal = [];
		var advanced = [];

		Object.keys(fields).forEach(function (key) {
			var markup = fieldMarkup(sectionIndex, key, fields[key]);

			if (isAdvancedKey(key)) {
				advanced.push(markup);
			} else {
				normal.push(markup);
			}
		});

		return '<div class="oum-section-panel" data-oum-section><div class="oum-section-panel__header"><strong>' + escapeHtml(title) + '</strong><div><button type="button" class="button-link" data-oum-move-up>Up</button> <button type="button" class="button-link" data-oum-move-down>Down</button> <button type="button" class="button-link" data-oum-toggle>Collapse</button> <button type="button" class="button-link-delete" data-oum-remove>Remove</button></div></div><div class="oum-section-panel__body"><input type="hidden" name="oum_sections[' + sectionIndex + '][type]" value="' + escapeHtml(type) + '"><input type="hidden" name="oum_sections[' + sectionIndex + '][id]" value="oum_' + sectionIndex + '"><div class="oum-section-fields-grid" data-oum-fields-grid>' + normal.join('') + '</div><div class="oum-section-advanced-toggle-wrap"><button type="button" class="button button-secondary oum-section-advanced-toggle" data-oum-advanced-toggle aria-expanded="false">Advanced options</button></div><div class="oum-section-advanced" data-oum-advanced hidden><div class="oum-section-fields-grid oum-section-fields-grid--advanced">' + advanced.join('') + '</div></div></div></div>';
	}

	function bindLinkPicker(root) {
		root.querySelectorAll('[data-oum-link-picker]').forEach(function (button) {
			if (button.dataset.oumBound) {
				return;
			}

			button.dataset.oumBound = '1';
			button.addEventListener('click', function () {
				var field = button.closest('.oum-section-field') || button.closest('label');
				var input = field ? field.querySelector('input[type="url"], input[type="text"]') : null;

				if (!input || !window.wpLink) {
					return;
				}

				window.wpActiveEditor = true;
				window.wpLink.open('oum-link-picker');
				window.wpLink.textarea = input;
			});
		});
	}

	function bind(builder) {
		var list = builder.querySelector('[data-oum-sections-list]');
		var select = builder.querySelector('[data-oum-section-type]');
		var add = builder.querySelector('[data-oum-add-section]');

		if (!list || !select || !add) {
			return;
		}

		add.addEventListener('click', function () {
			var type = select.value;
			var sectionIndex = Date.now();

			list.insertAdjacentHTML('beforeend', createSectionPanel(sectionIndex, type));
			media(list);
			bindLinkPicker(list);
			updateIconVisibility(list);
		});

		builder.addEventListener('click', function (event) {
			var section = event.target.closest('[data-oum-section]');

			if (event.target.matches('[data-oum-remove]') && section) {
				section.remove();
			}

			if (event.target.matches('[data-oum-toggle]') && section) {
				section.classList.toggle('is-collapsed');
			}

			if (event.target.matches('[data-oum-advanced-toggle]') && section) {
				var advanced = section.querySelector('[data-oum-advanced]');
				var expanded = event.target.getAttribute('aria-expanded') === 'true';

				if (advanced) {
					advanced.hidden = expanded;
					event.target.setAttribute('aria-expanded', expanded ? 'false' : 'true');
					event.target.textContent = expanded ? 'Advanced options' : 'Hide advanced options';
				}
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
				var repeater = event.target.closest('[data-oum-repeater]');
				var panel = event.target.closest('[data-oum-section]');
				var typeInput = panel.querySelector('input[name$="[type]"]');
				var match = typeInput.name.match(/oum_sections\[([^\]]+)\]/);
				var sectionIndex = match ? match[1] : Date.now();
				var repeaterKey = repeater.dataset.oumRepeater;
				var fields = repeater.dataset.oumRepeaterFields ? JSON.parse(decodeURIComponent(repeater.dataset.oumRepeaterFields)) : {};
				var itemIndex = Date.now();

				repeater.querySelector('[data-oum-repeater-items]').insertAdjacentHTML('beforeend', repeaterItemMarkup(sectionIndex, repeaterKey, itemIndex, fields));
				media(repeater);
				bindLinkPicker(repeater);
				updateIconVisibility(repeater);
			}
		});

		builder.addEventListener('change', function (event) {
			if (event.target.matches('.oum-section-field[data-oum-field-key="icon_type"] select')) {
				updateSingleIconGroup(event.target);
			}
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		media(document);
		bindLinkPicker(document);
		document.querySelectorAll('[data-oum-sections-builder]').forEach(bind);
		updateIconVisibility(document);
	});
})();
