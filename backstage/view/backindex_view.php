<script type="text/javascript">
function current(){
var d=new Date(),str='';
str +=d.getFullYear()+'年'; //取得年
str +=d.getMonth()+1+'月'; //取得現在月份(0~11)
str +=d.getDate()+'日';
str +=d.getHours()+'時';
str +=d.getMinutes()+'分';
str +=d.getSeconds()+'秒';
return str; }
setInterval(function(){$("#nowTime").html(current)},1000);
</script>
<div style="height:110px;">
</div>
<div class="jumbotron">
  <h1>你好，歡迎使用物管系統！</h1>
	</br></br>
  <div class="alert alert-info">
  	<h3>現在時間是: <span id="nowTime"></span></h3>
  	
  </div>
</div>