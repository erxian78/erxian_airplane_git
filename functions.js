function areCookiesEnabled() {
    return navigator.cookieEnabled;
}

function checkCookies() {
    if (!areCookiesEnabled()) {
        document.body.innerHTML = "Please enable cookies. The application needs cookies to work.";
    }
}