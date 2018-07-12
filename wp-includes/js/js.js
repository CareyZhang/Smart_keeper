var init_count=0;
var upper
var lower
var _type
var _id
function init(up,lo)
{
    upper=up;
    lower=lo;
    _type=0;
    _id=-1;
    var str="".concat(upper,",",lower,",",_id,",",_type);
    var socket = io.connect('http://140.125.33.31:8080');
    socket.emit('Data',str);
    document.getElementById("chart_div").innerHTML="<canvas id='myChart'>"
        socket.on('Data',function(data){
	    if(init_count==0)
	    {
		draw_statistics_table(upper,lower,data);
	    }
	    init_count++;
        });
	socket.emit('ID',"GET ALL ID");
	socket.on('ID',function(data){
		var str="<option value='-1' selected='selected'>ALL</option>";
		for(var key in data)
		{
			if(data[key]._pid==_id)
				str+="<option value="+data[key]._pid+" selected='selected'>"+data[key]._pid+"</option>";
			else
				str+="<option value="+data[key]._pid+">"+data[key]._pid+"</option>";
		}
		document.getElementById('_id').innerHTML=str;
	});
    var tim="".concat(timeConverter_easy(lower),"~",timeConverter_easy(upper));
    document.getElementById('show_tim').innerHTML=tim;
    year_init();
    month_init(1);
    month_init(2);
    day_init(1);
    day_init(2);
}

function draw_statistics_table(up,lo,data)
{
	console.log(data)
        var days=(up-lo)/86400;
	var data_count=0;
        var div_content="<table><tr><td>ID</td><td>Time</td><td>Usage(kWh)</td></tr>";
        for(var key in data)
        {
                div_content+="<tr><td>"+data[key]._pid+"</td><td>"+timeConverter_easy(data[key]._time)+"</td><td>"+data[key]._usage+"</td><td></td></tr>";
		data_count++;
        }
	if(data_count==0)
	{
		div_content+="<tr><td colspan='5'>No Data</td></tr>";
	}
	div_content+="</table>";
        document.getElementById('statistics_div').innerHTML=div_content;
	draw_chart(up,lo,data);
	/*var time=[];
	var usage=[];
	var div_content="<table><tr><td>Date</td><td>Usage(kWh)</td></tr>";
	var days=(up-lo)/86400;
	var day_usage = [];
	var data_count = [];
	var aver_day_usage = [];
	var without_data = 0;
	for(var i=0;i<days;i++)
	{
		day_usage[i]=0;
		data_count[i]=0;
		aver_day_usage[i]=0;
	}
	for(var key in data)
	{
		var index=Math.floor((data[key]._time-lower)/86400);
		day_usage[index]+=data[key]._usage;
		data_count[index]++;
	}
	for(var i=0;i<days;i++)
	{
		var t=(lo*1)+(i*86400);
		if(data_count[i]!=0)
		{
			aver_day_usage[i]=(day_usage[i]/data_count[i])*0.36;
			time.push(timeConverter_easy(t));
			usage.push(aver_day_usage[i]);
			div_content+="<tr><td>"+timeConverter_easy(t)+"</td><td>"+aver_day_usage[i]+"</td></tr>";
		}
		else
		{
			without_data++;
		}
		if(without_data==days)
			div_content+="<tr><td colspan='2'>No Data</td></tr>";
	}
	div_content+="</table>"
	document.getElementById('statistics_div').innerHTML=div_content;
	draw_chart(up,lo,time,usage);*/
}

function draw_chart(up,lo,data)
{
	var days=(up-lo)/86400;
	var day_arr=[];
	var data_arr=[];
        var div_content="<table><tr><td>Date</td><td>ID</td><td>Usage(kWh)</td></tr>";
	for(var i=0;i<days;i++)
	{
		var t=(lo*1)+(i*86400);
		day_arr.push(timeConverter_easy(t));
	}
	var which_id=-1;
	var tmp=new Object();
	var tmp_arr=[];
	var data_count=0;
	if(JSON.stringify(tmp)==='{}')
		console.log("test")
        for(var key in data)
	{
		var index=Math.floor((data[key]._time-lo)/86400);
		while(which_id!=data[key]._pid)
		{
			if(JSON.stringify(tmp)!=='{}')
			{
				tmp.data=tmp_arr;
				data_arr[data_count]=tmp;
				data_count++;
			}
			which_id++;
			tmp=new Object();
		}
		if(JSON.stringify(tmp)==='{}')
		{
			tmp_arr=[];
			tmp.label=data[key]._pid;
			var color="rgb(".concat(Math.floor(Math.random()*256),",",Math.floor(Math.random()*256),",",Math.floor(Math.random()*256),")");
			tmp.borderColor=color;
			for(var i=0;i<days;i++)
			{
				tmp_arr.push(0);
			}
		}
		tmp_arr[index]=data[key]._usage;
	}
	if(JSON.stringify(tmp)!=='{}')
        {
           tmp.data=tmp_arr;
           data_arr[data_count]=tmp;
	   data_count++;
        }
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: day_arr,
            datasets: data_arr,
        },

        // Configuration options go here
        options: {}
    });
}

function _search()
{
    _id = document.getElementById('_id').value
    _type = document.getElementById('_type').value
    init_count=0;
    var year1 = document.getElementById('Year1').value
    var month1 = document.getElementById('Month1').value
    var day1 = document.getElementById('Day1').value
    var year2 = document.getElementById('Year2').value
    var month2 = document.getElementById('Month2').value
    var day2 = document.getElementById('Day2').value
    var tt1 = year1+'-'+month1+'-'+day1;
    var tt2 = year2+'-'+month2+'-'+day2;
    document.getElementById('chart_div').innerHTML="<canvas id='myChart'>"
    lower = (new Date(tt1).getTime())/1000;
    upper = (new Date(tt2).getTime())/1000;
    if(lower>upper)
    {
        var tmp=lower
        lower=upper
        upper=tmp
    }
    upper+=86399
    var tim="".concat(timeConverter_easy(lower),"~",timeConverter_easy(upper));
    document.getElementById('show_tim').innerHTML=tim;
    var str="".concat(upper,",",lower,",",_id,",",_type);
    var socket = io.connect('http://140.125.33.31:8080');
    socket.emit('Data',str);
    socket.emit('ID',"GET ALL ID");
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
