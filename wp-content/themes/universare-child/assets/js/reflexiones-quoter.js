(function () {
	'use strict';

	var data = window.universareReflexiones || {};
	var quotes = Array.isArray(data.quotes) ? data.quotes : [];
	var instagramUrl = typeof data.instagramUrl === 'string' ? data.instagramUrl : 'https://www.instagram.com/universare/';
	var currentIndex = -1;

	var quoteEl = document.getElementById('reflexiones-quote');
	var attributionEl = document.getElementById('reflexiones-attribution');
	var newBtn = document.getElementById('reflexiones-new');
	var whatsappLink = document.getElementById('reflexiones-whatsapp');
	var instagramLink = document.getElementById('reflexiones-instagram');

	if (!quoteEl || !attributionEl || quotes.length === 0) {
		return;
	}

	function formatAttribution(quote) {
		if (quote.book && quote.author) {
			return quote.book + ' — ' + quote.author;
		}
		if (quote.book) {
			return quote.book;
		}
		return quote.author || '';
	}

	function formatShareText(quote) {
		return '"' + quote.phrase + '" — ' + formatAttribution(quote);
	}

	function randomIndex(avoid) {
		if (quotes.length <= 1) {
			return 0;
		}

		var index;
		do {
			index = Math.floor(Math.random() * quotes.length);
		} while (typeof avoid === 'number' && index === avoid);

		return index;
	}

	function render(index) {
		var quote = quotes[index];
		if (!quote) {
			return;
		}

		currentIndex = index;
		quoteEl.textContent = quote.phrase;
		attributionEl.textContent = formatAttribution(quote);

		if (whatsappLink) {
			whatsappLink.href =
				'https://wa.me/?text=' + encodeURIComponent(formatShareText(quote));
		}

		if (instagramLink) {
			instagramLink.href = instagramUrl;
		}
	}

	if (newBtn) {
		newBtn.addEventListener('click', function () {
			render(randomIndex(currentIndex));
		});
	}

	render(randomIndex());
})();
