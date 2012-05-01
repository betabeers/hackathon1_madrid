App.View = (function(lng, app, undefined) {

    //var vignettes = [{"x1":"9","x2":"231","y1":"9","y2":"240"},{"x1":"223","x2":"408","y1":"9","y2":"240","sound":"../assets/sounds/tortuga.mp3"},{"x1":"400","x2":"595","y1":"10","y2":"236"},{"x1":"25","x2":"156","y1":"245","y2":"447"},{"x1":"145","x2":"264","y1":"245","y2":"447"},{"x1":"0","x2":"608","y1":"234","y2":"561"},{"x1":"12","x2":"220","y1":"544","y2":"840"},{"x1":"218","x2":"398","y1":"539","y2":"840"},{"x1":"398","x2":"592","y1":"556","y2":"842"}];
    var vignettes = [];
    var width = document.body.clientWidth;
    var height = document.body.clientHeight;
    var pos = 0;
    var landscape = false;

	var loadComicNavigation = function(id_page) {
		lng.Data.Sql.select('pages',{idPage:globalIdPage},function(resultPage){
            if (resultPage.length > 0) {
                lng.Data.Sql.select('vignettes',{idPage:globalIdPage},function(resultVignette){
		            if (resultVignette.length > 0) {
		                var pageImage = resultPage[0].fileName;
                        $$('#pageDisplayer').style('background','transparent no-repeat url(api/pages/'+pageImage+')');
                        vignettes = resultVignette;
                        
                        //Center the first vignett
                        moveVignet(0);


		            }
                    else{
                        //We dont have the vignetted for this page
                        App.Services.getVignettes(globalIdPage);
                        //Center the first vignett
                        moveVignet(-1);
                    }
            	});
    		}
   	 });
	}	


    var moveVignet = function (toPos){
        console.log("pos:"+pos);
        console.log("toPos:"+toPos);

        
        //Load next Page
        if(toPos>0 && pos==vignettes.length -1){
            if(globalIdPage == 3){
                alert('End of Comic\n Thank you for reading');
                return;
            }
            loadComicNavigation(++globalIdPage);
            pos = 0;
        }

        if(toPos<0 && pos==0){
            if(globalIdPage == 1)return;
            loadComicNavigation(--globalIdPage);
            pos=0;
        }

        pos += toPos;
        //this.classList.toggle("scale");
        //alert(this.style.backgroundPositionX);
        console.log(vignettes);
        console.log("pos:"+pos);

        var x = vignettes[pos].x1;
        var y = vignettes[pos].y1;
        var w = vignettes[pos].x2 - x;
        var h = vignettes[pos].y2 - y;
        var sound = vignettes[pos].sound;

        var scale = Math.min(width / w , height / h);
        scale = scale.toFixed(2);
        /*
        if((landscape && scale >1) || ( !landscape && scale < 1)){
            var aux = w;
            w=h;
            h=aux;
        }
        */
        var newX = -x + (width-w)/2;
        var newY = -y + (height-h)/2 - 10;

        $$('#pageDisplayer').style('background-position-x', newX+'px');
        $$('#pageDisplayer').style('background-position-y', newY+'px');

        
        console.log("newX:"+newX+" newY:"+newY+" scale:"+scale);
        //this.style.webkitTransform = "scale(1)";
        if(scale<1) scale=1.00;
        if (scale>2) scale=2.00;
        var oldScale = $$('#pageDisplayer').style('-webkit-transform');
            
            if(oldScale!="none") oldScale = oldScale.substr(6,oldScale.length-7);
            console.log("oldScale:"+oldScale);
            if(oldScale=="none" || Math.abs(scale-oldScale)>0.2){
                setTimeout(function(){
                    $$('#pageDisplayer').style('-webkit-transform',"scale("+scale+")");
                }, 500);
            }
        
        /*
        if(scale<1){
            landscape = !landscape;
            scale = Math.min(width / w , height / h);
            $$('#pageDisplayer').style('-webkit-transform',"rotate(-90deg) scale("+scale+")");
        }else{
            $$('#pageDisplayer').style('-webkit-transform',"scale("+scale+")");
        }
        */
        if(sound && sound != "false"){
                    $$("#audio").attr("src", "../api/sounds/"+sound);
                    //setTimeout(function(){
                        
                        var miaudio = document.getElementById("audio");
                        //console.log("miaudio"+miaudio);
                        miaudio.play();
                        //console.log(sound);
                        //audio.src = sound;
                        //audio.play();
                    //}, 500);
                }   
    };



    return{
    	loadComicNavigation:loadComicNavigation,
        moveVignet:moveVignet

    }

})(LUNGO, App);