// Makes the display scroll to an anchor on load
//

function scrollTo(hash) {
    location.hash = "#" + hash;
}

$(scrollTo("asset"));