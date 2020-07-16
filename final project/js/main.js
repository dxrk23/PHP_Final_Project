$(document).ready(function () {

    $("#logout").click(function () {
        $.ajax({
            url:"loginLogic.php",
            type: "POST",
            data: {
                "destroy" : "true",
            },
            success: function (data) {
                let ans = JSON.parse(data);
                location.reload();
                console.log(ans.mes);
            }
        });
    });

    $("#more").click(function () {
        window.location.href = "news.php";
    });

    $("#login").click(function () {
        window.location.href = "login.php";
    });

    $(".readmoreNews").click(function () {
        alert("We do not finished it yet!");
    });
    $("#addBtn1").click(function () {
        $.ajax({
            url:"addDis.php",
            type: "POST",
            data:{
                "branch" : "tech" ,
                "title" : $("#topicName1").val(),
            } ,
            success : function (data) {
                location.reload();
                console.log("added");
            }
        });
    });
    $("#addBtn2").click(function () {
        $.ajax({
            url:"addDis.php",
            type: "POST",
            data:{
                "branch" : "flud" ,
                "title" : $("#topicName2").val(),
            } ,
            success : function (data) {
                location.reload();
                console.log("added");
            }
        });
    });





});