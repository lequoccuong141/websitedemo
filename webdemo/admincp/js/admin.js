$(document).ready(function() {
    var searchInput = $('#search-input');
    var searchResults = $('#search-results');
    var searchIcon = $('.search-icon');
    var searchLoader = $('.search-loader');
    var searchTimeout;

    searchInput.on('input', function() {
        var keyword = $(this).val().trim();
        clearTimeout(searchTimeout);

        if (keyword.length >= 1) {
            searchTimeout = setTimeout(function() {
                searchIcon.hide();
                searchLoader.show();

                $.ajax({
                    url: 'pages/main/timkiem_ajax.php',
                    method: 'GET',
                    data: { keyword: keyword },
                    success: function(data) {
                        var results = JSON.parse(data);
                        var html = '<ul class="search-suggestions">';
                        
                        if (results.length > 0) {
                            results.forEach(function(item) {
                                html += '<li class="search-item" data-id="' + item.id + '">';
                                html += '<img src="admincp/modules/quanlysp/uploads/' + item.image + '" class="search-item-image" onerror="this.src=\'images/no-image.png\'">';
                                html += '<span class="search-item-name">' + item.name + '</span>';
                                html += '</li>';
                            });
                        } else {
                            html += '<li class="search-item no-results">Không tìm thấy sản phẩm nào</li>';
                        }
                        
                        html += '</ul>';
                        searchResults.html(html).fadeIn(200);
                    },
                    complete: function() {
                        searchLoader.hide();
                        searchIcon.show();
                    }
                });
            }, 300);
        } else {
            searchResults.fadeOut(200);
        }
    });

    $(document).on('click', '.search-item', function() {
        if (!$(this).hasClass('no-results')) {
            var productId = $(this).data('id');
            window.location.href = 'index.php?quanly=sanpham&id=' + productId;
        }
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#search-container').length) {
            searchResults.fadeOut(200);
        }
    });

    searchInput.on('focus', function() {
        if ($(this).val().trim().length > 0) {
            searchResults.fadeIn(200);
        }
    });
});