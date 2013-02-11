// country
$().ready(function() {
        $("#countryTerritory").autocomplete("../get_country_list.php", {
            width: 260,
            matchContains: true,
            //mustMatch: true,
            //minChars: 0,
            //multiple: true,
            //highlight: false,
            //multipleSeparator: ",",
            selectFirst: false
        });
});

// frecuency textfield
function setFreq(str) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("txtFreq").value=xmlhttp.responseText;
        }
    }
xmlhttp.open("GET","../get_freq.php?q="+str,true);
xmlhttp.send();
}
