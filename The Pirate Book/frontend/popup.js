var popup = function () {

    var backendURL = 'http://192.168.3.65:8080/torrent-server/torrentHub/search?bookTitle=';
    var noBooksFoundMessage = 'No torrents were found for this book';

    function showNoBooksFoundMessage() {
        var message = "<div class='row-fluid'>" + noBooksFoundMessage + "</div>";
        $("#books").append(message);
    }

    function appendBook(url, title) {
        var bookLink = "<div class='span11'><a href='" + url + "' target='_blank'><i class='icon-circle-arrow-down'></i> " + title + "</a></div>";
        var recommendLink = "<div class='span1'><a href='#' class='btn'><i class='icon-thumbs-up'></i></a></div>";
        var book = "<div class='row-fluid'>" + bookLink + recommendLink + "</div>";
        $("#books").append(book);
    }

    function getLinksFor(bookTitle) {
        $.getJSON(backendURL + bookTitle, function (data) {
            if (data.torrents.length == 0) {
                showNoBooksFoundMessage()
            }
            $.each(data.torrents, function (key, val) {
                appendBook(val.torrent.url, val.torrent.title);
            });
            $("#loading").hide();
        });
    }

    var showBooks = function () {
        chrome.tabs.getSelected(null, function (tab) {
            var bookTitle = localStorage[tab.id];
            getLinksFor(bookTitle);
        });
    }

    return {
        showBooks:showBooks
    }
}();

popup.showBooks();