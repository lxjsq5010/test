<?php
error_reporting(E_ALL ^ E_NOTICE);

/*
header("Content-type: application/json");
$message = '哈哈[attachimg]data/attachment/forum/201604/20/e1b87cb3983273ed8e711ae46ffd46ff.jpg[/attachimg]噢噢[attachimg]data/attachment/forum/201604/20/e88c111685b702609260d38481382fc7.jpg[/attachimg]嘿嘿嘿';
//preg_match_all('/\[attachimg\](\d+)\[\/attachimg\]/is' , $message , $attachimgs);
preg_match_all('/\[attachimg\](.*?)\[\/attachimg\]/is' , $message , $attachimgs);

echo 'mes1='.$message;
echo "\n\n\n";
foreach($attachimgs[1] as $v){
    $search = '[attachimg]'.$v.'[/attachimg]';
    $replace = "[img]http://www.gzmama.com/".$v."[/img]";
    $message = str_replace($search, $replace, $message );  
}
echo 'mes2='.$message;
exit;
echo json_encode($attachimgs);exit;
*/


function curl_get($url = '',$data = array(), $showUrl = false, $timeout = 3){
	if(is_array($data)){
		$url_data = http_build_query($data);
		$url .= "?$url_data";
	}

	$ch = curl_init();
	if($showUrl)
		echo $url;
  $param = array(
      CURLOPT_URL => $url,
      CURLOPT_HEADER => 0,
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_RETURNTRANSFER => true,
  );

  curl_setopt_array($ch, $param);
  $rs = curl_exec($ch);
  return $rs;
}

function curl_post($url, $data, $timeout=10){
    //echo 'url=='.$url.'<br>';
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt ( $ch, CURLOPT_FAILONERROR, 1 );
    
    
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
  return $return;
}
// 客户点调用同城活动的接口，用这个函数生成token
function set_token1($param, $secretkey = API_SECRETKEY){
  unset($param['show_token']);
  $token = $secretkey;
  $token .= loop_array_token($param);
  $token .= $secretkey;
  $showtoken = true;
  $gettoken = $token;
  $token = strtoupper(md5($token));
  return $token;
}

// 对参加token生成的参数进行预处理
function loop_array_token($param){
  $token = "";
  ksort($param);
  foreach($param as $k=>$v){
    if(is_array($v)){
      $token .="{$k}";
      $token .= loop_array_token($v);
    }else{
      $token .= "{$k}{$v}";
    }
  }
  //处理特殊转义字符。
  return stripslashes($token);
}


function geturl(){
    $param['cityID']='289';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['t']=time();    
    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
    $url = 'http://hd.mapi.mama.cn/api/comment/test?cityID='.$param['cityID'].'&app='.$param['app'].'&ver='.$param['ver'].'&t='.$param['t'].'&token='.$token;
    echo $url;
    exit;
}

function loopParam($param){
	foreach($param as $key => $val){
		$arr[] = $key.'='.$val;
	}
	return	implode('&',$arr);

}

