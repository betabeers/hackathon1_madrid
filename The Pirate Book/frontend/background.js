chrome.extension.onRequest.addListener(
    function (request, sender, sendResponse) {
        localStorage[sender.tab.id] = request.bookTitle;
        chrome.pageAction.show(sender.tab.id);
    }
);

chrome.tabs.onRemoved.addListener(function (tabId, removeInfo) {
    delete localStorage[tabId];
});
