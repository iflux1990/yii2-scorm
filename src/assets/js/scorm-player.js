"use strict";

console.log()

document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById('yii2-scorm-go-button').addEventListener("click", function() {

        var url = "http://localhost:8080/scorm/"+ widgetId +"/index.html";
        //$("#frame").attr("src", url);
        window.open(url,"_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600");
    })
});