/*
    header("Content-type: application/json");
//    $url = 'http://comm.capi.gzmama.com/promotion_v200/send/thread00';    
    $url = 'http://m.capi.gzmama.com/promotion/v200/send/thread';    
    $param['app'] = 'tcq_android';
    $param['uid'] = '9635152';
    $param['ver'] = '2.1.0';
    $param['t'] = time();
    $param['fromsite'] = 'mcapi';

    $param['site'] = 'gz';
    $param['subject'] = 'jietestjob.5.';
    $param['desc'] = 'abcdddd';
		//$param['attach'] = 'WyJkYXRhL2F0dGFjaG1lbnQvZm9ydW0vMjAxNjA0LzE4L2VmOWJkZGY5OGJhMWMxZjlmZTg3NjMzZDQ2Y2JiM2ZmLmpwZyJd';
		$param['attach'] = 'WyJ1cGxvYWQvMjAxNi8wNC8xOS80MWYyNWM2NGNmNDNiMTYwZmJhZGYyZmU3YjhlYTNiZV8xNjBYMTI2LmpwZyIsInVwbG9hZC8yMDE2LzA0LzE5LzUyODI5OGYxMjkzZGRlMzU4YzQyYjkwY2FjNGU0NTZiXzExMlgxMTMuanBnIiwidXBsb2FkLzIwMTYvMDQvMTkvZWM0MzJmMzAwYzUyMDFiODZmMDYwNThjMTMzYzFlNzdfNjQwWDIzMC5qcGciXQ==';
    $param['cid'] = '1';
    $param['message'] = 'hellogod3341';
    $param['starttime'] = '2016-04-05';
    $param['endtime'] = '2016-04-20';
    $param['address'] = '天河城';
    $param['lng'] = '245.256';
    $param['lat'] = '255.266';
    $param['issync'] = 1;
    $param['check_token'] = 'no';

    //$param['check_token'] = 'no';
    //$param['domain'] = 'gzmama.com';
    //$param['cityID']='289';
    
		//$secretkey = 'capilcL-tyTiy[fPNGzYsa]J8(,tNT@~.';
		$secretkey = 'sEYBxwKBgFZA+VPS9tbFEIZmjFSwEs6l';
		
    $token = set_token1($param, $secretkey);
    //echo 't=='.$token;exit;
    $param['token']=$token;     
    
    //$urlparam = loopParam($param);
    //$url = $url."?$urlparam";
//    echo $url;exit;
		//$ret = curl_get($url);

		$ret = curl_post($url,$param);
    
    echo $ret;
    exit;
 */ 

    header("Content-type: application/json");
    $url = 'http://comm.capi.gzmama.com/promotion_v200/thread/post00';    
    $param['app'] = 'tcq_android';
    $param['ver'] = '2.2.0';
    $param['hash'] = 'abcdefgd';
    $param['t'] = time();
    $param['fromsite'] = 'mcapi';
    $param['uid'] = '9635152';
    $param['tid'] = '65';
    $param['site'] = 'gz';
    
    $secretkey = 'capilcL-tyTiy[fPNGzYsa]J8(,tNT@~.';
    $token = set_token1($param, $secretkey);
    //echo 't=='.$token;exit;
    $param['token']=$token;     
    
    //$urlparam = loopParam($param);
    //$url = $url."?$urlparam";
    //echo $url;exit;
    $ret = curl_post($url,$param);
    
    echo $ret;
    exit;


    header("Content-type: application/json");
    $url = 'http://comm.capi.gzmama.com/promotion_v200/thread/content00';    
    $param['app'] = 'tcq_android';
    $param['ver'] = '2.1.0';
    $param['t'] = time();
    $param['fromsite'] = 'mcapi';
    $param['uid'] = '9635152';
    $param['tid'] = '65';


    //$param['check_token'] = 'no';
    //$param['domain'] = 'gzmama.com';
    //$param['cityID']='289';
    
    $secretkey = 'capilcL-tyTiy[fPNGzYsa]J8(,tNT@~.';
    $token = set_token1($param, $secretkey);
    //echo 't=='.$token;exit;
    $param['token']=$token;     
    
    //$urlparam = loopParam($param);
    //$url = $url."?$urlparam";
		//echo $url;exit;
		$ret = curl_get($url,$param);

		//$ret = curl_post($url,$param);
    
    echo $ret;
    exit;



    header("Content-type: application/json");
    $url = 'http://comm.capi.gzmama.com/promotion_v200/send/post00';    
    $param['app'] = 'tcq_android';
    $param['ver'] = '2.1.0';
    $param['hash'] = 'abcdefgd';
    $param['t'] = time();
    $param['fromsite'] = 'mcapi';
    $param['uid'] = '9635152';
    $param['tid'] = '65';
    $param['reply_pid'] = '0';
    $param['message'] = 'hello.heiehei';
    $param['site'] = 'gz';
    
    $secretkey = 'capilcL-tyTiy[fPNGzYsa]J8(,tNT@~.';
    $token = set_token1($param, $secretkey);
    //echo 't=='.$token;exit;
    $param['token']=$token;     
    
    //$urlparam = loopParam($param);
    //$url = $url."?$urlparam";
    //echo $url;exit;
    $ret = curl_post($url,$param);
    
    echo $ret;
    exit;







/*
    header("Content-type: application/json");
    $url = 'http://comm.capi.gzmama.com/promotion_v200/send/praise00';    
    $param['app'] = 'tcq_android';
    $param['ver'] = '2.1.0';
    $param['t'] = time();
    $param['fromsite'] = 'mcapi';
    $param['uid'] = '9635152';
    $param['tid'] = '62';
    $param['status'] = 1;


    //$param['check_token'] = 'no';
    //$param['domain'] = 'gzmama.com';
    //$param['cityID']='289';
    
    $secretkey = 'capilcL-tyTiy[fPNGzYsa]J8(,tNT@~.';
    $token = set_token1($param, $secretkey);
    //echo 't=='.$token;exit;
    $param['token']=$token;     
    
    //$urlparam = loopParam($param);
    //$url = $url."?$urlparam";
		//echo $url;exit;
		$ret = curl_get($url,$param);

		//$ret = curl_post($url,$param);
    
    echo $ret;
    exit;
*/


