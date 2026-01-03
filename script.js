const loader = document.getElementById("loader-overlay");
const loginBox = document.getElementById("offload-block");
const offload = document.getElementById("offload-flex");

window.addEventListener("load", function () {
    loader.classList.add("fade-out");
    loginBox.style.display = "block";
    offload.style.display = "flex";

    // Wait for CSS transition to finish, then hide loader
    loader.addEventListener("transitionend", function () {
        loader.style.display = "none";
    }, { once: true });
});


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
    var showCurrent = document.getElementById("group"+y+"_round"+x);
    var prev = document.getElementById("group"+y+"_round"+(x-1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    prev.classList.add("show");
}


function moveTableNextGroup(y, x) {
    var showCurrent = document.getElementById("group"+y+"_round"+x);
    var next = document.getElementById("group"+y+"_round"+(x+1));
    
    showCurrent.classList.remove("show");
    showCurrent.classList.add("hidden");

    next.classList.add("show");
}

const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navLinks.classList.toggle("active");
});