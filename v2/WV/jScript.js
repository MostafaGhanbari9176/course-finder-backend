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

    console.log(giftData);
    if (giftData[0]['empty'] === 1 || giftData[0]['state'] === 0) {
        var element = document.body.getElementsByTagName("div")[0];
        document.body.removeChild(element);
    }
    else {
        var txtCounter = document.getElementById('count');
        var txtCode = document.getElementById('code');
        txtCounter.innerHTML = giftData[0]['counter'];
        txtCode.innerHTML = giftData[0]['giftCode'];

    }
}