$cityinfo = require_once 'city_info.php';
header("Content-type: text/html; charset=utf8"); 

foreach($cityinfo as $item){
    if(!$item['status'])
        continue;
    echo $item['name'].'  ';
    $domain =  $item['site_web_url'];
    //$url = 'http://www.cqmama.net/api/forum_interface/index.php';
    //$url = 'http://www.gzmama.com/api/capi_v100/threadpost.php?';
    $url = $domain.'/api/capi_v100/threadpost.php?';
	$param['appkey'] = 'mmq';
	$param['apiact']='ThreadInfo';
	$param['apido']='monitorRedis';
	//		$param['apido']='receive';

	$param['t']=time();    
	if($param['appkey'] == 'mmq')
		$secretkey = 'S3xP1Vgcsk0h2x!g9%XmkiG30eAdg';
	else if($param['appkey'] == 'ims')
		$secretkey = 'fc78176faab5c09721dea14d88806';

    $token = set_token1($param, $secretkey);
    $param['token']=$token;     
	$urlparam = loopParam($param);
	$url = $url."?$urlparam";
	$ret = curl_get($url);
    echo $ret;
    echo '<br><br>--------------------------------<br>';
}

exit;



//   $url = 'http://www.cqmama.net/api/forum_interface/index.php';
$url = 'http://www.gzmama.com/api/forum_interface/index.php';

/*----------------mmq------------------*/
/*
		$param['appkey'] = 'mmq';
		$param['apiact']='Thread';
//	  $param['apido']='getHotThreads';
	  $param['apido']='getHotThreadsForBk';
		$param['pagesize']=5;    
 */
		/*----------------ims------------------*/
		$param['appkey'] = 'ims';
		$param['apiact']='Ims';
//		$param['apido']='getHotThreads';
$param['apido']='receive';

		$param['page']=3;
		$param['perpage']=10;

		$param['t']=time();    
		if($param['appkey'] == 'mmq')
			$secretkey = 'S3xP1Vgcsk0h2x!g9%XmkiG30eAdg';
		else if($param['appkey'] == 'ims')
			$secretkey = 'fc78176faab5c09721dea14d88806';


    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     

		
		$urlparam = loopParam($param);
		$url = $url."?$urlparam";
//		echo $url;exit;
		$ret = curl_get($url);

    echo $ret;
		exit;



/*
        $url='http://www.gzmama.com/thread-4012779-1-1.html';  
        $tempu=parse_url($url);  
				$domain=$tempu['host'];  
				$d = str_replace('www.','',$domain);
				echo $d;exit;
				echo $domain;exit;
 */

//header("Content-type: application/json");
/*
//$url = "http://www.cqmama.net/api/forum_interface/index.php?appkey=mmq&apiact=Thread&apido=getHotThreads&t=1456825249&token=CFF1DD2D88D44699218AD0707C15F320";

$url = "http://www.gzmama.com/api/forum_interface/index.php?appkey=mmq&apiact=Thread&apido=getHotThreads&t=1456825249&token=CFF1DD2D88D44699218AD0707C15F320";

$res = curl_get($url);
echo $res;exit;
echo json_encode($res);exit;

 */






/*
$str = '<img src="/home/pc/js/editor/image/smiley/default/lol.gif" smilieid="12" border="0" alt="" />';
$str = "赞一个<img src='http://api.glmama.com/static/image/smiley/wangwang/wanwan02.gif' ></img>";
//$str = "赞一个<img>55</img>";
echo 'str1='.$str.'<br>';
//if(preg_match('/\[attachimg\]([0-9a-zA-Z_\-]+)\[\/attachimg\]/is', $data['content'], $matches))
//if(preg_match('/\<img\>([0-9a-zA-Z_\-]+)\<\/img\>/is', $str, $matches)) 
if(preg_match('/\<img(.*?)\>([0-9a-zA-Z_\-]+)\<\/img\>/is', $str, $matches))
//if(preg_match('/\[img\](http|https):\/\/(.*?)\[\/img\]/is', $str, $matches))
  $image = $matches[1];
echo 'str2='.$image;
exit;
*/

