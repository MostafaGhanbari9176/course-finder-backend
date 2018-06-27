<html>
<head>
    <script>
        function myFunction(elementName) {
            /* Get the text field */
            var copyText = document.getElementById(elementName);

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        }
    </script>

    <link><link rel="stylesheet" type="text/css" href="style.css">
</head>
<body >

<table style="width:100%">
    <tr style="direction:inherit ">
        <th>کد هدیه</th>
        <th>تعداد باقی مانده</th>
    </tr>
    <tr style="margin: 20px">
        <td><input type="text" value="abcd" id="myInput1">
            <button onclick="myFunction('myInput1')">Copy text</button></td>
        <td>20</td>

    </tr>
    <tr >
        <td ><input type="text" value="fetr97" id="myInput2">
            <button onclick="myFunction('myInput2')">Copy text</button></td>
        <td>10</td>
    </tr>
</table>


</body>
</html>