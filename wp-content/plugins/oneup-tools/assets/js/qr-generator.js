(function () {
	'use strict';

	const VERSIONS = [
		null,
		{ size: 21, data: 19, ecc: 7, align: [] },
		{ size: 25, data: 34, ecc: 10, align: [6, 18] },
		{ size: 29, data: 55, ecc: 15, align: [6, 22] },
		{ size: 33, data: 80, ecc: 20, align: [6, 26] },
		{ size: 37, data: 108, ecc: 26, align: [6, 30] }
	];

	const MASKS = [
		(r, c) => (r + c) % 2 === 0,
		(r) => r % 2 === 0,
		(r, c) => c % 3 === 0,
		(r, c) => (r + c) % 3 === 0,
		(r, c) => (Math.floor(r / 2) + Math.floor(c / 3)) % 2 === 0,
		(r, c) => ((r * c) % 2) + ((r * c) % 3) === 0,
		(r, c) => (((r * c) % 2) + ((r * c) % 3)) % 2 === 0,
		(r, c) => (((r + c) % 2) + ((r * c) % 3)) % 2 === 0
	];

	function bytesForText(text) {
		return Array.from(new TextEncoder().encode(text));
	}

	function chooseVersion(bytes) {
		for (let version = 1; version < VERSIONS.length; version++) {
			if (bytes.length + 2 <= VERSIONS[version].data) {
				return version;
			}
		}
		return null;
	}

	function appendBits(bits, value, length) {
		for (let i = length - 1; i >= 0; i--) {
			bits.push((value >>> i) & 1);
		}
	}

	function buildData(bytes, version) {
		const info = VERSIONS[version];
		const bits = [];
		appendBits(bits, 0x4, 4);
		appendBits(bits, bytes.length, 8);
		bytes.forEach((byte) => appendBits(bits, byte, 8));
		appendBits(bits, 0, Math.min(4, info.data * 8 - bits.length));
		while (bits.length % 8) {
			bits.push(0);
		}

		const data = [];
		for (let i = 0; i < bits.length; i += 8) {
			data.push(parseInt(bits.slice(i, i + 8).join(''), 2));
		}
		for (let pad = 0; data.length < info.data; pad++) {
			data.push(pad % 2 ? 0x11 : 0xec);
		}
		return data;
	}

	function gfTables() {
		const exp = new Array(512);
		const log = new Array(256);
		let value = 1;
		for (let i = 0; i < 255; i++) {
			exp[i] = value;
			log[value] = i;
			value <<= 1;
			if (value & 0x100) {
				value ^= 0x11d;
			}
		}
		for (let i = 255; i < 512; i++) {
			exp[i] = exp[i - 255];
		}
		return { exp, log };
	}

	const GF = gfTables();

	function gfMul(a, b) {
		return a && b ? GF.exp[GF.log[a] + GF.log[b]] : 0;
	}

	function generatorPoly(degree) {
		let poly = [1];
		for (let i = 0; i < degree; i++) {
			const next = new Array(poly.length + 1).fill(0);
			for (let j = 0; j < poly.length; j++) {
				next[j] ^= poly[j];
				next[j + 1] ^= gfMul(poly[j], GF.exp[i]);
			}
			poly = next;
		}
		return poly;
	}

	function reedSolomon(data, degree) {
		const gen = generatorPoly(degree);
		const ecc = new Array(degree).fill(0);
		data.forEach(function (byte) {
			const factor = byte ^ ecc.shift();
			ecc.push(0);
			for (let i = 0; i < degree; i++) {
				ecc[i] ^= gfMul(gen[i + 1], factor);
			}
		});
		return ecc;
	}

	function blankMatrix(size) {
		return {
			modules: Array.from({ length: size }, () => new Array(size).fill(false)),
			reserved: Array.from({ length: size }, () => new Array(size).fill(false))
		};
	}

	function setModule(matrix, r, c, value, reserve) {
		const size = matrix.modules.length;
		if (r < 0 || c < 0 || r >= size || c >= size) {
			return;
		}
		matrix.modules[r][c] = !!value;
		if (reserve) {
			matrix.reserved[r][c] = true;
		}
	}

	function drawFinder(matrix, row, col) {
		for (let r = -1; r <= 7; r++) {
			for (let c = -1; c <= 7; c++) {
				const rr = row + r;
				const cc = col + c;
				const dark = r >= 0 && r <= 6 && c >= 0 && c <= 6 && (r === 0 || r === 6 || c === 0 || c === 6 || (r >= 2 && r <= 4 && c >= 2 && c <= 4));
				setModule(matrix, rr, cc, dark, true);
			}
		}
	}

	function drawAlignment(matrix, center) {
		for (let r = -2; r <= 2; r++) {
			for (let c = -2; c <= 2; c++) {
				const dark = Math.max(Math.abs(r), Math.abs(c)) !== 1;
				setModule(matrix, center[0] + r, center[1] + c, dark, true);
			}
		}
	}

	function reserveFormat(matrix) {
		const size = matrix.modules.length;
		for (let i = 0; i < 9; i++) {
			if (i !== 6) {
				matrix.reserved[8][i] = true;
				matrix.reserved[i][8] = true;
			}
		}
		for (let i = 0; i < 8; i++) {
			matrix.reserved[8][size - 1 - i] = true;
			matrix.reserved[size - 1 - i][8] = true;
		}
	}

	function drawFunctionPatterns(version) {
		const info = VERSIONS[version];
		const matrix = blankMatrix(info.size);
		const size = info.size;
		drawFinder(matrix, 0, 0);
		drawFinder(matrix, 0, size - 7);
		drawFinder(matrix, size - 7, 0);

		for (let i = 8; i < size - 8; i++) {
			setModule(matrix, 6, i, i % 2 === 0, true);
			setModule(matrix, i, 6, i % 2 === 0, true);
		}

		if (info.align.length) {
			info.align.forEach((r) => info.align.forEach(function (c) {
				if (!((r === 6 && c === 6) || (r === 6 && c === size - 7) || (r === size - 7 && c === 6))) {
					drawAlignment(matrix, [r, c]);
				}
			}));
		}

		setModule(matrix, 4 * version + 9, 8, true, true);
		reserveFormat(matrix);
		return matrix;
	}

	function placeData(matrix, codewords, mask) {
		const size = matrix.modules.length;
		const bits = [];
		codewords.forEach((byte) => appendBits(bits, byte, 8));
		let bit = 0;
		let upward = true;
		for (let col = size - 1; col > 0; col -= 2) {
			if (col === 6) {
				col--;
			}
			for (let i = 0; i < size; i++) {
				const row = upward ? size - 1 - i : i;
				for (let offset = 0; offset < 2; offset++) {
					const c = col - offset;
					if (!matrix.reserved[row][c]) {
						const raw = bit < bits.length ? bits[bit++] === 1 : false;
						matrix.modules[row][c] = raw !== MASKS[mask](row, c);
					}
				}
			}
			upward = !upward;
		}
	}

	function formatBits(mask) {
		const data = (1 << 3) | mask;
		let bits = data << 10;
		for (let i = 14; i >= 10; i--) {
			if ((bits >>> i) & 1) {
				bits ^= 0x537 << (i - 10);
			}
		}
		return ((data << 10) | bits) ^ 0x5412;
	}

	function drawFormat(matrix, mask) {
		const bits = formatBits(mask);
		const size = matrix.modules.length;
		const get = (i) => ((bits >>> i) & 1) === 1;
		for (let i = 0; i <= 5; i++) setModule(matrix, 8, i, get(i), true);
		setModule(matrix, 8, 7, get(6), true);
		setModule(matrix, 8, 8, get(7), true);
		setModule(matrix, 7, 8, get(8), true);
		for (let i = 9; i < 15; i++) setModule(matrix, 14 - i, 8, get(i), true);
		for (let i = 0; i < 8; i++) setModule(matrix, size - 1 - i, 8, get(i), true);
		for (let i = 8; i < 15; i++) setModule(matrix, 8, size - 15 + i, get(i), true);
		setModule(matrix, size - 8, 8, true, true);
	}

	function penalty(modules) {
		const size = modules.length;
		let score = 0;
		function runPenalty(line) {
			let total = 0;
			let run = 1;
			for (let i = 1; i <= line.length; i++) {
				if (i < line.length && line[i] === line[i - 1]) {
					run++;
				} else {
					if (run >= 5) total += 3 + run - 5;
					run = 1;
				}
			}
			return total;
		}
		for (let r = 0; r < size; r++) score += runPenalty(modules[r]);
		for (let c = 0; c < size; c++) score += runPenalty(modules.map((row) => row[c]));
		for (let r = 0; r < size - 1; r++) {
			for (let c = 0; c < size - 1; c++) {
				const v = modules[r][c];
				if (modules[r][c + 1] === v && modules[r + 1][c] === v && modules[r + 1][c + 1] === v) score += 3;
			}
		}
		let dark = 0;
		modules.forEach((row) => row.forEach((v) => { if (v) dark++; }));
		score += Math.floor(Math.abs((dark * 100 / (size * size)) - 50) / 5) * 10;
		return score;
	}

	function makeMatrix(text) {
		const bytes = bytesForText(text);
		const version = chooseVersion(bytes);
		if (!version) {
			throw new Error('This QR generator supports up to about 100 characters for now. Shorten the URL or use a cleaner redirect link.');
		}
		const data = buildData(bytes, version);
		const ecc = reedSolomon(data, VERSIONS[version].ecc);
		const codewords = data.concat(ecc);
		let best = null;
		for (let mask = 0; mask < MASKS.length; mask++) {
			const matrix = drawFunctionPatterns(version);
			placeData(matrix, codewords, mask);
			drawFormat(matrix, mask);
			const score = penalty(matrix.modules);
			if (!best || score < best.score) {
				best = { modules: matrix.modules, score };
			}
		}
		return best.modules;
	}

	function inFinder(size, r, c) {
		return (r < 7 && c < 7) || (r < 7 && c >= size - 7) || (r >= size - 7 && c < 7);
	}

	function moduleSvg(x, y, shape, color) {
		if (shape === 'dot') {
			return '<circle cx="' + (x + 0.5) + '" cy="' + (y + 0.5) + '" r="0.42" fill="' + color + '"/>';
		}
		const radius = shape === 'rounded' ? '0.28' : '0';
		return '<rect x="' + x + '" y="' + y + '" width="1" height="1" rx="' + radius + '" fill="' + color + '"/>';
	}

	function renderSvg(modules, options) {
		const quiet = 4;
		const size = modules.length;
		const total = size + quiet * 2;
		let body = '<rect width="' + total + '" height="' + total + '" fill="' + options.background + '"/>';
		for (let r = 0; r < size; r++) {
			for (let c = 0; c < size; c++) {
				if (modules[r][c]) {
					body += moduleSvg(c + quiet, r + quiet, inFinder(size, r, c) ? options.cornerShape : options.blockShape, options.foreground);
				}
			}
		}
		if (options.logo) {
			const logoSize = Math.max(3, Math.round(size * (options.logoSize / 100)));
			const pos = (total - logoSize) / 2;
			body += '<rect x="' + (pos - 0.8) + '" y="' + (pos - 0.8) + '" width="' + (logoSize + 1.6) + '" height="' + (logoSize + 1.6) + '" rx="1.4" fill="' + options.background + '"/>';
			body += '<image href="' + options.logo + '" x="' + pos + '" y="' + pos + '" width="' + logoSize + '" height="' + logoSize + '" preserveAspectRatio="xMidYMid meet"/>';
		}
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' + total + ' ' + total + '" role="img" aria-label="Generated QR code">' + body + '</svg>';
	}

	function fileToDataUrl(file) {
		return new Promise(function (resolve) {
			if (!file) {
				resolve('');
				return;
			}
			const reader = new FileReader();
			reader.onload = () => resolve(reader.result || '');
			reader.readAsDataURL(file);
		});
	}

	function download(filename, content) {
		const blob = new Blob([content], { type: 'image/svg+xml;charset=utf-8' });
		const url = URL.createObjectURL(blob);
		const link = document.createElement('a');
		link.href = url;
		link.download = filename;
		document.body.appendChild(link);
		link.click();
		link.remove();
		URL.revokeObjectURL(url);
	}

	document.querySelectorAll('[data-oneup-qr-generator]').forEach(function (tool) {
		const button = tool.querySelector('[data-oneup-qr-generate]');
		const preview = tool.querySelector('[data-oneup-qr-preview]');
		const message = tool.querySelector('[data-oneup-qr-message]');
		const downloadButton = tool.querySelector('[data-oneup-qr-download]');
		const url = tool.querySelector('[name="oneup_qr_url"]');
		const foreground = tool.querySelector('[name="oneup_qr_foreground"]');
		const background = tool.querySelector('[name="oneup_qr_background"]');
		const blockShape = tool.querySelector('[name="oneup_qr_block_shape"]');
		const cornerShape = tool.querySelector('[name="oneup_qr_corner_shape"]');
		const logoInput = tool.querySelector('[name="oneup_qr_logo"]');
		const logoSize = tool.querySelector('[name="oneup_qr_logo_size"]');
		let currentSvg = '';

		async function generate() {
			const value = url.value.trim() || 'https://oneupmotion.com';
			try {
				const modules = makeMatrix(value);
				const uploadedLogo = logoInput && logoInput.files ? await fileToDataUrl(logoInput.files[0]) : '';
				const svg = renderSvg(modules, {
					foreground: foreground.value,
					background: background.value,
					blockShape: blockShape.value,
					cornerShape: cornerShape.value,
					logo: uploadedLogo || tool.dataset.defaultLogo || '',
					logoSize: parseInt(logoSize.value || tool.dataset.defaultLogoSize || '18', 10)
				});
				currentSvg = svg;
				preview.innerHTML = svg;
				preview.classList.add('is-generated');
				message.textContent = 'QR generated. Test it with your phone before publishing printed material.';
				downloadButton.disabled = false;
			} catch (error) {
				currentSvg = '';
				preview.innerHTML = '<span>QR preview</span>';
				message.textContent = error.message;
				downloadButton.disabled = true;
			}
		}

		if (button) {
			button.addEventListener('click', generate);
		}
		if (downloadButton) {
			downloadButton.addEventListener('click', function () {
				if (currentSvg) {
					download('oneup-qr-code.svg', currentSvg);
				}
			});
		}
	});
})();
