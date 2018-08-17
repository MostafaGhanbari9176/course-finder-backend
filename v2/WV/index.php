<?php

$userApi = $_REQUEST['ac'];
if (!($userApi == "123"))
    echo publicPage();

function publicPage()
{

    return "  <html>
<head >
    <link rel = 'stylesheet' type = 'text/css' href = 'cStyle.css' />
    <script src = \"jScript.js\" ></script >

</head >
<body >
<div class='card'>

<h1 id='header'>هدیه</h1>


<h4 id='giftCode'>کدهدیه : <span id ='code'></span></h4>
<h2 id='message'>فقط <span id ='count'></span> نفر دیگر می توانند از این کد هدیه استفاده کنند</h2>
</div>
<script> getGiftCodes()</script>
</body >
</html >";
}

