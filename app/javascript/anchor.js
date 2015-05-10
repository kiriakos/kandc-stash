// Makes the display scroll to an anchor on load
//

(function(){
    function scrollTo(hash) {
        location.hash = "#" + hash;
    }

    $(scrollTo("asset"));
})();