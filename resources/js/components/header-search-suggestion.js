$(document).on('input', '#search_text', function(e) {
    const viewUrl = $('#search_text').data('product-url');
    const searchInput = $('#search_text').val();
    const suggestionsContainer = document.getElementById('suggestionsContainer');
    const suggestionsList = document.getElementById('suggestionsList');
    if (searchInput != '') {
        $.ajax({
            url: $('#search_text').data('url'),
            type: 'get',
            data: {
                text: searchInput,
            },
            success: function(data) {
                displaySuggestions(data.html, viewUrl);
            },
        });
    } else {
        suggestionsList.innerHTML = '';
        suggestionsContainer.style.display = 'none';
    }

    function displaySuggestions(suggestions, viewUrl) {
        suggestionsList.innerHTML = '';
        if (Object.keys(suggestions).length > 0) {
            for (const productId in suggestions) {
                if (Object.prototype.hasOwnProperty.call(suggestions, productId)) {
                    const listItem = document.createElement('li');
                    const productLink = document.createElement('a');
                    productLink.textContent = suggestions[productId];
                    productLink.href = viewUrl + "?product_id=" + productId
                    productLink.classList.add("d-block");

                    listItem.appendChild(productLink);
                    suggestionsList.appendChild(listItem);
                }
            }
            suggestionsContainer.style.display = 'block';
        } else {
            suggestionsContainer.style.display = 'none';
        }
    }
});