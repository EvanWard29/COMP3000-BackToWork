$(function(){
    let page = window.location.pathname;
    if(page !== "/MobileFamilyPlanner/public/login.php" && page !== "/MobileFamilyPlanner/public/registration.php") {
        let userID = getCookie('userID');
        if (userID === "") {
            location.replace('/MobileFamilyPlanner/public/login.php');
        }
    }
});

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}