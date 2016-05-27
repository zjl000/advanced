<?php 
    use yii\helpers\Url;  
    use yii\web\View;
    use frontend\models\User;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
        <title>和叶</title>
        <meta name="keywords" content="" />
        <meta name="description" content=",和叶" />
        <meta name="generator" content="Discuz! X3" />
        <meta name="author" content="Discuz! Team and Comsenz UI Team" />
        <meta name="copyright" content="2001-2013 Comsenz Inc." />
        <meta name="MSSmartTagsPreventParsing" content="True" />
        <meta http-equiv="MSThemeCompatible" content="Yes" />
        <link rel="stylesheet" type="text/css" href="../web/css/style_2_common.css" />
        <script type="text/javascript">
            var STYLEID = '2', STATICURL = '', IMGDIR = 'image/common', VERHASH = 'H2L', charset = 'gbk', discuz_uid = '0', cookiepre = 'o8E4_2132_', cookiedomain = '', cookiepath = '/', showusercard = '1', attackevasive = '0', disallowfloat = 'newthread', creditnotice = '1|威望|,2|金钱|,3|贡献|', defaultstyle = '', REPORTURL = 'aHR0cDovL2hleWUub25saW5lL21lbW9pcnMucGhwP21vZD1jb3ZlciZib29raWQ9MTE=', SITEURL = 'http://heye.online/', JSPATH = 'js/', DYNAMICURL = '';</script>
        
        <!-- <link rel="stylesheet" type="text/css" href="../web/css/cover.css" /> -->
        <!-- <link rel="stylesheet" type="text/css" href="../web/css/author.css" /> -->
        <link rel="stylesheet" type="text/css" href="../web/css/reply.css" />
        <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script type="text/javascript" src='../web/js/reply.js'></script>
        <script type="text/javascript" src='../web/js/home.js'></script>

        <script type='text/javascript'>
            jQuery.noConflict();
            var url = 'memoirs.php?mod=cover&bookid=11';    
        </script>
    </head>

    <body>
        <div id="m-sidebar" class="m-wrap">
            <div class="m-back">
                <a href="./"></a>
            </div>

            <div class="m-inner">       
                <div class="m-area">            
                    <div class="m-boundary">
                        <a class="switchs" href="javascript:;"></a>
                    </div>

                    <div class="pay-end"></div>
                    <div class="book-info">
                        <div class="book-title">
                            <span title="<?= \YII::$app->params['data']['bookname']; ?>"><?= \YII::$app->params['data']['bookname']; ?></span>
                        </div>                                  

                        <div class="book-cover">
                            <a href="<?= Url::to(['read/index','id'=>\YII::$app->params['data']['bookid']]); ?>">
                                <img class="cover-img" alt="<?= \YII::$app->params['data']['bookname']; ?>" src="images/<?= \YII::$app->params['data']['cover']; ?>">
                            </a>
                        </div>              

                        <p class="book-author">作者：<a target="_blank" href="home.php?mod=space&amp;uid=277"><?= \YII::$app->params['data']['username']; ?></a></p>
                    </div>

                    <div class="pay-end"></div>
                    <div class="book-comment">
                        <a href="javascript:;" onclick="comment()">评论&nbsp;<span><?= \YII::$app->params['data']['replynum']; ?></span></a>
                    </div>          
                </div>      
            </div>   
        </div>

        <script>
            jQuery(document).ready(function(){
                var hideArea = jQuery("#m-sidebar");
                    jQuery(".switchs").click(function(){
                        if(hideArea.hasClass("hide-pay-area")) {
                            hideArea.removeClass("hide-pay-area");
                        } else {
                            hideArea.addClass("hide-pay-area");
                        }
                    });
            });
        </script>  
        
        <!-- 加载各视图内容 -->
        <?= $content; ?>

        <!-- 评论内容 -->
        <div id="comment_bg"></div>
        <div class="comment_box">
            <div class="c_hd">
                <h3><span>评论：
                <strong><?= \YII::$app->params['data']['bookname']; ?></strong></span>
                <span class="c_size">（<em><?= \YII::$app->params['data']['replynum']; ?></em>条）</span>
                </h3>
                <a class="c_close" title="关闭" href="javascript:;"></a>
            </div>

            <div class="c_bd">
                <div class="c_content">
                    <div class="c_frame">
                        <form>
                            <input type="hidden" name="_csrf" id="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="bookid" id="bookid" value="<?= \YII::$app->params['data']['bookid'] ?>" />
                            <input type="hidden" name="buid" id="buid" value="<?= \YII::$app->params['data']['uid'] ?>" />
                            <input type="hidden" name="username" id="username" value="<?= \YII::$app->params['username'] ?>" />
                            <table width="100%" cellpadding=0 cellspacing=0>
                                <tr>
                                    <td class="vt col2">                                                                
                                        <div class="contentwrap">
                                            <!-- 判断用户是否登录  -->
                                            <?php if(!isset(\YII::$app->params['login']) && \YII::$app->params['login'] !== 2){ ?>
                                                <div class='c_pt'>
                                                    您需要登录后才可以评论&nbsp;&nbsp;<a href='<?= Url::to(['site/login', 'bookid'=>\YII::$app->params['data']['bookid']]); ?>' onclick="showWindow('login', this.href)">登录</a>&nbsp;|&nbsp;<a href='member.php?mod=register'>立即注册</a>
                                                </div>
                                            <?php }else{ ?>
                                                <textarea id="content"></textarea>
                                            <?php } ?>
                                        </div>
                                        <div class="bottombar">
                                            <p class="size-leave">还能输入500字</p>
                                            <p class="emotion"><a id="comment_face" class="show-emotion" onclick="showFace(this.id, 'content');" href="javascript:;" title="插入表情"></a></p>
                                            <p class="c_btn"><a class="c_submit" href="javascript:;">评论</a></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    
                    <ul class="c_list">
                        <!-- 遍历当前书籍的评论数据 -->
                        <?php foreach(\YII::$app->params['reply'] as $v){ ?>
                            <li class="J_ItemLi">
                                <!-- 判断回复是否存在 -->
                                <?php if($v['authorid'] != 0){ ?>
                                    <div class="head-pic2">
                                        <a href="home.php?mod=space&amp;uid=1" target="_blank"><img src="other/avatar.php" width=60 height=60 /></a>
                                        <a class="c_author" href="home.php?mod=space&amp;uid=1" target="_blank"><?php $user=User::findOne($v['authorid']); echo $user->username; ?></a>
                                    </div>
                                    <!-- 显示表情 -->
                                    <?php $p='/\[em:(\d+):\]/'; preg_match_all($p, $v['message'], $res); if(!empty($res[1])){foreach($res[1] as $val){ $v['message']=str_replace('[em:'.$val.':]','<img src="images/smiley/'.$val.'.gif" />',$v['message']); }  ?>
                                        <p class="c_desc">
                                            <span style="display: block;">回复&nbsp;&nbsp;<a href="home.php?mod=space&uid=2" style="color:#327d99"><?= $v['user']['username']; ?></a>：</span>  <?= $v['message']; ?>
                                        </p>
                                    <?php }else{ ?>
                                        <p class="c_desc">
                                            <span style="display: block;">回复&nbsp;&nbsp;<a href="home.php?mod=space&uid=2" style="color:#327d99"><?= $v['user']['username']; ?></a>：</span>  <?= $v['message']; ?>
                                        </p>
                                    <?php } ?>
                                    
                                <?php }else{ ?>
                                    <div class="head-pic2">
                                        <a href="home.php?mod=space&amp;uid=1" target="_blank"><img src="other/avatar.php" width=60 height=60 /></a>
                                        <a class="c_author" href="home.php?mod=space&amp;uid=1" target="_blank"><?= $v['user']['username']; ?></a>
                                    </div>
                                    <!-- 显示表情 -->
                                    <?php $p='/\[em:(\d+):\]/'; preg_match_all($p, $v['message'], $res); if(!empty($res[1])){foreach($res[1] as $val){ $v['message']=str_replace('[em:'.$val.':]','<img src="images/smiley/'.$val.'.gif" />',$v['message']); }  ?>
                                        <p class="c_desc"><?= $v['message']; ?></p>
                                    <?php }else{ ?>
                                        <p class="c_desc"><?= $v['message']; ?></p>
                                    <?php } ?>
                                <?php } ?>
                                <p class="c_act">
                                    <span><?php date_default_timezone_set('PRC'); echo date('Y-m-d H:i:s',$v['dateline']); ?></span>
                                    <!-- 判断用户是否登陆 -->
                                    <?php if(isset(\YII::$app->params['login']) && (\YII::$app->params['login'] == 2)){ ?>
                                        <a onclick="reply(this)" href="javascript:;">回复</a>
                                    <?php }else{ ?>
                                        <a onclick="r_nologin()" href="javascript:;">回复</a>
                                    <?php } ?>
                                    <!-- 判断用户是否登陆，且登陆用户是否是书籍作者，若是，则可以删除 -->
                                    <?php if(isset(\YII::$app->params['login']) && (\YII::$app->params['login'] == 2) && (\YII::$app->session->get('uid') == \YII::$app->params['data']['uid'])){ ?>
                                        <a key="<?= $v['replyid'] ?>" onclick="delreply(this)" href="javascript:;">删除</a>
                                    <?php } ?>
                                        
                                    
                                    <!--<a href="#">举报</a>-->
                                    <!-- 评论用户ID，并判断回复是否存在，若存在则用户ID为回复人ID -->
                                    <?php if($v['authorid'] != 0){ ?>
                                        <input type="hidden" name="uid" value="<?= $v['authorid']; ?>" />
                                    <?php }else{ ?>
                                        <input type="hidden" name="uid" value="<?= $v['uid']; ?>" />
                                    <?php } ?>
                                    <!-- 书籍ID -->
                                    <input type="hidden" name="bookid" value="<?= $v['bookid']; ?>" />
                                    <!-- 作者名 -->
                                    <input type="hidden" name="author" value="<?= $v['author']; ?>" />
                                </p>
                                <div class="reply-box-wrap"></div>                  
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>