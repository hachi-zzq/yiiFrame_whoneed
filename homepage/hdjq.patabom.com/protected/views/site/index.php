<?php include 'cheader.php'; ?>
    <script type="text/javascript" src="/js/alixixi_jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/play.css" />

    <script type="text/javascript">
        $(document).ready(function(){
            $('#example1').bxCarousel({
                display_num: 4,
                move: 1,
                prev_image: 'images/icon_arrow_left.png',
                next_image: 'images/icon_arrow_right.png'
            });
            $('#example2').bxCarousel({
                display_num: 4,
                move: 1,
                auto: true,
                controls: false,
                margin: 5,
                auto_hover: true
            });
        });
        /*
         bxCarousel v1.0
         Plugin developed by: Steven Wanderski
         */
        (function($){$.fn.bxCarousel=function(options){var defaults={move:4,display_num:4,speed:500,margin:0,auto:false,auto_interval:2000,auto_dir:'next',auto_hover:false,next_text:'next',next_image:'',prev_text:'prev',prev_image:'',controls:true};var options=$.extend(defaults,options);return this.each(function(){var $this=$(this);var li=$this.find('li');var first=0;var fe=0;var last=options.display_num-1;var le=options.display_num-1;var is_working=false;var j='';var clicked=false;li.css({'float':'left','listStyle':'none','marginRight':options.margin});var ow=li.outerWidth(true);wrap_width=(ow*options.display_num)-options.margin;var seg=ow*options.move;$this.wrap('<div class="bx_container"></div>').width(999999);if(options.controls){if(options.next_image!=''||options.prev_image!=''){var controls='<a href="" class="prev"><img src="'+options.prev_image+'"/></a><a href="" class="next"><img src="'+options.next_image+'"/></a>';}
        else{var controls='<a href="" class="prev">'+options.prev_text+'</a><a href="" class="next">'+options.next_text+'</a>';}}
            $this.parent('.bx_container').wrap('<div class="bx_wrap"></div>').css({'position':'relative','width':wrap_width,'overflow':'hidden'}).before(controls);var w=li.slice(0,options.display_num).clone();var last_appended=(options.display_num+options.move)-1;$this.empty().append(w);get_p();get_a();$this.css({'position':'relative','left':-(seg)});$this.parent().siblings('.next').click(function(){slide_next();clearInterval(j);clicked=true;return false;});$this.parent().siblings('.prev').click(function(){slide_prev();clearInterval(j);clicked=true;return false;});if(options.auto){start_slide();if(options.auto_hover&&clicked!=true){$this.find('li').live('mouseenter',function(){if(!clicked){clearInterval(j);}});$this.find('li').live('mouseleave',function(){if(!clicked){start_slide();}});}}
            function start_slide(){if(options.auto_dir=='next'){j=setInterval(function(){slide_next()},options.auto_interval);}else{j=setInterval(function(){slide_prev()},options.auto_interval);}}
            function slide_next(){if(!is_working){is_working=true;set_pos('next');$this.animate({left:'-='+seg},options.speed,function(){$this.find('li').slice(0,options.move).remove();$this.css('left',-(seg));get_a();is_working=false;});}}
            function slide_prev(){if(!is_working){is_working=true;set_pos('prev');$this.animate({left:'+='+seg},options.speed,function(){$this.find('li').slice(-options.move).remove();$this.css('left',-(seg));get_p();is_working=false;});}}
            function get_a(){var str=new Array();var lix=li.clone();le=last;for(i=0;i<options.move;i++){le++
                if(lix[le]!=undefined){str[i]=$(lix[le]);}else{le=0;str[i]=$(lix[le]);}}
                $.each(str,function(index){$this.append(str[index][0]);});}
            function get_p(){var str=new Array();var lix=li.clone();fe=first;for(i=0;i<options.move;i++){fe--
                if(lix[fe]!=undefined){str[i]=$(lix[fe]);}else{fe=li.length-1;str[i]=$(lix[fe]);}}
                $.each(str,function(index){$this.prepend(str[index][0]);});}
            function set_pos(dir){if(dir=='next'){first+=options.move;if(first>=li.length){first=first%li.length;}
                last+=options.move;if(last>=li.length){last=last%li.length;}}else if(dir=='prev'){first-=options.move;if(first<0){first=li.length+first;}
                last-=options.move;if(last<0){last=li.length+last;}}}});}})(jQuery);
    </script>
