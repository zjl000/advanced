window.onload = function () {
	var oTool = document.getElementById('begin-read');
	var oA = getClass(oTool,'tri');
	var oBox = getClass(oTool,'catalog-box');
	var timer = null;
	for(var i=0;i<oA.length;i++){
		oA[i].index = i;
		oA[i].onclick = function (ev) {
			var ev = ev|| window.event;
			var num = this.index;
			if(oBox[this.index].style.display == 'block'){

				changeSmlWidth(oBox[num],60);
				
			}else{

				for(var i=0;i<oBox.length;i++){
					oBox[i].style.display = 'none';
				}
				oBox[this.index].style.display = 'block';
				changeBigWidth(oBox[this.index],60);	
			}

				ev.cancelBubble = true;
			window.onclick = function(){
				changeSmlWidth(oBox[num],60);
			}
		}
	}
	
	var oAut = document.getElementById('m-author');
	var clientH = document.documentElement.clientHeight || document.body.clientHeight;
	if(oAut.offsetHeight<clientH){
		oAut.style.height = clientH  + 'px';
	}

	function getClass(parents,ClassName){
		var oTags = parents.getElementsByTagName('*');
		var result = [];
		for(var i=0;i<oTags.length;i++){
			if(oTags[i].className == ClassName){
				result.push(oTags[i]);
			}
		}
		return result;
	}

	function changeSmlWidth(obj,speed){
		var value = 660;
		clearInterval(obj.timer);
		obj.timer = setInterval(function(){
			var iSpeed = speed;
			if(value == 0){
				clearInterval(obj.timer);
				obj.style.display = 'none';
			}else{
				value -= iSpeed;
				obj.style.width = value + 'px';
			}
		},30);
	}

	function changeBigWidth(obj,Speed){
		var value = 0;
		obj.style.height = document.documentElement.clientHeight + 'px';
		clearInterval(obj.timer);
		obj.timer = setInterval(function(){
			var iSpeed = Speed;
			if(value == 660){
				clearInterval(obj.timer);
			}else{
				value += iSpeed;
				obj.style.width = value+'px';
			}
		},30);
	}
}