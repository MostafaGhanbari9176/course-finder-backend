<?php

$userApi = $_REQUEST['ac'];
if (!($userApi == "123"))
    echo publicPage();

function publicPage()
{

    return "  <html>
<head >
    <link rel = 'stylesheet' type = 'text/css' href = 'cssStyle.css' />
    <script src = \"JS.js\" ></script >

</head >
<body >
<h5 > هدیه ما به شما با وارد کردن کد زیر می توانید یک اشتراک هدیه داشته باشید فقط <span id = \"counter\" ></span > نفر دیگر می توانند از این هدیه استفاده کنند . </h5 >

<table id = \"giftCodesTable\" >
    <tr >
        <th > کد هدیه </th >
        <th > تعداد نفرات باقی مانده </th >
    </tr >
</table >
<script > getGiftCodes() </script >

</body >
</html >";
}

