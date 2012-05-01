App.Data = (function(lng, app, undefined) {

    lng.Data.Sql.init({
    	name: 'comicSurfer-cache',
    	version:'1.0',
    	schema:[{
    		name:'comics',
    		drop:true,
    		fields:{
    			idComic: "INT",
				comicName: "STRING"

    		}
    	},
    	{
    		name:'pages',
    		drop:true,
    		fields:{
    			idPage: "INT",
				idComic: "INT",
				fileName: "STRING",
				pageOrder: "INT"
    		}
    	},
        {
            name:'vignettes',
            drop:true,
            fields:{
                idPage: "INT",
                sound:"STRING",
                x1: "INT",
                x2: "INT",
                y1: "INT",
                y2: "INT"
            }
        }
    	]

    });

    var cachePageVignettes = function(vignettes){
        lng.Data.Sql.insert('vignettes',vignettes); 

    };

    var cacheComicPages = function(pages){
        lng.Data.Sql.insert('pages',pages); 

    };

    return {
        cachePageVignettes:cachePageVignettes,
        cacheComicPages:cacheComicPages
    }

})(LUNGO, App);