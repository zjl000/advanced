<?php use yii\helpers\Url; ?>
<link rel="stylesheet" type="text/css" href="../web/css/cover.css" />
<script src="../web/js/common.js" type="text/javascript"></script>

<div id="m-cover">
    <!-- 判断章节或卷是否存在 -->
    <?php if(!isset($chapter) && !isset($volume)){?>
        <a href="">
            <img src="images/<?= $data['cover']; ?>" alt="<?= $data['bookname']; ?>" />
        </a>
    <?php }elseif(!empty($volume)){ foreach($volume as $v){ if(!empty($v['chapter'])){ foreach($v['chapter'] as $chapter){ $cid[] = $chapter['chapterid']; } } } ?>
        <a href="<?= Url::to(['read/content', 'chapterid'=>$cid[0]]); ?>">
            <img src="images/<?= $data['cover']; ?>" alt="<?= $data['bookname']; ?>" />
        </a>     
    <?php }else{ if(isset($chapter)){ foreach($chapter as $row){ $rid[] = $row['chapterid']; } ?>
        <a href="<?= Url::to(['read/content', 'chapterid'=>$rid[0]]); ?>">
            <img src="images/<?= $data['cover']; ?>" alt="<?= $data['bookname']; ?>" />
        </a> 
    <?php } } ?>
        
</div>

<div id="begin-read">
    <!-- 判断章节或卷是否存在 -->
    <?php if(!isset($chapter) && !isset($volume)){ ?>
        <a class="ks_read" href="">开始阅读</a>      
    <?php }elseif(!empty($volume)){ foreach($volume as $v){ if(!empty($v['chapter'])){ foreach($v['chapter'] as $chapter){ $cid[] = $chapter['chapterid']; } } } ?>
        <a class="ks_read" href="<?= Url::to(['read/content', 'chapterid'=>$cid[0]]); ?>">开始阅读</a>      
    <?php }else{ if(isset($chapter)){ foreach($chapter as $row){ $rid[] = $row['chapterid']; } ?>
        <a class="ks_read" href="<?= Url::to(['read/content', 'chapterid'=>$rid[0]]); ?>">开始阅读</a>
    <?php } } ?>
    <a class="zp_des" href="<?= Url::to(['read/index', 'read'=>'author', 'id'=>$data['bookid']]); ?>">作品简介</a>
</div>

<script type='text/javascript'>
    var e = jQuery("#m-cover");
    var b = jQuery("#begin-read");
    var j = function() {
        if(self.innerHeight) {
            this.winWidth = self.innerWidth;
            this.winHeight = self.innerHeight
        }else{      
            if(document.documentElement && document.documentElement.clientHeight){
            alert(document.documentElement.clientHeight);
                this.winWidth = document.documentElement.clientWidth;
                this.winHeight = document.documentElement.clientHeight
            }else{
                if (document.body) {
                    this.winWidth = document.body.clientWidth;
                    this.winHeight = document.body.clientHeight
                }
            }
        }
        return [this.winWidth, this.winHeight]
    };

    var l = jQuery(window).scrollTop();
    e.css({
        top: (j()[1] - e.height()) / 2 + l
    });

    b.css({
        top: (j()[1] - b.height()) / 2 + l - 180
    });
</script>
