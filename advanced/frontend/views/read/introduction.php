<?php use yii\helpers\Url; ?>
<link rel="stylesheet" type="text/css" href="../web/css/author.css" />
<script src="../web/js/common.js" type="text/javascript"></script>
<script type="text/javascript" src='../web/js/author.js'></script>

<div id="m-author">
    <div class="a-inner">
        <div class="book-top">作品信息</div>

        <div class="book-middle cl">
            <div class="author-info">
                <a class="a-avatar" href="home.php?mod=space&amp;uid=277">
                    <img class="img-down" src="other/avatar.php">
                    <img class="img-up" src="images/img_up.png">
                </a>
                <div class="a-name">
                    <a href="home.php?mod=space&amp;uid=277"><?= $data['username']; ?></a>
                    <p><?= $user['position']; ?></p>
                </div>
            </div>

            <p class="author-des"><?= $user['bio']; ?></p>				
        </div>

        <div class="book-bottom">           	
            <div class="author-intro">
                <h2>内容简介</h2>
                    <p><?= $data['introduction']; ?></p>
            </div>
        </div>
    </div>
</div>

<div id="begin-read">
    <a class="tri" href="javascript:;">目 录</a>
    <div class="catalog-box">
        <div class="hd">
            <h2>目录</h2>
        </div>

        <div class="bd">
            <!-- 判断卷是否为空，不为空则遍历所有卷名 -->
            <?php if(!empty($volume)){ foreach($volume as $v){ ?>
                <dl>
                    <dt><span><?=$v['volumename'];?></span></dt>
                    <!-- 判断卷对应的章节是否为空，不为空则遍历所有对应的章节 -->
                    <?php if(!empty($v['chapter'])){ foreach($v['chapter'] as $chapter){ ?>
                        <dd class="c-teshu"><a href="<?= Url::to(['read/content', 'chapterid'=>$chapter['chapterid']]); ?>"><?= $chapter['subject']; ?></a></dd>
                    <?php } } ?>
                </dl>
            <?php } }else{ ?>
                <dl>
                    <!-- 卷不存在时，遍历所有的章节 -->
                    <?php foreach($chapter as $row){ ?>					
                        <dt><a href="<?= Url::to(['read/content', 'chapterid'=>$row['chapterid']]); ?>"><?= $row['subject']; ?></a></dt>
                    <?php } ?>
                </dl>
            <?php } ?>
            <dl class="zuihou"></dl>
        </div>
    </div>
    
    <?php if(!empty($volume)){ foreach($volume as $v){ if(!empty($v['chapter'])){ foreach($v['chapter'] as $chapter){ $cid[] = $chapter['chapterid']; } } } ?>
        <a class="ks_read" href="<?= Url::to(['read/content', 'chapterid'=>$cid[0]]); ?>">开始阅读</a>      
    <?php }else{ foreach($chapter as $row){ $rid[] = $row['chapterid']; } ?>
        <a class="ks_read" href="<?= Url::to(['read/content', 'chapterid'=>$rid[0]]); ?>">开始阅读</a>
    <?php } ?>

</div>
