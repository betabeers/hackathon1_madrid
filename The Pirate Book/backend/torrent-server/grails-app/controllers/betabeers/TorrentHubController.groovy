package betabeers

import grails.converters.JSON


class TorrentHubController {

    def search() {
        def term = params.bookTitle
        def url = "http://www.mnova.eu/rss.php?search=$term&order=name".toURL()

        def torrentList = [torrents: []]

        if (url.text != 'No torrents where found!')
        {
            def torrents = parseUrl(url)
            def torrentsTruncated = torrents[0..maxResults(torrents)]

            torrentList.torrents = torrentsTruncated.collect { torrent ->
                [torrent: [title: torrent.title, url: torrent.url]]
            }
        }

        render torrentList as JSON
    }

    private parseUrl(url) {
        def xml = new XmlSlurper().parseText(url.text)
        def allItems = xml.channel.item.findAll { it.category == 'Books' }
        allItems.inject([]) { list, item ->
            list << new Torrent(title: item.title, url: item.enclosure.'@url')
        }
    }

    private maxResults(list) {
        final limit = 10
        Math.min(list.size() - 1, limit)
    }

}


class Torrent {
    String title
    String url

    String toString() {
        """Title: $title
          |URL: $url""".stripMargin()
    }
}
