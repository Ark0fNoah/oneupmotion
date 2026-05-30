(function () {
	'use strict';

	//───────────────────────────────────────
	// Utility helpers
	//───────────────────────────────────────
	function getField(tool, name) {
		return tool.querySelector('[name="' + name + '"]');
	}

	function getValue(tool, name) {
		const field = getField(tool, name);
		return field ? field.value.trim() : '';
	}

	function isChecked(tool, name) {
		const field = getField(tool, name);
		return field ? field.checked : false;
	}

	function normalizeValue(value, format, lowercase) {
		let normalized = String(value || '').trim();

		if (lowercase) {
			normalized = normalized.toLowerCase();
		}

		if (format === 'underscore') {
			normalized = normalized.replace(/\s+/g, '_');
		} else if (format === 'plus') {
			normalized = normalized.replace(/\s+/g, '+');
		} else if (format === 'encoded') {
			normalized = normalized.replace(/\s+/g, '%20');
		} else {
			normalized = normalized.replace(/\s+/g, '-');
		}

		return normalized;
	}

	function createUrl(baseUrl, preserveExisting) {
		const trimmed = String(baseUrl || '').trim();

		if (!trimmed) {
			return null;
		}

		try {
			return new URL(trimmed);
		} catch (error) {
			try {
				return new URL('https://' + trimmed.replace(/^\/+/, ''));
			} catch (secondError) {
				return null;
			}
		}
	}

	function setMessage(tool, text, isError) {
		const message = tool.querySelector('[data-oneup-utm-message]');
		if (!message) {
			return;
		}

		message.textContent = text || '';
		message.classList.toggle('is-error', !!isError);
	}

	function downloadText(filename, content) {
		const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
		const link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = filename;
		document.body.appendChild(link);
		link.click();
		URL.revokeObjectURL(link.href);
		link.remove();
	}

	//───────────────────────────────────────
	// Build UTM URL
	//───────────────────────────────────────
	function buildUrl(tool) {
		const result = getField(tool, 'oneup_utm_result');
		const copyButton = tool.querySelector('[data-oneup-utm-copy]');
		const openButton = tool.querySelector('[data-oneup-utm-open]');
		const downloadButton = tool.querySelector('[data-oneup-utm-download]');
		const format = getValue(tool, 'oneup_utm_space_format') || 'dash';
		const lowercase = isChecked(tool, 'oneup_utm_lowercase');
		const preserveExisting = isChecked(tool, 'oneup_utm_preserve_existing');
		const url = createUrl(getValue(tool, 'oneup_utm_url'), preserveExisting);

		if (!url) {
			if (result) {
				result.value = '';
			}

			[copyButton, openButton, downloadButton].forEach(function (button) {
				if (button) {
					button.disabled = true;
				}
			});

			const hasInput = !!getValue(tool, 'oneup_utm_url');
			setMessage(tool, hasInput ? 'Enter a valid website URL.' : '', hasInput);
			return '';
		}

		if (!preserveExisting) {
			url.search = '';
		}

		const parameters = [
			'utm_source',
			'utm_medium',
			'utm_campaign',
			'utm_id',
			'utm_term',
			'utm_content',
			'utm_creative_format',
			'utm_marketing_tactic'
		];

		parameters.forEach(function (name) {
			const rawValue = getValue(tool, name);

			if (!rawValue) {
				return;
			}

			url.searchParams.set(name, normalizeValue(rawValue, format, lowercase));
		});

		const generated = url.toString();

		if (result) {
			result.value = generated;
		}

		[copyButton, openButton, downloadButton].forEach(function (button) {
			if (button) {
				button.disabled = !generated;
			}
		});

		setMessage(tool, generated ? 'UTM link generated automatically.' : '', false);
		return generated;
	}

	//───────────────────────────────────────
	// Bind UTM builder
	//───────────────────────────────────────
	function bindTool(tool) {
		const result = getField(tool, 'oneup_utm_result');
		const copyButton = tool.querySelector('[data-oneup-utm-copy]');
		const openButton = tool.querySelector('[data-oneup-utm-open]');
		const downloadButton = tool.querySelector('[data-oneup-utm-download]');
		const clearButton = tool.querySelector('[data-oneup-utm-clear]');

		tool.querySelectorAll('input, select').forEach(function (field) {
			field.addEventListener('input', function () {
				buildUrl(tool);
			});

			field.addEventListener('change', function () {
				buildUrl(tool);
			});
		});

		if (copyButton) {
			copyButton.addEventListener('click', async function () {
				const generated = result ? result.value : '';

				if (!generated) {
					return;
				}

				try {
					await navigator.clipboard.writeText(generated);
					setMessage(tool, 'Copied to clipboard.', false);
				} catch (error) {
					result.focus();
					result.select();
					document.execCommand('copy');
					setMessage(tool, 'Copied to clipboard.', false);
				}
			});
		}

		if (openButton) {
			openButton.addEventListener('click', function () {
				const generated = result ? result.value : '';

				if (generated) {
					window.open(generated, '_blank', 'noopener,noreferrer');
				}
			});
		}

		if (downloadButton) {
			downloadButton.addEventListener('click', function () {
				const generated = result ? result.value : '';

				if (generated) {
					downloadText('oneup-utm-url.txt', generated + '\n');
				}
			});
		}

		if (clearButton) {
			clearButton.addEventListener('click', function () {
				tool.querySelectorAll('input[type="text"], input[type="url"], textarea').forEach(function (field) {
					field.value = '';
				});

				buildUrl(tool);
				setMessage(tool, '', false);
			});
		}

		buildUrl(tool);
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('[data-oneup-utm-generator]').forEach(bindTool);
	});
})();
