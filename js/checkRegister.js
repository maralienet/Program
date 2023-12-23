function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

function checkRegCookie() {
    let user = getCookie("id")
    if (user != "") {
        window.location.replace('../php/me.php')
    }
    else{
        window.location.replace('registration.php')
    }
  }