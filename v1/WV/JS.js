function myFunction(elementName) {
    /* Get the text field */
    var
        copyText = document.getElementById(elementName);

    /* Select the text field */
    copyText.select();

    /* Copy the text inside the text field */
    document.execCommand('copy');

    /* Alert the copied text */
    alert('Copied the text: ' + copyText.value);
}

function getGiftCodes() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            createTable(JSON.parse(this.responseText));
        }
    };
    xhttp.open("GET", "../getGiftCodes", true);
    xhttp.send();

}

function createTable(giftData) {

    if (giftData[0]['empty'] === 1) {
        var element = document.body.getElementsByTagName("table")[0];
        document.body.removeChild(element);
        element = document.body.getElementsByTagName("h5")[0];
        document.body.removeChild(element);
    }
    else {
        var table = document.getElementById('giftCodesTable');
        var txtCounter = document.getElementById('counter');
        txtCounter.innerHTML = giftData[0]['counter'];
        for (var i = 0; i < giftData.length; i++) {

            var row = document.createElement("TR");
            var col1 = document.createElement("TD");
            col1.appendChild(document.createTextNode(giftData[i]['giftCode']))
            row.appendChild(col1);
            var col2 = document.createElement("TD");
            col2.appendChild(document.createTextNode(giftData[i]['counter']))
            row.appendChild(col2);
            table.appendChild(row);
        }
    }

}