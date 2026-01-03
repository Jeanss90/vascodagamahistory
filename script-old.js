M.AutoInit();

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems, options);
});


document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, options);
});

/* does not work correctly on ios iphone

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var options = {
        'yearRange': 50
    }
    var instances = M.Datepicker.init(elems, options);
});

*/


var audio = new Audio("/audio/hino.mp3");

function startMusic() {
    var mute = document.getElementById("audio");
    if (audio.paused || audio.ended) {
        mute.innerHTML = "volume_up";
        audio.currentTime = 0;
        audio.play();
    } else {
        mute.innerHTML = "volume_off";
        audio.pause();
    }
}


function modeHover() {
    var prev = document.getElementsByClassName("prev");
    var next = document.getElementsByClassName("next");

    for(let i = 0; i < prev.length; i++){
        if (i == 0) {
        } else {
            prev[i].style.cursor = "pointer";
        }
    }

    for(let i = 0; i < next.length; i++){
        if (i == 10) {
        } else {
            next[i].style.cursor = "pointer";    
        }
    }
}


function moveTablePrev(x) {
    var showCurrent = document.getElementById("round"+x);
    var prev = document.getElementById("round"+(x-1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    prev.classList.add("show");
}


function moveTableNext(x) {
    var showCurrent = document.getElementById("round"+x);
    var next = document.getElementById("round"+(x+1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    next.classList.add("show");
}

function moveTablePrevGroup(y, x) {
    var showCurrent = document.getElementById("group"+y+" round"+x);
    var prev = document.getElementById("group"+y+" round"+(x-1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    prev.classList.add("show");
}


function moveTableNextGroup(y, x) {
    var showCurrent = document.getElementById("group"+y+" round"+x);
    var next = document.getElementById("group"+y+" round"+(x+1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    next.classList.add("show");
}

function audioHover() {
    var audio = document.getElementById("audio");
    audio.style.cursor = "pointer"
}


setTimeout(() => {
    document.getElementsByClassName("preloader-wrapper active center")[0].style.visibility = "hidden";
    document.getElementsByClassName("preloader-wrapper active center")[0].style.display = "none";
    document.getElementsByClassName("game")[0].style.visibility = "visible";
    document.getElementsByClassName("game")[0].style.display = "flex";

    var x = window.matchMedia("screen and (max-width: 540px)");
    checkMedia(x);
    x.addListener(checkMedia);
    function checkMedia(x){

        if(x.matches){
            console.log('media-540px');
            document.getElementsByClassName("game")[0].style.display = "block";
        } else {
            console.log('normal-media');
            document.getElementsByClassName("game")[0].style.display = "flex";
        }
    }    
}, 5000);