/*
$title = '学英语像学母语&#32;7岁宝宝“洋话连篇”';
echo $title.'<br>';
$t = htmlspecialchars($title);
$t = strip_tags($title);
//$t = str_replace('#','',$title);
//$patterns = array();
//$t = htmlspecialchars($title);
echo $t;
exit;
 */

function changurl($url){
    //有带tid参数
    $istid=strpos($url,'tid=');
    if($istid){
        preg_match('/tid=(\d*)/', $url,$preurl);
        $tid=$preurl[1];
        if ($tid) {
            return getThreadUrl($tid);
        }
    }

    //thread-3944843-1-1.html
    $preurl=array();
    preg_match('/thread\-(\d*)\-(\d*)\-(\d*)\.html/', $url,$preurl);
    if ($preurl[0]) {
			echo json_encode($preurl);
        return $preurl[0];
    }

    //带http://直接返回
    if (strpos($url,'http://') !== false || strpos($url,'https://') !== false  ||strpos($url,'www.') !== false){
        return $url;
    }

    //直接加pc域名，放回链接
    $domain = 'http://www.'.ApiBase::$config['site']['domain'];
    return $domain.'/'.$url;

}


function getTid($url){
    //有带tid参数
    $istid=strpos($url,'tid=');
    if($istid){
        preg_match('/tid=(\d*)/', $url,$preurl);
        $tid=$preurl[1];
        if($tid>0)
            return $tid;
    }

    //thread-3944843-1-1.html
    $preurl=array();
    preg_match('/thread\-(\d*)\-(\d*)\-(\d*)\.html/', $url,$preurl);
    if($preurl[1]>0){
        return $preurl[1];
    }
    
    return 0;
    
}
/*
$url = "http://www.gzmama.com/thread-4509400-1-1.html";
$url = "forum.php?mod=viewthread&tid=4498359";
$ret = getTid($url);
echo 'ret='.$ret;
exit;
 */

header("Content-type: application/json");

		$url = 'http://city.capi.gzmama.com/forum_v200/thread/userThreadList00';

		$param['app'] = 'tcq_android';
		$param['uid'] = '9635152';
    $param['ver'] = '2.0.0';
		$param['t'] = time();
//		$param['check_token'] = 'no';
	//	$param['domain'] = 'gzmama.com';
    //$param['cityID']='289';
    
    $secretkey = '2jiav274pUu@f(WK&tj0r$Zrj12HjVN7';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
		$param['token']=$token;     

		$urlparam = loopParam($param);
		$url = $url."?$urlparam";
		echo $url;
    $ret = curl_get($url);

    
//    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
		exit;


//$url = 'http://city.capi.gzmama.com/member/v200/usercredit/userCreditInfo00';
//$url = 'http://city.capi.gzmama.com/member_v200/usercredit/userCreditInfo00';
$url = 'http://city.capi.gzmama.com/forum_v200/Updatememberthread/getMemberThreads00';

		$param['app'] = 'tcq_android';
		$param['uid']='9635152';
    $param['ver']='2.0.0';
		$param['t']=time();
		$param['check_token'] = 'no';
		$param['domain'] = 'gzmama.com';
    //$param['cityID']='289';
    
    $secretkey = '2jiav274pUu@f(WK&tj0r$Zrj12HjVN7';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
		$param['token']=$token;     

		$urlparam = loopParam($param);
		$url = $url."?$urlparam";
//		echo $url;
    $ret = curl_get($url);

    
//    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;



$url = 'http://www.gzmama.com/api/forum_interface/index.php';
		
		/*----------------mmq------------------*/
		
		$param['appkey'] = 'mmq';
		$param['apiact']='Thread';
	  $param['apido']='getHotThreads';
		 

		/*----------------ims------------------*/
		/*
		$param['appkey'] = 'ims';
		$param['apiact']='Ims';
		$param['apido']='getHotThreads';
		//		$param['apido']='receive';
	  */


		$param['t']=time();    
		if($param['appkey'] == 'mmq')
			$secretkey = 'S3xP1Vgcsk0h2x!g9%XmkiG30eAdg';
		else if($param['appkey'] == 'ims')
			$secretkey = 'fc78176faab5c09721dea14d88806';


    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     

		
		$urlparam = loopParam($param);
		$url = $url."?$urlparam";
//		echo $url;exit;
		$ret = curl_get($url);
//SELECT *,FROM_UNIXTIME(createtime) FROM `pre_app_sign_record` WHERE uid=21567543 

