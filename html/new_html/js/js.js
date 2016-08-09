// JavaScript Document
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var html = document.documentElement;
        var windowWidth = html.clientWidth;
		if(windowWidth > 750) windowWidth = 750/2;
        html.style.fontSize = windowWidth / 7.5 + 'px';
    }, false);
})();
