(function () {
	'use strict';

	function normalizeDotShape(shape) {
		if ('dot' === shape) {
			return 'dots';
		}

		if ('extra-rounded' === shape) {
			return 'extra-rounded';
		}

		if ('classy' === shape) {
			return 'classy';
		}

		if ('classy-rounded' === shape) {
			return 'classy-rounded';
		}

		if ('rounded' === shape) {
			return 'rounded';
		}

		return 'square';
	}

	function normalizeCornerSquareShape(shape) {
		if ('dot' === shape) {
			return 'dot';
		}

		if ('rounded' === shape || 'extra-rounded' === shape) {
			return 'extra-rounded';
		}

		return 'square';
	}

	function normalizeCornerDotShape(shape) {
		return 'dot' === shape ? 'dot' : 'square';
	}

	function normalizeFrameStyle(value) {
		const allowed = ['none', 'rounded-card', 'label', 'label-top', 'button-bottom', 'comment-box', 'ticket', 'phone', 'polaroid', 'double-border'];
		return allowed.indexOf(value) !== -1 ? value : 'none';
	}

	function applyFrame(preview, frameStyle) {
		if (!preview) {
			return;
		}

		preview.className = preview.className
			.split(' ')
			.filter(function (className) {
				return className.indexOf('oneup-qr__preview--frame-') !== 0;
			})
			.join(' ');

		preview.classList.add('oneup-qr__preview--frame-' + normalizeFrameStyle(frameStyle));
	}

	function getValue(root, selector, fallback) {
		const element = root.querySelector(selector);

		return element ? element.value : fallback;
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

	function setMessage(messageElement, message, isError) {
		if (!messageElement) {
			return;
		}

		messageElement.textContent = message || '';
		messageElement.classList.toggle('is-error', !!isError);
	}

	function clearPreview(preview) {
		if (!preview) {
			return;
		}

		preview.innerHTML = '<span>QR preview</span>';
		preview.classList.remove('is-generated');
	}

	function styleGeneratedCanvas(preview) {
		if (!preview) {
			return;
		}

		const canvas = preview.querySelector('canvas');
		const svg = preview.querySelector('svg');

		[canvas, svg].forEach(function (element) {
			if (!element) {
				return;
			}

			element.style.display = 'block';
			element.style.height = 'auto';
			element.style.maxWidth = '100%';
			element.style.width = '100%';
		});
	}


	function hexToRgb(color) {
		const context = document.createElement('canvas').getContext('2d');
		context.fillStyle = color || '#ffffff';
		const normalized = context.fillStyle;
		const match = normalized.match(/^#([0-9a-f]{6})$/i);

		if (!match) {
			return { r: 255, g: 255, b: 255 };
		}

		return {
			r: parseInt(match[1].slice(0, 2), 16),
			g: parseInt(match[1].slice(2, 4), 16),
			b: parseInt(match[1].slice(4, 6), 16)
		};
	}

	function roundedRect(ctx, x, y, width, height, radius) {
		const r = Math.min(radius, width / 2, height / 2);
		ctx.beginPath();
		ctx.moveTo(x + r, y);
		ctx.arcTo(x + width, y, x + width, y + height, r);
		ctx.arcTo(x + width, y + height, x, y + height, r);
		ctx.arcTo(x, y + height, x, y, r);
		ctx.arcTo(x, y, x + width, y, r);
		ctx.closePath();
	}

	function downloadDataUrl(filename, dataUrl) {
		const link = document.createElement('a');
		link.href = dataUrl;
		link.download = filename;
		document.body.appendChild(link);
		link.click();
		link.remove();
	}

	function downloadQrWithFrame(tool, preview) {
		const qrCanvas = preview ? preview.querySelector('canvas') : null;

		if (!qrCanvas) {
			return false;
		}

		const frameStyle = getValue(tool, '[name="oneup_qr_frame_style"]', tool.dataset.defaultFrame || 'none');
		const frameColor = getValue(tool, '[name="oneup_qr_frame_color"]', '#ffffff');
		const frameTextColor = getValue(tool, '[name="oneup_qr_frame_text_color"]', '#001f3d');
		const frameText = getValue(tool, '[name="oneup_qr_frame_text"]', 'SCAN ME');
		const qrSize = 1200;
		const padding = frameStyle === 'none' ? 60 : 110;
		const labelSpace = (frameStyle === 'label' || frameStyle === 'label-top' || frameStyle === 'polaroid') ? 170 : ((frameStyle === 'button-bottom' || frameStyle === 'comment-box') ? 260 : 0);
		const canvas = document.createElement('canvas');
		const ctx = canvas.getContext('2d');
		const totalWidth = qrSize + padding * 2;
		const totalHeight = qrSize + padding * 2 + labelSpace;

		canvas.width = totalWidth;
		canvas.height = totalHeight;

		ctx.clearRect(0, 0, canvas.width, canvas.height);

		const qrX = padding;
		const qrY = frameStyle === 'label-top' ? padding + labelSpace : padding;
		const qrFrameRadius = 54;

		if (frameStyle === 'button-bottom' || frameStyle === 'comment-box') {
			ctx.fillStyle = frameColor;
			roundedRect(ctx, qrX, qrY, qrSize, qrSize, qrFrameRadius);
			ctx.fill();
		} else if (frameStyle === 'none') {
			ctx.fillStyle = frameColor;
			roundedRect(ctx, 0, 0, canvas.width, canvas.height, 36);
			ctx.fill();
		} else if (frameStyle === 'phone') {
			ctx.fillStyle = '#061426';
			roundedRect(ctx, 0, 0, canvas.width, canvas.height, 120);
			ctx.fill();
			ctx.fillStyle = frameColor;
			roundedRect(ctx, padding * 0.65, padding * 0.65, canvas.width - padding * 1.3, canvas.height - padding * 1.3, 70);
			ctx.fill();
		} else if (frameStyle === 'ticket') {
			ctx.fillStyle = frameColor;
			roundedRect(ctx, 0, 0, canvas.width, canvas.height, 24);
			ctx.fill();
			ctx.globalCompositeOperation = 'destination-out';
			ctx.beginPath();
			ctx.arc(0, canvas.height / 2, 52, 0, Math.PI * 2);
			ctx.arc(canvas.width, canvas.height / 2, 52, 0, Math.PI * 2);
			ctx.fill();
			ctx.globalCompositeOperation = 'source-over';
		} else if (frameStyle === 'double-border') {
			ctx.fillStyle = frameColor;
			roundedRect(ctx, 0, 0, canvas.width, canvas.height, 54);
			ctx.fill();
			ctx.strokeStyle = frameTextColor;
			ctx.lineWidth = 22;
			roundedRect(ctx, 44, 44, canvas.width - 88, canvas.height - 88, 34);
			ctx.stroke();
		} else {
			ctx.fillStyle = frameColor;
			roundedRect(ctx, 0, 0, canvas.width, canvas.height, 54);
			ctx.fill();
		}

		ctx.drawImage(qrCanvas, qrX, qrY, qrSize, qrSize);

		if (frameStyle === 'label' || frameStyle === 'label-top' || frameStyle === 'button-bottom' || frameStyle === 'comment-box') {
			ctx.font = '900 72px Arial, sans-serif';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';

			if (frameStyle === 'button-bottom') {
				const boxY = padding + qrSize + 95;
				ctx.fillStyle = frameColor;
				roundedRect(ctx, qrX, boxY, qrSize, 120, 60);
				ctx.fill();
				ctx.fillStyle = frameTextColor;
				ctx.fillText(frameText || 'SCAN ME', canvas.width / 2, boxY + 60);
			} else if (frameStyle === 'comment-box') {
				const boxY = padding + qrSize + 95;
				ctx.fillStyle = frameColor;
				roundedRect(ctx, qrX, boxY, qrSize, 135, 32);
				ctx.fill();
				ctx.beginPath();
				ctx.moveTo(canvas.width / 2 - 46, boxY);
				ctx.lineTo(canvas.width / 2, boxY - 42);
				ctx.lineTo(canvas.width / 2 + 46, boxY);
				ctx.closePath();
				ctx.fill();
				ctx.fillStyle = frameTextColor;
				ctx.fillText(frameText || 'SCAN ME', canvas.width / 2, boxY + 68);
			} else if (frameStyle === 'label-top') {
				ctx.fillStyle = frameTextColor;
				ctx.fillText(frameText || 'SCAN ME', canvas.width / 2, padding + Math.round(labelSpace * 0.48));
			} else {
				ctx.fillStyle = frameTextColor;
				ctx.fillText(frameText || 'SCAN ME', canvas.width / 2, padding + qrSize + Math.round(labelSpace * 0.48));
			}
		}

		downloadDataUrl('oneup-motion-qr.png', canvas.toDataURL('image/png'));
		return true;
	}


	function debounce(callback, delay) {
		let timer = null;

		return function () {
			clearTimeout(timer);
			timer = setTimeout(callback, delay);
		};
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('[data-oneup-qr-generator]').forEach(function (tool) {
			const button = tool.querySelector('[data-oneup-qr-generate]');
			const preview = tool.querySelector('[data-oneup-qr-preview]');
			const message = tool.querySelector('[data-oneup-qr-message]');
			const downloadButton = tool.querySelector('[data-oneup-qr-download]');
			const urlInput = tool.querySelector('[name="oneup_qr_url"]');
			const logoInput = tool.querySelector('[name="oneup_qr_logo"]');
			const frameInput = tool.querySelector('[name="oneup_qr_frame_style"]');
			let qrCode = null;
			let lastGenerated = false;

			if (!button || !preview) {
				return;
			}

			function getQrOptions(imageUrl) {
				const foreground = getValue(tool, '[name="oneup_qr_foreground"]', '#031a34');
				const background = getValue(tool, '[name="oneup_qr_background"]', '#ffffff');
				const blockShape = getValue(tool, '[name="oneup_qr_block_shape"]', 'rounded');
				const cornerShape = getValue(tool, '[name="oneup_qr_corner_shape"]', 'extra-rounded');
				const centerShape = getValue(tool, '[name="oneup_qr_center_shape"]', 'square');
				const logoSize = Math.max(0.08, Math.min(0.24, parseInt(getValue(tool, '[name="oneup_qr_logo_size"]', tool.dataset.defaultLogoSize || '18'), 10) / 100));
				const frameColor = getValue(tool, '[name="oneup_qr_frame_color"]', '#ffffff');
				const frameTextColor = getValue(tool, '[name="oneup_qr_frame_text_color"]', '#001f3d');
				const frameText = getValue(tool, '[name="oneup_qr_frame_text"]', 'SCAN ME');
				tool.style.setProperty('--oneup-qr-frame-color', frameColor);
				tool.style.setProperty('--oneup-qr-frame-text-color', frameTextColor);
				tool.style.setProperty('--oneup-qr-frame-text', '"' + frameText.replace(/"/g, '') + '"');

				return {
					width: 420,
					height: 420,
					type: 'canvas',
					data: (urlInput && urlInput.value.trim()) ? urlInput.value.trim() : 'https://oneupmotion.com',
					image: imageUrl || '',
					margin: 4,
					qrOptions: {
						typeNumber: 0,
						mode: 'Byte',
						errorCorrectionLevel: imageUrl ? 'H' : 'Q'
					},
					dotsOptions: {
						color: foreground,
						type: normalizeDotShape(blockShape)
					},
					backgroundOptions: {
						color: background
					},
					cornersSquareOptions: {
						color: foreground,
						type: normalizeCornerSquareShape(cornerShape)
					},
					cornersDotOptions: {
						color: foreground,
						type: normalizeCornerDotShape(centerShape)
					},
					imageOptions: {
						crossOrigin: 'anonymous',
						margin: 4,
						imageSize: logoSize,
						hideBackgroundDots: true
					}
				};
			}

			async function getLogoUrl() {
				const uploadedLogo = logoInput && logoInput.files && logoInput.files[0]
					? await fileToDataUrl(logoInput.files[0])
					: '';

				return uploadedLogo || tool.dataset.defaultLogo || '';
			}

			async function generate() {
				if (!window.QRCodeStyling) {
					clearPreview(preview);
					setMessage(message, 'The QR renderer could not be loaded. The CDN script may be blocked.', true);
					if (downloadButton) {
						downloadButton.disabled = true;
					}
					return;
				}

				const data = urlInput && urlInput.value.trim() ? urlInput.value.trim() : '';

				if (!data) {
					clearPreview(preview);
					setMessage(message, 'Enter a URL or text first.', true);
					if (downloadButton) {
						downloadButton.disabled = true;
					}
					return;
				}

				try {
					const logoUrl = await getLogoUrl();
					const options = getQrOptions(logoUrl);

					preview.innerHTML = '';
					qrCode = new window.QRCodeStyling(options);
					qrCode.append(preview);
					preview.classList.add('is-generated');
					styleGeneratedCanvas(preview);
					applyFrame(preview, getValue(tool, '[name="oneup_qr_frame_style"]', tool.dataset.defaultFrame || 'none'));
					tool.style.setProperty('--oneup-qr-frame-color', getValue(tool, '[name="oneup_qr_frame_color"]', '#ffffff'));
					tool.style.setProperty('--oneup-qr-frame-text-color', getValue(tool, '[name="oneup_qr_frame_text_color"]', '#001f3d'));
					tool.style.setProperty('--oneup-qr-frame-text', '"' + getValue(tool, '[name="oneup_qr_frame_text"]', 'SCAN ME').replace(/"/g, '') + '"');
					lastGenerated = true;

					setMessage(message, 'QR generated. Test it with your phone before using it in print.', false);

					if (downloadButton) {
						downloadButton.disabled = false;
					}
				} catch (error) {
					lastGenerated = false;
					clearPreview(preview);
					setMessage(message, error && error.message ? error.message : 'Could not generate this QR code.', true);

					if (downloadButton) {
						downloadButton.disabled = true;
					}
				}
			}


			const autoGenerate = debounce(function () {
				if (urlInput && urlInput.value.trim()) {
					generate();
				} else {
					lastGenerated = false;
					clearPreview(preview);
					setMessage(message, '', false);
					if (downloadButton) {
						downloadButton.disabled = true;
					}
				}
			}, 350);

			if (urlInput) {
				urlInput.addEventListener('input', autoGenerate);
			}


			tool.querySelectorAll('[data-oneup-design-tab]').forEach(function (tab) {
				tab.addEventListener('click', function () {
					const target = tab.dataset.oneupDesignTab;

					tool.querySelectorAll('[data-oneup-design-tab]').forEach(function (button) {
						button.classList.toggle('is-active', button === tab);
					});

					tool.querySelectorAll('[data-oneup-design-panel]').forEach(function (panel) {
						const active = panel.dataset.oneupDesignPanel === target;
						panel.hidden = !active;
						panel.classList.toggle('is-active', active);
					});
				});
			});

			tool.querySelectorAll('[data-oneup-frame-option]').forEach(function (option) {
				option.addEventListener('click', function () {
					if (frameInput) {
						frameInput.value = option.dataset.oneupFrameOption || 'none';
					}

					tool.querySelectorAll('[data-oneup-frame-option]').forEach(function (button) {
						button.classList.toggle('is-active', button === option);
					});

					if (preview) {
						applyFrame(preview, frameInput ? frameInput.value : 'none');
					}

					if (lastGenerated) {
						generate();
					}
				});
			});

			button.addEventListener('click', generate);

			if (downloadButton) {
				downloadButton.addEventListener('click', function () {
					if (!qrCode || !lastGenerated) {
						return;
					}

					if (downloadQrWithFrame(tool, preview)) {
						return;
					}

					qrCode.download({
						name: 'oneup-motion-qr',
						extension: 'png'
					});
				});
			}

			tool.querySelectorAll('input, select').forEach(function (input) {
				input.addEventListener('change', function () {
					tool.style.setProperty('--oneup-qr-frame-color', getValue(tool, '[name="oneup_qr_frame_color"]', '#ffffff'));
					tool.style.setProperty('--oneup-qr-frame-text-color', getValue(tool, '[name="oneup_qr_frame_text_color"]', '#001f3d'));
					tool.style.setProperty('--oneup-qr-frame-text', '"' + getValue(tool, '[name="oneup_qr_frame_text"]', 'SCAN ME').replace(/"/g, '') + '"');

					if (lastGenerated || (urlInput && urlInput.value.trim())) {
						generate();
					}
				});
			});
		});
	});
})();
