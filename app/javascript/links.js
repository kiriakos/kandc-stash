// Listen for ALL links at the top level of the document. For
// testing purposes, we're not going to worry about LOCAL vs.
// EXTERNAL links - we'll just demonstrate the feature.
$( document ).on(
    "click",
    "a",
    function( event ){
 
        // Manually change the location of the page to stay in
        // "Standalone" mode and change the URL at the same time.
        var anchor = $( event.target );
        
        if(anchor.attr( "href" ) === undefined){
            anchor = anchor.parent("a");
        }
        
        if(anchor.attr( "target" ) !== "_blank"){
 
            // Stop the default behavior of the browser, which
            // is to change the URL of the page.
            event.preventDefault();
            location.href = anchor.attr( "href" );
        }
 
    }
);
