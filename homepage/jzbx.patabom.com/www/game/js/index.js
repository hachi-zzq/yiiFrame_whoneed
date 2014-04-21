// JavaScript Document

(function(){
	
	//32强字母排序表
	var TEAM_LIST = ["阿尔及利亚","阿根廷","澳大利亚","比利时","波黑","巴西","喀麦隆","智利","哥伦比亚","哥斯达黎加","科特迪瓦","克罗地亚","厄瓜多尔","英格兰","法国","德国","加纳","希腊","洪都拉斯","伊朗","意大利","日本","韩国","墨西哥","荷兰","尼日利亚","葡萄牙","俄罗斯","西班牙","瑞士","乌拉圭","美国"];
	
	//分组部分的按钮<a>统称为btn
	//冠军之路部分的圆圈<div>统称为circle
	
	var _delegate = SINA.Event.delegate;
	
	var team16 = SINA.query(".team-16th");
	var team8 = SINA.query(".team-8th");
	var team4 = SINA.query(".team-4th");
	var oGroupBox = document.getElementById("js_groupBox");
	var oRoadBox = document.getElementById("js_roadBox");
	var oRoadImg = document.getElementById("js_roadImg");
	var a16thImgSrc = [];
	var isDone = false;	//是不是都选完了
	
	for(var i=0; i<team16.length; i++) {
		var src = team16[i].getElementsByTagName("img")[0].src;
		a16thImgSrc.push(src);
	}
	
	//冠军之路对象
	var roadBox = new function(){
		
		//重置该DIV元素，递归算法，当class没有空格，即team-0时退出
		this.reset = function (elem) {
			var className = elem.className;
			if(!/team/.test(className)) {
				return;
			}
			
			/*thisNumber = className.split(/\s/)[0].split("-")[1];
			获取序列号，但是目前没用到这个功能*/
			
			isDone = false;		//只要有重置动作，一定没有选完
			oRoadImg.getElementsByTagName("img")[0].src = "http://match.sports.sina.com.cn/images/brazil2014/ui/blank.png";
			
			if(SINA.DOM.hasClass(elem,"team-16th")) {
				var index = SINA.Array.indexOf(team16,elem);
				var teamImg = a16thImgSrc[index];
			}
			else {
				var teamImg = "http://match.sports.sina.com.cn/images/brazil2014/ui/circle/blank.png";
			}
			
			if(SINA.DOM.hasClass(elem,"team-0")) {
				var teamName = "我的冠军";
			}
			else {
				var teamName = "";
			}
			
			_changeTeam(elem,teamImg,teamName);
			_delIcon(elem);
			this.reset(elem.parentNode);
		}
		
		//修改DIV对应的球队图片和球队名称
		var _changeTeam = function (elem,teamImg,teamName) {
			var children = SINA.DOM.children(elem);
			SINA.Array.forEach(children,function(item,index) {
				if(SINA.DOM.hasClass(item,"team-flag")) {
					item.getElementsByTagName("img")[0].src = teamImg;
				}
				else if(SINA.DOM.hasClass(item,"team-name")) {
					item.innerHTML = teamName;
				}	
			})
		}
		
		//删除DIV中“胜”字图标
		var _delIcon = function (elem) {
			var children = SINA.DOM.children(elem);
			SINA.Array.forEach(children,function(item,index) {
				if(SINA.DOM.hasClass(item,"win_icon_active")) {
					SINA.DOM.removeClass(item,"win_icon_active");
				}
			})
		}
		
		//判断该DIV所属的球队是否为空
		var _isEmpty = function (elem) {
			var children = SINA.DOM.children(elem);
			var result = false;
			SINA.Array.forEach(children,function(item,index) {
				if(item.tagName.toUpperCase() === "A") {
					var src = item.getElementsByTagName("img")[0].src;
					var isBlank = (src.indexOf("blank") !== -1) || (src.indexOf("\/0_") !== -1);
					if(isBlank) {
						result = true;
					}
				}
			})
			return result;
		}
		
		//生成冠军路线图
		var _showLine = function () {
			var championName = SINA.query("#championName")[0].innerHTML;
			var lineIndex = 0;
			var team16Name = SINA.query(".team-16th .team-name");
			team16Name = SINA.Array.map(team16Name,function(item,index) {
				return item.innerHTML;
			});
			for(var i=0; i<team16Name.length; i++) {
				if(team16Name[i] === championName) {
					lineIndex = i;
					break;
				}
			}
			oRoadImg.getElementsByTagName("img")[0].src = "http://match.sports.sina.com.cn/images/brazil2014/ui/road_line/road_" + lineIndex + ".png";
		}
		
		this.init = function () {
			var _that = this;
			_delegate(oRoadBox,"click","a",function(){
				var src = this.getElementsByTagName("img")[0].src;
				var isBlank = (src.indexOf("blank") !== -1) || (src.indexOf("\/0_") !== -1);
				if(isBlank) {
					alert("您还没选球队呢");
				}
				else {
					var thisDiv = this.parentNode;
					var teamImg = this.children[0].src;
					var teamName = SINA.DOM.next(this).innerHTML;
					var divSiblings = SINA.DOM.siblings(thisDiv);
					var winIcon = SINA.DOM.next(SINA.DOM.next(this));
					
					//bAgainstEmpty 有没有对手 b-bool
					var bAgainstEmpty = false;
					SINA.Array.forEach(divSiblings,function(item,index){
						if(item.tagName.toUpperCase() === "DIV") {
							if(_isEmpty(item)) {
								bAgainstEmpty = true;
							}
							_delIcon(item);
						}
					})

					if(bAgainstEmpty) {
						alert("还没选对手呢");
						return;	
					}
					
					if(winIcon) {
						SINA.DOM.addClass(winIcon,"win_icon_active");	
					}
					
					_changeTeam(thisDiv.parentNode,teamImg,teamName);
					if(thisDiv.parentNode === oRoadBox) {
						isDone = true;
						_showLine();	
					}
					else {
						_that.reset(thisDiv.parentNode.parentNode);	
					}
				}
			})
		}
	}()
	roadBox.init();
	
	//选择分组对象
	var groupBox = new function() {
		
		//通过链接获取对应的冠军之路circle的元素
		var _find = function (btn) {
			var oResult = null;
			var oLi = btn.parentNode.parentNode.parentNode;
			var thisGroup = oLi.parentNode;
			var groupName = thisGroup.getAttribute("data-group");
			gid = "team-" + groupName + btn.innerHTML;
			//SINA.each(team16,function(item,index){});
			SINA.Array.forEach(team16,function(item,index){		
				if(item.id == gid) {
					oResult = item;
				}
			})
			return oResult;
		}
		
		//重置链接对应的冠军之路的circle
		var _reset = function (btn) {
			var oTarget = _find(btn);
			roadBox.reset(oTarget);
		}
		
		//删除兄弟元素的active
		var _delSibling = function (btn) {
			var sibling = SINA.DOM.siblings(btn);
			if(SINA.DOM.hasClass(sibling[0],"active")) {
				SINA.DOM.removeClass(sibling[0],"active");
				_reset(sibling[0]);
			};
		}
		
		//删除所有同组相同序号的active
		var _delGroup = function (btn) {
			var oLi = btn.parentNode.parentNode.parentNode;
			var thisGroup = oLi.parentNode;
			var aLink = SINA.query("a",thisGroup);
			var className = btn.className;
			SINA.Array.forEach(aLink,function(item,index){
				if(SINA.DOM.hasClass(item,className) && SINA.DOM.hasClass(item,"active")) {
					SINA.DOM.removeClass(item,"active");
					_reset(item);
				}
			})
			SINA.DOM.addClass(btn,"active");
		}
		
		//添加链接对应的冠军之路circle
		var _addRoad = function (btn) {
			var oLi = btn.parentNode.parentNode.parentNode;
			teamImg = oLi.getElementsByTagName("img")[0].src;
			teamName = oLi.getElementsByTagName("h5")[0].innerHTML;
			
			var oTarget = _find(btn);
			oTarget.getElementsByTagName("img")[0].src = teamImg;
			oTarget.getElementsByTagName("p")[0].innerHTML = teamName;
		}
		
		//初始化，绑定事件
		this.init = function () {
			_delegate(oGroupBox,"click","a",function() {
				if(SINA.DOM.hasClass(this,"active")) {
					return;	
				}				
				_delSibling(this);
				_delGroup(this);
				_addRoad(this);
			});	
		}
	}()
	groupBox.init();
	
	var weiboObj = new function() {
		
		var weiboBtn = document.getElementById("weibo_btn").getElementsByTagName("a")[0];
		
		//传入一个球队的名字，返回一个球队的ID
		var _findNum = function (teamName) {
			for(var i=0; i<TEAM_LIST.length; i++) {
				if(TEAM_LIST[i] === teamName) {
					return i+1;	
				}
			}
			return -1;
		}
		
		var _parse = function (dataStr) {
			return (new Function("return (" + dataStr + ")"))();
		}
		
		//生成需要传到后台的数据
		var _createData = function () {
			var aResult = [];
			aResult[0] = teamArrToStr(team16);
			aResult[1] = teamArrToStr(team8);
			aResult[2] = teamArrToStr(team4);

            var team2 = [SINA.query(".team-00")[0],SINA.query(".team-01")[0]];
            aResult[3] = teamArrToStr(team2);
//			aResult[3] = _findNum(SINA.query(".team-00 > .team-name")[0].innerHTML) + "|" + _findNum(SINA.query(".team-01 > .team-name")[0].innerHTML);
			aResult[4] = _findNum(SINA.query("#championName")[0].innerHTML);
				
			return aResult.join("_");
			
			//输入一个球队数组，输出id链接的字符串
			function teamArrToStr(teamArr) {
				var arr = [];
				arr = SINA.Array.map(teamArr,function(item,index){
					var children = SINA.DOM.children(item);
					var teamName = "";
					for(var i=0; i<children.length; i++) {
						if(SINA.DOM.hasClass(children[i],"team-name")) {
							teamName = children[i].innerHTML;
						}	
					}
					return _findNum(teamName);
				})
				return arr.join("|");
			}
		}
		
		//发送请求到share.php，分享微博
		var _share = function(imgURL) {
			var championName = SINA.query("#championName")[0].innerHTML;
			var team4Arr = SINA.Array.map(team4,function(item,index) {
				var children = SINA.DOM.children(item);
				for(var i=0; i<children.length; i++) {
					if(SINA.DOM.hasClass(children[i],"team-name"))	{
						return children[i].innerHTML;
					}
				}
			});
			team4Name = team4Arr.join('、');
			var title = "2014巴西世界杯，我预测" + championName + "夺冠，" + team4Name + "进入四强，冠军之路如图。#世界杯抽签# 猛戳链接，也来预测你的世界杯冠军之路吧：";
			var json = {
				url:location.href,
				title:title,
				pic:imgURL
			}
			var url = "http://service.weibo.com/share/share.php?" + SINA.QueryString.stringify(json);
			window.open(url);
		}
		
		//将数据传到后台，生成图片
		var _doShare = function () {
			alert(1);
            return;
			//ajax请求后台接口(post)，返回图片地址
			var data = _createData();
			var url = "http://match.sports.sina.com.cn/brazil2014/champions/save";
			
			SINA.query("#weibo_btn a")[0].style.display = "none";
			
			SINA.IO.ajax(url,{
				method: 'POST',
				data: 'q='+encodeURIComponent(data),
				async: false,		//改为异步的话，弹出框会被浏览器阻止
				onsuccess: success,
				onfailure: function(){
					alert("ajax请求失败");
				}
			})
			
			function success(data){				
				var json = _parse(data);
				if(json.result.status.code === 0) {
					var imgURL = json.result.data.img_url;
					_share(imgURL);
				}
				else if(json.result.status.code === 11) {
					    alert(json.result.status.msg);
				}
				SINA.query("#weibo_btn a")[0].style.display = "block";
			}
		}
		
		this.init = function() {
			SINA.addListener(weiboBtn,"click",function () {
				if(!isDone) {
                    alert("您还没选完呢");
				}
				else {
				    saveHtml();
				}
			})
		}
		
	}()
	weiboObj.init();
	
})()
var arr = new Array('埃尔及利亚','阿根廷','澳大利亚','比利时','波黑','巴西','喀麦隆','智利','哥伦比亚','哥斯达黎加','科特迪瓦','克罗地亚','厄瓜多尔','英格兰','法国','德国'
    ,'加纳','希腊','洪都拉斯','伊朗','意大利','日本','韩国','墨西哥','荷兰','尼日利亚','葡萄牙','俄罗斯','西班牙','瑞士','乌拉圭','美国');


