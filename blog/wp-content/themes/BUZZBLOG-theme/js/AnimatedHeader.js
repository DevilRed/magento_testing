if(/Android|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){}else{var cbpAnimatedHeader=function(){function i(){if(!window.addEventListener){window.attachEvent("onscroll",function(e){if(!n){n=true;setTimeout(s,200)}})}else{window.addEventListener("scroll",function(e){if(!n){n=true;setTimeout(s,200)}},false)}}function s(){var e=o();if(e>=r){classie.add(t,"cbp-af-header-shrink")}else{classie.remove(t,"cbp-af-header-shrink")}n=false}function o(){return window.pageYOffset||e.scrollTop}var e=document.documentElement,t=document.querySelector(".header"),n=false,r=40;i()}()}