//$ret = curl_post($url,$param);

    //echo json_encode($ret);
    echo $ret;
		exit;

    $url = 'http://hd.mama.cn/gz/Index/getUnreadNum/';
    //$param['cityID']='289';
    
    $secretkey = '2jiav274pUu@f(WK&tj0r$Zrj12HjVN7';
//    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
  //  $param['token']=$token;     
    
    $ret = curl_get($url);
    //echo json_encode($ret);
    echo $ret;
exit;


    $url = 'http://m.capi.gzmama.com/member/v200/usercredit/useroutinfo?';
		$param['app'] = 'gzq_android';
		$param['uid']='9635152';
    $param['ver']='2.0.0';
    $param['t']=time();
    //$param['cityID']='289';
    
    $secretkey = '2jiav274pUu@f(WK&tj0r$Zrj12HjVN7';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;

$url = 'http://hd.mapi.mama.cn/gzq/Activity/getMyActivity?';
    $param['uid']='6337094';
    $param['ver']='2.0.0';
    $param['t']=time();
    //$param['cityID']='289';
    
    $secretkey = 'ec973409f656c9085924be2030128d15';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;




$url = 'http://m.capi.gzmama.com/show/v100/thread/list?';
//$url = 'http://m.capi.gzmama.com/show/v100/send/thread?';
//$url = 'http://m.capi.gzmama.com/show/v100/thread/post?';
//source=2&app=mmq&ver=5.4.0&uid=9943356&page=1&perpage=20&code=54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622&cityID=163&categoryid=1&t=1439259952&token=16011CCB60BDED563FB39C2378BC601B
    $param['source']='2';
    $param['check_token']='no';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['tid']='3997364';
    $param['pid']=0;
    $param['parsemessage']='2';
    
    $param['cid']='1';
    $param['prepage']='20';
    $param['page']='1';
    $param['first']='1';
//    $param['categoryid']=1;
//    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['uid']='9635152';

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;
/*
header("Content-type: application/json");

$url = 'http://m.capi.gzmama.com/show/v100/thread/list?';
//$url = 'http://m.capi.gzmama.com/show/v100/send/thread?';
//$url = 'http://m.capi.gzmama.com/show/v100/thread/post?';
//source=2&app=mmq&ver=5.4.0&uid=9943356&page=1&perpage=20&code=54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622&cityID=163&categoryid=1&t=1439259952&token=16011CCB60BDED563FB39C2378BC601B
    $param['source']='2';
    $param['check_token']='no';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['cid']='1';
    $param['message']='QQQQQWWWWWWWWE798';
    $param['attach']='WyJodHRwOlwvXC9pbWcwLmltZ3RuLmJkaW1nLmNvbVwvaXRcL3U9MzUxMjQ5MTMyMywxMjY1NDk3MDQ1JmZtPTIxJmdwPTAuanBnIl0=';
//    $param['categoryid']=1;
//    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['uid']='9635152';

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;
*/


    $url = 'http://m.capi.gzmama.com/pms/v100/pms/send?';
    //source=2&app=mmq&ver=5.4.0&uid=9943356&page=1&perpage=20&code=54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622&cityID=163&categoryid=1&t=1439259952&token=16011CCB60BDED563FB39C2378BC601B
    $param['source']='2';
    $param['check_token']='no';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['username']='lxjs';
    $param['hash']='26f6b11031c85157f3e7fd68c997afaf';
    $param['touid']='6216188';
    //$param['pmid']=11110212;
    $param['message']='Hello';
    //$param['pmid']=11110212;
    $param['device_id']='8d6361ebe34de91e1dcc886d842cdf3bb1';
    $param['dg']='ml';
        
    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['uid']='16016019';
    $param['subject']='hel';
    //$param['uid']='6337094';
    

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;


//$url = 'http://m.capi.gzmama.com/show/v100/thread/list?';
//$url = 'http://m.capi.gzmama.com/show/v100/send/thread?';
$url = 'http://m.capi.gzmama.com/show/v110/send/thread?';
//source=2&app=mmq&ver=5.4.0&uid=9943356&page=1&perpage=20&code=54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622&cityID=163&categoryid=1&t=1439259952&token=16011CCB60BDED563FB39C2378BC601B
    $param['source']='2';
    $param['check_token']='no';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['cid']='1';
    $param['message']='QQQQQWWWWWWWWE798';
    $param['attach']='WyJodHRwOlwvXC9pbWcwLmltZ3RuLmJkaW1nLmNvbVwvaXRcL3U9MzUxMjQ5MTMyMywxMjY1NDk3MDQ1JmZtPTIxJmdwPTAuanBnIl0=';