<!-- main -->
<div id="main_index">
    <div style="position:absolute;left:0;top:0;width:100%; height:650px;">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" height="650" width="100%"><param name="movie" value="/images/flash.swf"" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="AllowScriptAccess" value="always" /><embed allowscriptaccess="always" height="750" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="/images/flash.swf"" type="application/x-shockwave-flash" width="100%" wmode="transparent"></embed></object></div>
  <div class="main_top" style="position:absolute;top:0;left:50%;margin-left:-503px;">
    <?php include 'cnav.php'; ?>
    <div class="download clearfix">
      <div class="d_a left pos_rel">
        <?php $objDB = HP::get_qrcode_by_id(12); ?>
        <p>版本：<span><?php echo $objDB->version; ?></span></p>
        <p>文件大小：<span><?php echo $objDB->size; ?></span></p>
        <p><a href="<?php echo $objDB->download_url; ?>" class="d_a_btn"></a></p>
        <p class="td_code"><img alt="" border="0" src="<?php echo HP::get_cdn_img_url($objDB->qrcode_img); ?>" /></p>
      </div>
      <div class="d_b left pos_rel">
        <?php $objDB = HP::get_qrcode_by_id(13); ?>
<!--        <p>版本：<span>--><?php //echo $objDB->version; ?><!--</span></p>-->
<!--        <p>文件大小：<span>--><?php //echo $objDB->size; ?><!--</span></p>-->
            <p><span>敬请期待...</span></p>
            <p>&nbsp;</p>
        <p><a href="<?php echo $objDB->download_url; ?>" class="d_b_btn" onclick="return false"></a></p>
<!--        <p class="td_code"><img alt="" border="0" src="--><?php //echo HP::get_cdn_img_url($objDB->qrcode_img); ?><!--" /></p>-->
      </div>
<!--        <div class="d_b left pos_rel">-->
<!--            <!-- <p>版本：<span>2.0.2</span></p>-->
<!--            <p>文件大小：<span>61.8 MB</span></p>-->-->
<!--            <p><span>敬请期待</span></p>-->
<!--            <p>&nbsp;</p>-->
<!--            <p><a href="#" class="d_b_btn"></a></p>-->
<!--            <p class="td_code"><img alt="" border="0" src="/images/td_code.jpg" /></p>-->
<!--        </div>-->
      <div class="d_c left pos_rel" id='qrcode_r'>
        <?php $objDB = HP::get_qrcode_by_id(14); ?>
        <p>版本：<span><?php echo $objDB->version; ?></span></p>
        <p>文件大小：<span><?php echo $objDB->size; ?></span></p>
        <p><a href="<?php echo $objDB->download_url; ?>" class="d_c_btn"></a></p>
        <p class="td_code"><img alt="" border="0" src="<?php echo HP::get_cdn_img_url($objDB->qrcode_img); ?>" /></p>
      </div>
    </div>
  </div>
  <div id="wrap2" style="padding-top:730px; background-position:center 730px;">
  <div class="dh_title">&nbsp;</div>
    <div id="wrap3"> 
      <div class="content clearfix">
        <div class="content_l left">
          <div class="comiis_wrapad" id="slideContainer">
            <div id="frameHlicAe">
              <ul class="slideshow" id="slidesImgs">
                <li><a href="#"> <img src="/images/banner1.jpg" width="520" height="240" alt="" /></a></li>
                <li><a href="#"> <img src="/images/banner2.jpg" width="520" height="240" alt="" /></a></li>
                <li><a href="#"> <img src="/images/banner3.jpg" width="520" height="240" alt="" /></a></li>
                <li><a href="#"> <img src="/images/banner4.jpg" width="520" height="240" alt="" /></a></li>
              </ul>
              <div class="slidebar" id="slideBar">
                <ul>
                  <li class="on">1</li>
                  <li>2</li>
                  <li>3</li>
                  <li>4</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="box"> <a href="/site/cdetail/id/9" title="入门指南" target="_blank" class="floor-maskItem" > <img src="/images/rm.jpg" />
            <div class="mask"></div>
            </a> <a href="javascript:void(0)" id="novicePackage" title="新手奖励" class="floor-maskItem dw1"> <img src="/images/xs.jpg" />
            <div class="mask"></div>
            </a> <a href="/site/cdetail/id/10" target="_blank" title="美女系统" class="floor-maskItem dw2"> <img src="/images/mv.jpg" />
            <div class="mask"></div>
            </a> <a href="/site/growth_package" target="_blank" title="成长礼包"class="floor-maskItem dw3"> <img src="/images/cz.jpg" />
            <div class="mask"></div>
            </a>
            <div class="dialog" id="dialog1" style="display:none;">         
                  <a href="javascript:;" class="close_btn"><img alt="关闭" border="0" src="/images/x.png" /></a>
                  <p>新手礼包激活码：<span id="span_code" style="color:#000; font-weight:300;background:#f1abab;display:inline-block;height:20px;line-height:20px;margin-top:6px;padding:0 8px 0 0;"></span></p>
                  <p style="width:80px;float:left">礼包内容:</p>
                  <span  id="span_content" style="float:right;width:310px;display:block;"></span>
                  <p style="clear:both"></p>
                  <p>友情提醒：<span  id="span_message_success" class="tx"></span></p>           
            </div>
            <div class="dialog" id="dialog2" style="display:none;">         
                  <a href="javascript:;" class="close_btn"><img alt="关闭" border="0" src="/images/x.png" /></a>
                  <p>友情提醒：<span id="span_message_fail" class="tx"></span></p>           
            </div>
          </div>
        </div>
        <div class="content_r right">
        <div class="news_title">
        <a href="/site/new_index" class="right">更多>></a>
        </div>
        <div class="news_content">
        <h1><a href="/site/new_detail/id/<?php if($objFDB){ echo $objFDB->id;} ?>" title="<?php if($objFDB){ echo $objFDB->title;} ?>"><?php if($objFDB){ echo $objFDB->title;} ?></a></h1>
        <p>SLG手游《皇帝崛起》集结超强玩法功能，唯一耐玩的天子手游！</p>
        <ul class="news_list">
        <?php 
            if($objODB){
                $arrType = HP::get_hp_type($stype);
                foreach($objODB as $obj){
        ?>
            <li><span class="left">[<?php echo $arrType[$obj->type]; ?>]</span>&nbsp;<a href="/site/new_detail/id/<?php echo $obj->id; ?>" title="<?php echo $obj->title; ?>"><?php echo $obj->title; ?></a><span class="right"><?php echo date('m/d', strtotime($obj->submit_date));?></span></li>
        <?php
                }
            }
        ?>
        </ul>
        </div>
            <div class="coop">
                <div class="coop_title"> <!--<a href="#" class="right">更多>></a>--> </div>
                <div class="coop_content">
                    <h2>
                        <a href="javascript:;" class="current" tip="0">口袋巴士</a><a href="javascript:;" tip="1">5G网</a><a href="javascript:;" tip="2">齐乐乐</a>
                    </h2>
                    <div class="coop_news">
                        <div class="c_news" style="display:block">
                            <iframe frameborder="no" border="0" src="http://www.ptbus.com/hdjq/show/"></iframe>
                        </div>
                        <div class="c_news" style="display:none">
                            <iframe frameborder="no" border="0" src="http://www.5g.com/hdjq/qt-hdjq.html"></iframe>
                        </div>
                        <div class="c_news" style="display:none">
                            <iframe frameborder="no" border="0" src="http://sy.766.com/block/block_39.html"></iframe>
                        </div>
                    </div>

                    <div class="examples_body">
                        <div class="bx_wrap">
                            <div class="bx_container">
                                <ul id="example2">
                                    <li><img width="92" height="42" src="/images/yo.png"></li>
                                    <li><img width="92" height="42" src="/images/5g.png"></li>
                                    <li><img width="92" height="42" src="/images/kd.png"></li>
                                    <li><img width="92" height="42" src="/images/youxiduo.png"></li>
                                    <li><img width="92" height="42" src="/images/anfensi.png"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

