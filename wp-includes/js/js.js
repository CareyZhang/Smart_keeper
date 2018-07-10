var init_count=0;
function init(upper,lower)
{
    var str="".concat(upper,",",lower);
    var socket = io.connect('http://140.125.33.31:8080');
    var result=socket.emit('Data',str);
        socket.on('Data',function(data){
	var time_arr=[]
	var usage_arr=[]
	for(var key in data)
	{
		time_arr.push(timeConverter(data[key]._time));
		usage_arr.push(data[key]._usage);
	}
	if(init_count==0)
	{
		draw_chart(upper,lower,time_arr,usage_arr);
	}
	init_count++;
    });
        var tim="".concat(timeConverter(lower),"~",timeConverter(upper));
        document.getElementById('show_tim').innerHTML=tim;
    year_init();
    month_init(1);
    month_init(2);
    day_init(1);
    day_init(2);
}

function draw_chart(upper,lower,time,usage)
{
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: time,
            datasets: [{
                label: "Power Usage",
                backgroundColor: 'rgb(100, 100, 255)',
                borderColor: 'rgb(240, 240, 240)',
                data: usage,
            }]
        },

        // Configuration options go here
        options: {}
    });
}

function _search()
{
    init_count=0;
    var year1 = document.getElementById('Year1').value
    var month1 = document.getElementById('Month1').value
    var day1 = document.getElementById('Day1').value
    var year2 = document.getElementById('Year2').value
    var month2 = document.getElementById('Month2').value
    var day2 = document.getElementById('Day2').value
    var tt1 = year1+'-'+month1+'-'+day1;
    var tt2 = year2+'-'+month2+'-'+day2;
    var lower = (new Date(tt1).getTime())/1000;
    var upper = (new Date(tt2).getTime())/1000;
    if(lower>upper)
    {
        var tmp=lower
        lower=upper
        upper=tmp
    }
    upper+=86400
    var tim="".concat(timeConverter(lower),"~",timeConverter(upper));
    document.getElementById('show_tim').innerHTML=tim;
    var str="".concat(upper,",",lower);
    var socket = io.connect('http://140.125.33.31:8080');
    var result=socket.emit('Data',str);
}

function year_init()
{
    var d=new Date();
    var y=d.getFullYear();
    var yy
    for(var i=y;i>=(y-10);i--)
    {
        if(i!=y)
        {
            yy=yy+"<option value='"+i+"'>"+i+"年</option>"
        }
        else
        {
            yy=yy+"<option value='"+i+"' selected='selected'>"+i+"年</option>"
        }
    }
    document.getElementById("Year1").innerHTML=yy;
    document.getElementById("Year2").innerHTML=yy;
}

function month_init(_id)
{
    var d=new Date();
    var m=d.getMonth()+1;
    document.getElementById("Month"+_id).style.display="inline";
    var mm
    for(var i=1;i<=12;i++)
    {
        if(m==i)
            mm=mm+"<option value='"+i+"' selected='selected'>"+i+"月</option>"
        else
            mm=mm+"<option value='"+i+"'>"+i+"月</option>"
    }
    document.getElementById("Month"+_id).innerHTML=mm;
}

function day_init(_id)
{
    document.getElementById("Day"+_id).style.display="inline";
    var d=new Date();
    var da=d.getDate();
    var dd
    var last_day
    var y=document.getElementById("Year"+_id).value;
    var m=document.getElementById("Month"+_id).value;
    var days=[31,28,31,30,31,30,31,31,30,31,30,31]
    if((y%4)==0)
    {
        if(m==2)
        {
            last_day=29
        }
        else
        {
            if((m-1)!=-1)
                last_day=days[m-1];
        }
    }
    else
    {
        if(m==2)
        {
            last_day=28
        }
        else
        {
            last_day=days[m-1];
        }
    }
    for(var i=1;i<=last_day;i++)
    {
        if(i==da)
            dd=dd+"<option value='"+i+"' selected='selected'>"+i+"日</option>"
        else
            dd=dd+"<option value='"+i+"'>"+i+"日</option>"
    }
    document.getElementById("Day"+_id).innerHTML=dd;
}

function timeConverter(UNIX_timestamp)
{
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = year + '/' + (a.getMonth()+1) + '/' + date + ' ' + hour + ':' + min;
    return time;
}
function timeConverter_easy(UNIX_timestamp)
{
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = year + '/' + (a.getMonth()+1) + '/' + date;
    return time;
}
