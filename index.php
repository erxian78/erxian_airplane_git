<?php

$redirect = false;
    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['HTTPS'] != "on") {
            $redirect = true;
        }
    } else {
        $redirect = true;
    }
    if ($redirect) {
        header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css" type="text/css" />
    <title>main_page</title>
</head>
<body>
<noscript>
    Please enable JavaScript

    <style>
        #reservation {
            display: none;
        }
    </style>
</noscript>

<div id="reservation">
    <div class="header">
        <h2>Welcome to seat-reservation system</h2>
    </div>
    <div class="nav">
        <div>
            <p id="welcome">Please sign in!</p>
            <a id="login"  href="add_user.html">Login</a>
        </div>
    </div>
    <div class="operations">
        <div style="text-align: left;">
            <p><span class="color-info" style="background: #66bb6a;"></span><span>free</span></p>
            <p><span class="color-info" style="background: #ef5350;"></span>purchased</p>
            <p><span class="color-info" style="background: #ffee58;"></span>reserved</p>
            <p><span class="color-info" style="background: #ffa726;"></span>reserved by others</p>
        </div>
        <button onclick="buySeat()">Buy</button>
        <button onclick="Update()">Update</button>
    </div>
</div>

<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript"> 
    let self_reserve_cnt = 0;
    let current_user_id=0;
    let m = 11;
    let n = 7;
    $(function(){
        if (!areCookiesEnabled()) {
            return;
        }

        $.get("seat.php", function (data) {
            let allResults = JSON.parse(data);
            console.log(allResults);
            if (allResults.timeout) {
                alert("timeout for the user!");
                window.location.href = "add_user.html";
                return;
            }
            let seatResults = allResults.results;
            let user_id = allResults.user_id;
            current_user_id = allResults.currentUserId;
            let seatString = "<table border=\"0\"><tr><td width=\"50px\" align=\"center\"></td>";
            for(let i = 0;i < n - 1;i ++)
            {
                seatString += "<td width=\"50px\" align=\"center\">";
                let column = String.fromCharCode(65+i);
                seatString += column;
                seatString += "</td>";
            }
            for(let i = 1;i < m;i ++)
            {
                seatString += "<tr align=\"center\">";
                seatString += "<td width=\"50px\">" + i + "</td>";
                for(let j = 1;j < n;j ++){
                    let color;
                    let cursor = "pointer";
                    let currentIndex = (i - 1) * (n-1) + j - 1;
                    switch (seatResults[currentIndex]) {
                        case "free":
                            color = "#66bb6a";
                            break;
                        case "purchase":
                            color = "#ef5350";
                            cursor = "not-allowed";
                            break;
                        case "reserved":
                            color = "#ffee58";
                            self_reserve_cnt ++;
                            break;
                    }
                    //座位已经被别人reserved
                    if(allResults.currentUserId != user_id[currentIndex] && user_id[currentIndex] > 0 && seatResults[currentIndex] != "purchase") {
                        color = "#ffa726";
                        self_reserve_cnt --;
                        //cursor = "not-allowed";
                    }
                    if(seatResults[currentIndex]){
                        seatString += "<td width=\"50px\" height=\"30px\" style='cursor: " + cursor + "' bgcolor=" + color + " class='seat' id=" + i + "-" + j +"-"+allResults.currentUserId+ " onclick='reserveSeat(this)'></td>";
                    }
                }
                seatString += "</tr>";
            }
            seatString += "</table>";
            $("#reservation").append(seatString);
            let infoString = "<div class='info'><p>The total number of seats:&nbsp;<span>" + seatResults.length  + "</span></p>";
            infoString += "<p>The total number of purchased:&nbsp;<span>" + allResults.purchase + "</span></p>";
            infoString += "<p>The total number of reserved:&nbsp;<span>" + allResults.reserved + "</span></p>";
            infoString += "<p>The total number of free:&nbsp;<span>" + allResults.free + "</span></p></div>";
            $("#reservation").append(infoString);
            if(allResults.currentUser) {
                //从起始位置到终止位置的内容, 但它去除Html标签
                $("#welcome")[0].innerText = "Welcome\n " + allResults.currentUser;
                $("#login").remove();
                $(".nav").append("<a id=\"logout\" onclick=\"logout()\" href=\"javascript:void(0);\">Logout</a>");

            }
        });
    });

    logout = () => {
        current_user_id = null;
        $("#welcome")[0].innerText = "Please sign in!\n" ;
        $("#logout").remove();
        $(".nav").append("<a id=\"login\" href=\"add_user.html\">Login</a>");
        $.ajax(
            {
                url:"clear-session.php",
                type:'POST',
            }
        )
        window.location.href="index.php";
    };

    reserveSeat = (self) => {
        if (current_user_id == null) {
            alert("Please log in first!");
            return;
        }
        let row = self.id.split('-')[0];
        let column = self.id.split('-')[1];
        let user_id = self.id.split('-')[2];
        let bgColor = $(`#${self.id}`)[0].bgColor;
        if (bgColor === '#ef5350'){
            return;
        }
        $.ajax({
            url: "update-seat.php",
            type: 'POST',
            data: { row: row, column: column, user_id: user_id , status: "reserved",bgColor: bgColor},
            success: function (data) {
                console.log(data);
                if(data === 'error'){
                    alert("Sorry, this seat has been purchased or reserved by others");
                    $(`#${self.id}`)[0].bgColor = '#ef5350';
                    cursor = "not-allowed";
                } else if (data === 'success') {
                    const reserveCount = parseInt($('.info > p > span')[2].innerText);
                    const freeCount = parseInt($('.info > p > span')[3].innerText);
                    if(bgColor == '#ffee58') {
                        alert("free the seat successfully");
                        self_reserve_cnt --;
                        $(`#${self.id}`)[0].bgColor = '#66bb6a';
                        $('.info > p > span')[2].innerText = reserveCount - 1;
                        $('.info > p > span')[3].innerText = freeCount + 1;

                    }
                    else if(bgColor == '#ffa726' ){
                        alert("reserve the seat successfully");
                        self_reserve_cnt ++;
                        $(`#${self.id}`)[0].bgColor = '#ffee58';
                       // $('.info > p > span')[2].innerText = reserveCount + 1;
                        // $('.info > p > span')[3].innerText = freeCount - 1;
                    }
                    else{
                        alert("reserve the seat successfully");
                        self_reserve_cnt ++;
                        $(`#${self.id}`)[0].bgColor = '#ffee58';
                        $('.info > p > span')[2].innerText = reserveCount + 1;
                        $('.info > p > span')[3].innerText = freeCount - 1;
                    }
                }
                else if (data==='orange'){
                    alert("free the seat successfully,but other has reserved it");
                    $(`#${self.id}`)[0].bgColor = '#ffa726';
                }else if (data === 'timeout') {
                    alert("timeout for the user!");
                    window.location.href="add_user.html";
                }
            },
            error: function (error) {
                alert("Sorry, system has occured some error");
            }

        });
    }

    buySeat = () => {
        if(current_user_id==null)
        {
            alert("Please log in first!");
            return;
        }
        if(self_reserve_cnt == 0){
            alert("Please select the seat you want to reserve first!");
            return;
        }
        $.ajax({
            url:"buy-seat.php",
            type: 'POST',
            data: { user_id: current_user_id,  reserved_num: self_reserve_cnt},
            success: function (data) {
                if(data === 'error'){
                    alert("buying request has been rejected!");
                   // window.location.href = 'main.php';
                }
                else if (data === 'success') {
                    alert("buying success！");
                    //window.location.href = 'main.php';
                }
                else if(data === 'buying_by_other')
                {
                    alert("Sorry,the seat your want to buy has been occupied by others!");
                }
                else if(data === 'timeout')
                {
                    alert("timeout for the user!");
                    windows.location.href='add_user.html';
                    return;
                }
                window.location.href = 'index.php';
            },
            error: function (error) {
                alert("Sorry, system has occured some error");
                window.location.href='index.php';
            }
        });
    }
    Update=()=>{
        if(current_user_id==null)
        {
            alert("Please log in first!");
            return;
        }
        window.location.href="index.php";
    }

</script>
<script type="text/javascript" defer>checkCookies()</script>
</body>
</html>