(function () {
	'use strict';

	var data = window.universareReflexiones || {};
	var quotes = Array.isArray(data.quotes) ? data.quotes : [];
	var currentIndex = typeof data.initialIndex === 'number' ? data.initialIndex : 0;

	var quoteEl = document.getElementById('reflexiones-quote');
	var attributionEl = document.getElementById('reflexiones-attribution');
	var newBtn = document.getElementById('reflexiones-new');
	var whatsappLink = document.getElementById('reflexiones-whatsapp');
	var twitterLink = document.getElementById('reflexiones-twitter');

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
		} while (index === avoid);

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

		if (twitterLink) {
			twitterLink.href =
				'https://twitter.com/intent/tweet?text=' +
				encodeURIComponent(formatShareText(quote) + ' @universare #Universare');
		}
	}

	if (newBtn) {
		newBtn.addEventListener('click', function () {
			render(randomIndex(currentIndex));
		});
	}

	render(currentIndex);
})();