<!--                    <p class="coop_www">-->
<!--                        <a href="http://www.yooyo.com/" class="noMargin" target="_blank"><img alt="优游网" border="0" src="/images/yo.png" width="92" height="42" /></a>-->
<!--                        <a href="http://www.5g.com/" target="_blank"><img alt="5G.com" border="0" src="/images/5g.png"width="92" height="42"  /></a>-->
<!--                        <a href="http://www.ptbus.com/" target="_blank"><img alt="口袋巴士" border="0" src="/images/kd.png"width="92" height="42" /></a>-->
<!--                        <a href="http://www.youxiduo.com/" target="_blank"><img alt="游戏多" border="0" src="/images/youxiduo.png" width="92" height="42" /></a>-->
<!--                    </p>-->
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
<!-- main end -->
<script type="text/javascript">
$(document).ready(function(){
    $('.coop_content h2 a').bind('click',function(){
        var n=$(this).attr('tip');
        $('.coop_content h2 a').removeClass('current');
        $(this).addClass('current');
        $('.c_news').hide();
        $('.c_news').eq(n).show();
    })
})

$("#novicePackage").on("click",function(){
    $.get("/site/getNovicePackage",function(msg){
        msg = eval("("+msg+")");
        var num = $('#dialog1').attr('num') || 0;
        num++;
        $('#dialog1').attr('num',num);
        if(num>5){
            $("#span_message_fail").html('你已经领取过新手礼包,礼包只能激活一次,请不要领取更多!');
            $('#dialog2').show();
        }else if(msg.status==1){
            $("#span_code").html(msg.code);
            $("#span_content").html(msg.content);
            $("#span_message_success").html(msg.message);
            $('#dialog1').show();
        }else{
            $("#span_message_fail").html(msg.message);
            $('#dialog2').show();
        }
    });
})
$('.close_btn').on('click',function(){
    $('.dialog').hide();
})
</script>
<?php include 'cfooter.php'; ?>