//保存当前htmnl
function saveHtml(){
    var champ = $('#champion').attr('src');
        champ = champ.match(/[\d]+/);
    var no1 = $('#no4_1').attr('src');
         no1 = no1.match(/[\d]+/);
    var no2 = $('#no4_2').attr('src');
        no2 = no2.match(/[\d]+/);
    var no3 = $('#no4_3').attr('src');
        no3 = no3.match(/[\d]+/);
    var no4 = $('#no4_4').attr('src');
        no4 = no4.match(/[\d]+/);
    var htmlData = document.getElementById('game_html');
    var html = htmlData.innerHTML;
    var url_share = 'http://service.weibo.com/share/share.php';
    var pic = encodeURI('http://bx.patabom.com/game/images/road_bd_bg.jpg');
    var url = "http://bx.patabom.com/game/outPutHtml";
    var title = '2014巴西世界杯，我预测'+arr[champ-1]+'夺冠，'+arr[no1-1]+'、'+arr[no2-1]+'、'+arr[no3-1]+'、'+arr[no4-1]+'进入四强。"世界杯抽签" 猛戳链接，也来预测你的世界杯冠军之路吧：';

    $.ajax({
        type:'POST',
        url:'/game/ajaxSave',
        data:'data='+html,
        success:function(param){
            console.log(html);
            window.location = url_share+'?appkey=583395093&title='+title+'&pic='+pic+'&url='+encodeURI(url+'?param='+param);
        },
        error:function(){
            alert('error');
        }
    })
}
