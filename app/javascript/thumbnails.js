// Javascript for thumbnails.php view

(function(){

    if(window.thumbnails === undefined){
        window.thumbnails = Object.create(null);
    }

    window.thumbnails.configure = function(id, url){
        
        var anchor = $('#' + id);
        var width = anchor.width();
        var imgElement = anchor.children('img'); //$('#' + id + ' img');
        anchor.height(width);
        var uri = url.replace(/{WIDTH}/g, width);
        nq.image(encodeURI(uri), imgElement);
        
        console.log(id,url,uri);
    };
})();