<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>晒单添加 - <?php echo $webname; ?>触屏版</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo G_TEMPLATES_MOBILESHAI; ?>/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo G_TEMPLATES_MOBILESHAI; ?>/bootstrap.min.css">
<script src="<?php echo G_TEMPLATES_MOBILESHAI; ?>/jquery190.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo G_TEMPLATES_MOBILESHAI; ?>/style.css">
<link rel="stylesheet" href="<?php echo G_TEMPLATES_MOBILESHAI; ?>/jquery.fileupload.css">
<script src="<?php echo G_TEMPLATES_MOBILESHAI; ?>/jquery.ui.widget.js"></script>
<script src="<?php echo G_TEMPLATES_MOBILESHAI; ?>/jquery.iframe-transport.js"></script>
<script src="<?php echo G_TEMPLATES_MOBILESHAI; ?>/jquery.fileupload.js"></script>
<script src="<?php echo G_TEMPLATES_MOBILESHAI; ?>/bootstrap.min.js"></script>
</head>
<body style="padding-top:0px;">
<script language="javascript" type="text/javascript">
function showdiv() {
    document.getElementById("bg").style.display ="block";
    document.getElementById("show").style.display ="block";
}
function hidediv() {
    document.getElementById("bg").style.display ='none';
    document.getElementById("show").style.display ='none';
}
</script>
<style type="text/css">
        #bg{ display: none;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: #f4f4f4;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
        #show{display: none;  position: absolute;  top: 40%;  left: 22%;  width: 53%;  height: 49%;  padding: 8px;  z-index:1002;  overflow: auto;}
        .loading {
            clear: both;
            width: 100%;
            display: block;
            height: 90px;
            line-height: 40px;
            text-align: center;
            color: #999;
            font-size: 45px;
            box-shadow:none;
            background: none;
        }

        .loading b {
            background: url(data:image/gif;base64,R0lGODlhEAAQAPIAAP///wCA/8Lg/kKg/gCA/2Kw/oLA/pLI/iH/C05FVFNDQVBFMi4wAwEAAAAh/h1CdWlsdCB3aXRoIEdJRiBNb3ZpZSBHZWFyIDQuMAAh/hVNYWRlIGJ5IEFqYXhMb2FkLmluZm8AIfkECQoAAAAsAAAAABAAEAAAAzMIutz+MMpJaxNjCDoIGZwHTphmCUWxMcK6FJnBti5gxMJx0C1bGDndpgc5GAwHSmvnSAAAIfkECQoAAAAsAAAAABAAEAAAAzQIutz+TowhIBuEDLuw5opEcUJRVGAxGSBgTEVbGqh8HLV13+1hGAeAINcY4oZDGbIlJCoSACH5BAkKAAAALAAAAAAQABAAAAM2CLoyIyvKQciQzJRWLwaFYxwO9BlO8UlCYZircBzwCsyzvRzGqCsCWe0X/AGDww8yqWQan78EACH5BAkKAAAALAAAAAAQABAAAAMzCLpiJSvKMoaR7JxWX4WLpgmFIQwEMUSHYRwRqkaCsNEfA2JSXfM9HzA4LBqPyKRyOUwAACH5BAkKAAAALAAAAAAQABAAAAMyCLpyJytK52QU8BjzTIEMJnbDYFxiVJSFhLkeaFlCKc/KQBADHuk8H8MmLBqPyKRSkgAAIfkECQoAAAAsAAAAABAAEAAAAzMIuiDCkDkX43TnvNqeMBnHHOAhLkK2ncpXrKIxDAYLFHNhu7A195UBgTCwCYm7n20pSgAAIfkECQoAAAAsAAAAABAAEAAAAzIIutz+8AkR2ZxVXZoB7tpxcJVgiN1hnN00loVBRsUwFJBgm7YBDQTCQBCbMYDC1s6RAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P4wykmrZULUnCnXHggIwyCOx3EOBDEwqcqwrlAYwmEYB1bapQIgdWIYgp5bEZAAADsAAAAAAAAAAAA=);
            background-size: 35px auto;
            background-repeat: no-repeat;
            width: 40px;
            height: 40px;
            display: inline-block;
            margin-right: 5px;
            position: relative;
            top: 2px;
        }
</style>
    <div class="h5-1yyg-v1" id="content">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->
    <header class="g-header">
        <div class="head-l">
	        <a href="javascript:;" onClick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
        </div>
        <h2 style="margin-top: 0px;font-size:18px;">晒单添加</h2>
        <div class="head-r">
	        <a href="<?php echo WEB_PATH; ?>/mobile/mobile" class="z-Home"></a>
        </div>
    </header>

    <form action="<?php echo WEB_PATH; ?>/mobile/home/postsingle/<?php echo $recordid; ?>" method="POST" id="postsingle_form">
        <section>
	        <div class="registerCon">
    	        <ul>
        	        <li>
                        <dl><input name="title" type="text" placeholder="标题"></dl>
                        <dl style="margin-top:5px;"><textarea style="background: #fff none repeat scroll 0 0;border: 1px solid #ddd;border-radius: 5px;color: #ccc;display: inline-block;font-size: 16px;padding: 0 5px;position: relative;width: 100%;" name="content" rows='5'  placeholder="描述您的晒单内容"></textarea></dl>
                    </li>
                    <li>
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>晒图</span>
                            <input id="fileupload" type="file" name="files[]" multiple>
                        </span>
                        <input type="hidden" name="fileurl_tmp" id="fileurl_tmp">
                        <div id="files" class="files"></div>
                    </li>
                    <li><a href="javascript:;" onclick="$('#postsingle_form').submit();" id="btnLogin" class="nextBtn  orgBtn">晒单</a>(由于手机拍照图片较大，上传晒图请耐心等待)</li>
                </ul>
	        </div>
        </section>
    </form>

<?php include templates("mobile/index","footer");?>
<script language="javascript" type="text/javascript">
$(function () {
    'use strict';
    var url = '<?php echo WEB_PATH; ?>/mobile/home/file_upload/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
			hidediv();
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                var s = $('#fileurl_tmp').val();
                if(s.length > 0){
                    $('#fileurl_tmp').val(s+';'+file.url);
                }else{
                    $('#fileurl_tmp').val(file.url);
                }
            });
        },
    
		  progressall: function (e, data) {
            showdiv();
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});


  var Path = new Object();
  Path.Skin="<?php echo G_TEMPLATES_STYLE; ?>";
  Path.Webpath = "<?php echo WEB_PATH; ?>";

var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo G_TEMPLATES_JS; ?>/mobile/Bottom.js?v='+GetVerNum());
</script>

    </div>
    <div id="bg"></div>
<div id="show" class="h5-1yyg-v1">
    <div id="divPayBox" class="paymainbox">
        <div class="loading"><b></b></div>
    </div>
</div>
</body>
</html>
