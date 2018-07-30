<link href="http://140.125.33.33/wp-includes/css/style.css" rel="stylesheet" type="text/css">
<center>
<h1 id="show_tim" style="margin:30px 0px;"></h1>
    <ul style="display:inline;">
            <li style="display:inline;">
                    <select class="tex" id="Year1" onchange="month_init(1)" onload="year_init();"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Month1" onchange="day_init(1)"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Day1"></select>
            </li>
            <li style="display:inline;">
                    <span> ~</span>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Year2" onchange="month_init(2)"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Month2" onchange="day_init(2)"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="Day2"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="_id" style="margin:0px 5px;"></select>
            </li>
            <li style="display:inline;">
                    <select class="tex" id="_type" style="margin:0px 5px;">
                            <option value="0" selected="selected">Power usage</option>
                    </select>
            </li>
            <li style="display:inline;">
                    <input class="btn" id="sear" type="button" value="Search" onclick="_search()">
            </li>
    </ul>
    <hr style="width:600px;">
</center>
<table style="width:100%;">
    <div id="show_section" style="padding-top:10px;">
            <h1>Chart</h1>
            <hr style="width:60px;" align="left">
            <div id="chart_container" style="width:100%; height:auto; padding-bottom:80px;" align="center">
                    <div id="chart_div" style="width:80%; height:auto; padding-top:50px;">
                    </div>
            </div>
    </div>
</table>
