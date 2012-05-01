App.Services = (function(lng, app, undefined) {

    var comicSurferApi = "http://localhost/api/";

    //To-Do
    var getComicsList = function(){

    };

    //Get the pages from a comic
    var getComicPages = function(id_comic){

        $$.get(comicSurferApi+'get_json_pages.php',{
                comic_id: id_comic
            },
            function(response){
                var pages = [];

                for (var index = 0; index < response.length; index++){
                    //Add pages to database
                    pages[index] = {};
                    pages[index].idComic = id_comic;
                    pages[index].idPage = response[index].id;
                    pages[index].fileName = response[index].image;
                    pages[index].pageOrder = response[index].order;
                    
                }

                //Save to database
                App.Data.cacheComicPages(pages);

                //Call the first page to show
                lng.Data.Sql.select('pages',{idComic:id_comic},function(result){
                    
                    if(result.length > 0){
                        globalIdPage = result[0].idPage;
                        getVignettes(result[0].idPage);

                    }
                    
                });
                

            }
            );

    };

    //Get the vignetts of a specific page of a comic
    var getVignettes = function(id_page) {

    		$$.get(comicSurferApi+'get_json_vignettes.php',{
    			page_id: id_page
    		},
    		function(response){
    			var vignettes = [];

                for (var index = 0; index < response.length; index++){
                    //Add pages to database
                   response[index].idPage = id_page;
                   response[index].vignetteOrder = response[index].order;


                   //Add pages to database
                    vignettes[index] = {};
                    vignettes[index].idPage = id_page;
                    vignettes[index].sound = (response[index].sound)?response[index].sound : "false";
                    vignettes[index].x1 = response[index].x1;
                    vignettes[index].x2 = response[index].x2;
                    vignettes[index].y1 = response[index].y1;
                    vignettes[index].y2 = response[index].y2;
                }

                //Cache vignettes page
                App.Data.cachePageVignettes(vignettes);

                //Display the comic page
                App.View.loadComicNavigation(id_page);

    		}
    		);
   
	}


    return {
        getComicPages:getComicPages,
    	getVignettes:getVignettes

    }

})(LUNGO, App);