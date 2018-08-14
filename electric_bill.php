<link href="http://140.125.33.33/wp-includes/css/style.css" rel="stylesheet" type="text/css">
<center>
<h1 id="show_tim" style="margin:30px 0px;"></h1>
    <ul style="display:inline;">
            <li style="display:inline;">
                    <select class="tex" id="Year" onload="year_init();"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Month"></select>
            </li>
            <li style="display:inline;">
                    <input class="btn  btn-dark" id="sear" type="button" value="Search" onclick="_search()">
            </li>
    </ul>
    <hr style="width:600px;">
</center>
<table style="width:100%;">
    <div id="show_section" style="padding-top:10px;">
            <h1>Electric Bill</h1>
            <hr style="width:60px;" align="left">
            <div id="bill_container" style="width:100%; height:auto; padding-bottom:80px;" align="center">
                    <div id="bill_div" style="width:80%; height:auto; padding-top:50px;">
                    </div>
            </div>
    </div>
</table>