//    $param['categoryid']=1;
//    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['uid']='9635152';

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;

$url = 'http://hd.mapi.mama.cn/detail/getReview?';
//$url = 'http://hdapi.mama.cn/detail/getReview?';
$param['source']='2';
$param['app']='mmq';
$param['ver']='5.4.0';
$param['cityID']='289';

$param['code']='54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622';
//$param['aid']=4096937;
$param['aid']=4091856;
//$param['aid']=4102519;
//$param['uid']=9943349;
$param['uid']=696960;
//$param['content']='test发表回顾';
$param['t']=time();

$secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
$token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
$param['token']=$token;     

$ret = curl_post($url,$param);
//echo json_encode($ret);

echo $ret;
exit;


$url = 'http://hd.mapi.mama.cn/detail/createReview?';
//$url = 'http://hdapi.mama.cn/detail/createReview?';
$param['source']='2';
$param['app']='mmq';
$param['ver']='5.4.0';
$param['cityID']='289';

$param['code']='54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622';
//$param['aid']=4096937;
$param['aid']=4091856;
//$param['aid']=4102519;
//$param['uid']=9943349;
$param['uid']=9943349;
$param['review_title']='<春天在哪里>test';
$param['content']='test发表回顾';
$param['t']=time();

$secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
$token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
$param['token']=$token;     

$ret = curl_post($url,$param);
//echo json_encode($ret);

echo $ret;
exit;


    $url = 'http://hd.mapi.mama.cn/comment/reply?';
    //$url = 'http://hdapi.mama.cn/comment/getUserComments?';
    $param['source']='2';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['aid']='4096937';
    $param['uid']='9943646';
    $param['comment_id']='283937';
    $param['reply_user_id']='24836062';
    $param['reply_user_name']='';
    $param['content']='这么多个的';
    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['t']=time();

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;

$url = 'http://hd.mapi.mama.cn/detail/createReview?';
$param['source']='2';
$param['app']='mmq';
$param['ver']='5.4.0';
$param['cityID']='289';

$param['code']='54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622';
$param['aid']=4098551;
$param['uid']=9943349;
$param['content']='test发表回顾22';
$param['t']=time();

$secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
$token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
$param['token']=$token;     

$ret = curl_post($url,$param);
//echo json_encode($ret);
echo $ret;
exit;


/*
    $url = 'http://hd.mapi.mama.cn/comment/comment?';
    $param['source']='2';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['aid']=4096937;
    $param['uid']='9943646';
    $param['reply_user_id']='24836062';
    $param['reply_user_name']='';
    $param['content']='什么时候截止报名呢';
    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['t']=time();

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;
*/



//--list

$url = 'http://hd.mapi.mama.cn/activity/getlistbyflag?';
//source=2&app=mmq&ver=5.4.0&uid=9943356&page=1&perpage=20&code=54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622&cityID=163&categoryid=1&t=1439259952&token=16011CCB60BDED563FB39C2378BC601B
    $param['source']='2';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['code']='54dd26e4fcd6b85e5b86bd3b4f688c5b_1439260622';
    $param['page']=1;
    $param['perpage']=20;
    $param['categoryid']=1;
//    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['t']=time();

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;


/*
//---------------------------------
    $url = 'http://hd.mapi.mama.cn/comment/reply?';
    //$url = 'http://hdapi.mama.cn/comment/getUserComments?';
    $param['source']='2';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    
    $param['aid']='4098456';
    $param['uid']='9943153';
    $param['comment_id']='283708';
    $param['reply_user_id']='24836062';
    $param['reply_user_name']='';
    $param['content']='广州呢？';
    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['t']=time();

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
exit;
*/

/////////////
    $url = 'http://hd.mapi.mama.cn/comment/getUserComments?';
    //$url = 'http://hdapi.mama.cn/comment/getUserComments?';
    $param['source']='2';
    $param['app']='mmq';
    $param['ver']='5.4.0';
    $param['cityID']='289';
    $param['uid']='21308703';
    $param['page']='1';
    $param['perpage']='20';
    $param['code']='609f0af8b4f4efbe628172ce2a61bd4b_1439197397';
    $param['t']=time();

    $secretkey = 'trecU4raz5fuHEche4u5ehAprubrestu';
    $token = set_token1($param, $secretkey);
//echo 't=='.$token;exit;
    $param['token']=$token;     
    
    $ret = curl_post($url,$param);
    //echo json_encode($ret);
    echo $ret;
