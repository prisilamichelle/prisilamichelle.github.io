function newAjax() {
    let ajax;
    try {
        // Opera 8.0+, Firefox, Safari 
        ajax = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Sorry, your browser does not support AJAX.");
                return false;
            }
        }
    }
    return ajax;
}

function requestPost(url, data=null, success=null, error=defaultOnError) {
    let ajax = newAjax();
    setOnReadyStateChange(ajax, success, error);
    ajax.open('POST', url, true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
    return ajax;
}

function defaultOnError(status) {
    console.log("AJAX error with status " + status);
}

function setOnReadyStateChange(ajax, success, error) {
    ajax.onreadystatechange = function() {
        if (this.readyState == 4) {
            let response = null;
            try {
                response = JSON.parse(this.responseText);
            } catch (e) {
                response = this.responseText;
            }
            if (this.status == 200) {
                success(response);
            } else {
                error(this.status, response);
            }
        }
     }
}