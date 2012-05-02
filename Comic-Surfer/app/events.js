App.Events = (function(lng, app, undefined) {

    lng.ready(function() {
        //lng.View.Aside.show('#comicMainView', '#aside-menu');
        
        
    });
    
    lng.dom('#pageDisplayer').swipeLeft(function(event) {
    	console.log("left");

	    App.View.moveVignet(1);
	});

	lng.dom('#pageDisplayer').swipeRight(function(event) {
    	console.log("right");

	    App.View.moveVignet(-1);
	});

	lng.dom('#aside-menu a').tap(function(event){
		//Reset current item selected
		$$('#aside-menu a').removeClass('current');
		$$(this).addClass('current');

		
		if($$(this).hasClass("comicBook")){
			//Ask the API for the pages of this comic
		var id_comic = $$(this).attr('id').split('-');

		//Load the comic pages
		App.Services.getComicPages(id_comic[1]);
		
		}
		

		//Close aside
		lng.View.Aside.hide('#comicMainView', '#aside-menu');

	});

	//whe the user taps the access button form the login form
	lng.dom('#btnLogin').tap(function(event){
		//App.Services.getComicPages(1);
	});


    return {

    };

})(LUNGO, App);