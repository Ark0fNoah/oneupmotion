(function () {
	'use strict';

	//───────────────────────────────────────
	// Helpers
	//───────────────────────────────────────
	function getField(tool, name) {
		return tool.querySelector('[name="' + name + '"]');
	}

	function getValue(tool, name) {
		const field = getField(tool, name);
		return field ? field.value.trim() : '';
	}

	function setText(element, value, fallback) {
		if (element) {
			element.textContent = value || fallback || '';
		}
	}

	function normalizeUrl(value) {
		if (!value) {
			return '';
		}

		try {
			return new URL(value).toString();
		} catch (error) {
			try {
				return new URL('https://' + value.replace(/^\/+/, '')).toString();
			} catch (secondError) {
				return value;
			}
		}
	}

	function getDomain(value) {
		const normalized = normalizeUrl(value);

		try {
			return new URL(normalized).hostname.replace(/^www\./, '');
		} catch (error) {
			return 'oneupmotion.com';
		}
	}

	function escapeHtml(value) {
		return String(value || '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	}

	function fileToDataUrl(file) {
		return new Promise(function (resolve) {
			if (!file) {
				resolve('');
				return;
			}

			const reader = new FileReader();

			reader.onload = function () {
				resolve(reader.result || '');
			};

			reader.onerror = function () {
				resolve('');
			};

			reader.readAsDataURL(file);
		});
	}

	function setMessage(tool, text, isError) {
		const message = tool.querySelector('[data-oneup-og-message]');
		if (!message) {
			return;
		}

		message.textContent = text || '';
		message.classList.toggle('is-error', !!isError);
	}

	function updateCounter(tool, name, ideal) {
		const field = getField(tool, name);
		const counter = tool.querySelector('[data-oneup-counter="' + name + '"]');

		if (!field || !counter) {
			return;
		}

		const length = field.value.trim().length;
		counter.textContent = length + '/' + ideal;
		counter.classList.toggle('is-warning', length > ideal);
	}

	function buildMetaTags(data) {
		const title = escapeHtml(data.title);
		const description = escapeHtml(data.description);
		const url = escapeHtml(data.url);
		const image = escapeHtml(data.image);
		const site = escapeHtml(data.site);

		return [
			'<meta property="og:title" content="' + title + '">',
			'<meta property="og:description" content="' + description + '">',
			'<meta property="og:url" content="' + url + '">',
			'<meta property="og:site_name" content="' + site + '">',
			'<meta property="og:type" content="website">',
			image ? '<meta property="og:image" content="' + image + '">' : '',
			'<meta name="twitter:card" content="summary_large_image">',
			'<meta name="twitter:title" content="' + title + '">',
			'<meta name="twitter:description" content="' + description + '">',
			image ? '<meta name="twitter:image" content="' + image + '">' : ''
		].filter(Boolean).join('\n');
	}

	//───────────────────────────────────────
	// Preview update
	//───────────────────────────────────────
	async function updatePreview(tool) {
		const url = normalizeUrl(getValue(tool, 'oneup_og_url'));
		const title = getValue(tool, 'oneup_og_title') || 'Your page title appears here';
		const description = getValue(tool, 'oneup_og_description') || 'Your description appears here. Keep it clear, specific and easy to understand.';
		const site = getValue(tool, 'oneup_og_site') || 'OneUp Motion';
		const imageUrl = getValue(tool, 'oneup_og_image_url');
		const imageFile = getField(tool, 'oneup_og_image_file');
		const imageData = imageFile && imageFile.files && imageFile.files[0] ? await fileToDataUrl(imageFile.files[0]) : '';
		const image = imageData || imageUrl;
		const card = tool.querySelector('[data-oneup-og-card]');
		const imagePreview = tool.querySelector('[data-oneup-og-image]');
		const tags = getField(tool, 'oneup_og_tags');
		const data = {
			url: url || 'https://oneupmotion.com',
			title: title,
			description: description,
			site: site,
			image: image
		};

		setText(tool.querySelector('[data-oneup-og-preview-title]'), title, '');
		setText(tool.querySelector('[data-oneup-og-preview-description]'), description, '');
		setText(tool.querySelector('[data-oneup-og-site]'), site, '');
		setText(tool.querySelector('[data-oneup-og-domain]'), getDomain(url), 'oneupmotion.com');

		if (imagePreview) {
			imagePreview.style.backgroundImage = image ? 'url("' + image.replace(/"/g, '%22') + '")' : '';
			imagePreview.classList.toggle('has-image', !!image);
			imagePreview.innerHTML = image ? '' : '<span>Social image preview</span>';
		}

		if (tags) {
			tags.value = buildMetaTags(data);
		}

		updateCounter(tool, 'oneup_og_title', 60);
		updateCounter(tool, 'oneup_og_description', 160);

		if (card) {
			card.dataset.platform = card.dataset.platform || 'linkedin';
		}
	}

	//───────────────────────────────────────
	// Bind tool
	//───────────────────────────────────────
	function bindTool(tool) {
		const card = tool.querySelector('[data-oneup-og-card]');
		const tags = getField(tool, 'oneup_og_tags');
		let updateTimer = null;

		function scheduleUpdate() {
			clearTimeout(updateTimer);
			updateTimer = setTimeout(function () {
				updatePreview(tool);
			}, 120);
		}

		tool.querySelectorAll('input, textarea').forEach(function (field) {
			field.addEventListener('input', scheduleUpdate);
			field.addEventListener('change', scheduleUpdate);
		});

		tool.querySelectorAll('[data-oneup-og-platform]').forEach(function (button) {
			button.addEventListener('click', function () {
				const platform = button.dataset.oneupOgPlatform || 'linkedin';

				tool.querySelectorAll('[data-oneup-og-platform]').forEach(function (item) {
					item.classList.toggle('is-active', item === button);
				});

				if (card) {
					card.className = 'oneup-og-card oneup-og-card--' + platform;
					card.dataset.platform = platform;
				}

				updatePreview(tool);
			});
		});

		const copyTags = tool.querySelector('[data-oneup-og-copy-tags]');
		if (copyTags) {
			copyTags.addEventListener('click', async function () {
				await updatePreview(tool);

				if (!tags || !tags.value) {
					return;
				}

				try {
					await navigator.clipboard.writeText(tags.value);
					setMessage(tool, 'Meta tags copied.', false);
				} catch (error) {
					tags.focus();
					tags.select();
					document.execCommand('copy');
					setMessage(tool, 'Meta tags copied.', false);
				}
			});
		}

		const copySummary = tool.querySelector('[data-oneup-og-copy-summary]');
		if (copySummary) {
			copySummary.addEventListener('click', async function () {
				await updatePreview(tool);

				const summary = [
					'Title: ' + (getValue(tool, 'oneup_og_title') || 'Your page title appears here'),
					'Description: ' + (getValue(tool, 'oneup_og_description') || 'Your description appears here.'),
					'URL: ' + (normalizeUrl(getValue(tool, 'oneup_og_url')) || 'https://oneupmotion.com'),
					'Image: ' + (getValue(tool, 'oneup_og_image_url') || 'No image URL')
				].join('\n');

				try {
					await navigator.clipboard.writeText(summary);
					setMessage(tool, 'Preview summary copied.', false);
				} catch (error) {
					setMessage(tool, 'Could not copy automatically. Please copy the text manually.', true);
				}
			});
		}

		const clearButton = tool.querySelector('[data-oneup-og-clear]');
		if (clearButton) {
			clearButton.addEventListener('click', function () {
				tool.querySelectorAll('input[type="text"], input[type="url"], textarea').forEach(function (field) {
					field.value = '';
				});

				const fileField = getField(tool, 'oneup_og_image_file');
				if (fileField) {
					fileField.value = '';
				}

				setMessage(tool, '', false);
				updatePreview(tool);
			});
		}

		updatePreview(tool);
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('[data-oneup-og-preview]').forEach(bindTool);
	});
})();
