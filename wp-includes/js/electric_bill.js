var upper
var lower
var socket = io.connect('http://140.125.33.31:8080');
var fee = 3

function init()
{
    socket.on('Bill',function(data){
		var total_used=0
		var str=`<table class="table table-striped">
				<thead class="thead-dark">
				<tr>
					<th>ID</th>
					<th>Usage</th>
					<th>Fee</th>
				</tr>
				</thead>`;
		for(var key in data)
		{
			str+="<tr><th>"+data[key]._pid+"</th><th>"+data[key].used+"</th><th>"+data[key].used*fee+"</th></tr>"
			total_used=total_used*1+data[key].used*1
		}
		str+="<tr style='border-top:1px double #000;'><th>Total</th><th>"+total_used+"</th><th>"+Math.round(total_used*fee)+"</th></tr></table>"
		document.getElementById("bill_div").innerHTML=str
        });
    year_init();
    month_init();
    get_bill();
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
    document.getElementById("Year").innerHTML=yy;
}
function month_init()
{
    var d=new Date();
    var m=d.getMonth()+1;
    document.getElementById("Month").style.display="inline";
    var mm
    for(var i=1;i<=12;i++)
    {
        if(m==i)
            mm=mm+"<option value='"+i+"' selected='selected'>"+i+"月</option>"
        else
            mm=mm+"<option value='"+i+"'>"+i+"月</option>"
    }
    document.getElementById("Month").innerHTML=mm;
}

function _search()
{
	get_bill();
}

function get_bill()
{
	var yy=document.getElementById("Year").value
	var mm=document.getElementById("Month").value
	var dat1=new Date(yy,mm-1,1);
	var dat2
	if(mm!=12)
	{
		dat2=new Date(yy,mm,1);
	}
	else
	{
		dat2=new Date(yy*1+1,0,1);
	}
	var lower=Math.round(dat1.getTime()/1000)
	var upper=Math.round(dat2.getTime()/1000)
	var str=lower+"-"+upper
	socket.emit('Bill',str);
}
