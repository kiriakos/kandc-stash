// Javascript for thumbnails.php view

(function(){

    if(window.thumbnails === undefined){
        window.thumbnails = Object.create(null);
    }

    window.thumbnails.configure = function(id, url){
        
        var anchor = $('#' + id);
        var imgElement = anchor.children('img'); //$('#' + id + ' img');
        var uri = url.replace(/{WIDTH}/g, Math.floor(anchor.parent().width()/5));
        nq.image(encodeURI(uri), imgElement);
        console.log.enable();
        console.log(id,uri);
        console.log.disable();
    };
})();