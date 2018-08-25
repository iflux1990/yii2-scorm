$(document).ready(function(){
    $('button').on('click',function(){
        var myid = $(this).attr('id');
        var url = "http://localhost:8080/scorm/"+ myid +"/index.html";
        //$("#frame").attr("src", url);
        window.open(url,"_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=400, height=400");
    })
})