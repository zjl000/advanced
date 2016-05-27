<?php 
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
 ?>

 <div class="form">
 	<?php $form = ActiveForm::begin([
 		'id' => 'myForm',
 		'options' => ['class' => 'form-horizontal', 'enctype'=>'multipart/form-data'],
 		'fieldConfig'=> [
 			'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",  
 			'labelOptions' => ['class' => 'col-lg-2 control-label']
 		]
 	]); ?>
		<div class="upload">
			<?= Html::tag('label', '作品封面') ?>	
			<div class="pic">
		    	<?php 
		    		//判断是否为新记录
		    		if($model->isNewRecord){
		    			echo Html::img('images/cover_default.png', ['alt'=>'封面图片', 'id'=>'revImg']);
		    		}else{
		    			echo Html::img("images/".$model['cover'], ['alt'=>'封面图片', 'id'=>'revImg']); 	    			
		    		} 
		    	 ?>
		    </div>
			<div class="explain">
				<?= Html::tag('p', '支持jpg、gif、png图片格式') ?>
				<?= Html::tag('p', '文件小于2M') ?>
				<?= Html::tag('p', '图片分辨率要大于200*200') ?>
				<?= Html::tag('p', '请确保图片不侵犯他人权利') ?>
				<?= Html::a('上传图片', 'javascript:;', ['class'=>'btn btn-primary', 'id'=>'uploadImg']) ?>
			</div>	
		</div>
		<input type="hidden" id="cover" name="cover" value="">

		<?= $form->field($model, 'bookname')->textInput() ?>
		<?= $form->field($model, 'subtitle')->textInput() ?>
		<div class="tag">
			<?= Html::tag('label', '标签') ?>
			<?php 
				//判断是否为新记录
				if($model->isNewRecord){
					echo Html::a('添加', 'javascript:;', ['class'=>'btn btn-info', 'id'=>'tags'] );
					echo Html::tag('span', '', ['class'=>'empty']); // 标签提示信息
					echo '<input type="hidden" id="addtag" name="addtag" value="" />';
				}else{
					$tag = $model['tag'];
					$exp = explode(';', $tag);
					foreach($exp as $v){
						echo '<span class="bbox on">'.$v.'</span>';
					}
					echo Html::a('更改', 'javascript:;', ['class'=>'btn btn-info', 'id'=>'tags'] );
					echo '<input type="hidden" id="addtag" name="addtag" value="'.$tag.'" />';
				}
			 ?>		
		</div>
		<?= $form->field($model, 'introduction')->textArea(['rows'=>4, 'cols'=>5, 'style'=>'resize:none']) ?>
		<?= $form->field($model, 'friend')->dropDownList(['0'=>'全站用户可见', '1'=>'全部好友可见', '2'=>'仅指定的好友可见', '3'=>'仅自己可见', '4'=>'凭密码查看'], ['style'=>'width:200px']) ?>
		<?= $form->field($model, 'noreply')->checkbox(['style'=>'margin-left:145px']) ?>
		<?= $form->field($model, 'publication')->dropDownList(['0'=>'回忆录', '1'=>'随笔'],['style'=>'width:200px']) ?>
		<?= $form->field($model, 'finish')->dropDownList(['0'=>'未完成', '1'=>'已完成'], ['style'=>'width:200px']) ?>
		<div class="form-group f_btn">
       		<?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'sub']) ?>
       		<?= Html::resetButton('重置', ['class'=>'btn btn-danger']) ?>
    	</div>
 	<?php ActiveForm::end(); ?>
 </div>

<div class="bg" id="bg"></div>
<div class="box">
	<div class="head">
		<h6>选择标签</h6>
		<div></div>
		<a id="close" href="javascript:;">X</a>
	</div>
	<div class="content">
		<div class="c1">
			<div class="left">行&nbsp;&nbsp;&nbsp;&nbsp;业：</div>
			<div class="right">
				<?php foreach(\Yii::$app->params['tag1'] as $v){ ?>
					<span class="bbox"><?= $v['name']; ?></span>
				<?php } ?>
			</div>
		</div>
		<div class="c1">
			<div class="left">经&nbsp;&nbsp;&nbsp;&nbsp;历：</div>
			<div class="right">
				<?php foreach(\Yii::$app->params['tag2'] as $v){ ?>
					<span class="bbox"><?= $v['name']; ?></span>
				<?php } ?>
			</div>
		</div>
		<div class="c1">
			<div class="left">自定义：</div>
			<div class="right">
				<input type="text" id="self" name="self" value="" placeholder="自定义标签">
				<a id="add" href="javascript:;">+</a>
			</div>
		</div>
	</div>
	<div class="foot">
		<a id='comfirm' href="javascript:;">确定</a>
	</div>
</div>

 <?php $this->registerJs('
	$(function(){
		$(\'#tags\').click(function(){
			$(\'.bg\').show();
			//设置box的left和top值
			var bleft = ($(window).width() - $(\'.box\').width()) / 2;
			var btop = ($(window).height() - $(\'.box\').height()) / 2;
			$(\'.box\').css({\'left\':bleft, \'top\':btop});
			$(\'.box\').toggle();
		})

		// 关闭
		$(\'#close\').click(function(){
			$(\'.box\').hide();
			$(\'.bg\').hide();
		})

		//定义数组，存放带有on类的span标签内容
		num = [];	
		// 遍历标签 (yii2中jQuery对append添加的元素，绑定事件会失效，推荐使用on绑定)
		$(\'.c1\').find(\'.right\').on(\'click\', \'span\', function(){
			//标签选中与取消
			var v = $(this).html();	
			if($(this).attr(\'class\') == \'bbox on\'){
				//删除on类
				$(this).removeClass(\'on\');
				//遍历head头部的span标签
				$(this).parents(\'.content\').prev(\'.head\').find(\'span\').each(function(){
					//删除对应的标签
					if($(this).html() == v){
						$(this).remove();
					}
					
					//删除对应的数组值
					for(var i = 0; i < num.length; i++){
						if(num[i] == v){
							num.splice(i,1);		
						}
					}
				});
			}else{					
				//限制标签		
				if(num.length >= 5){
					alert(\'最多只能选择五项！\');
				}else{
					//增加on类
					$(this).addClass(\'on\');
					//将当前span的内容放入num数组
					num.push($(this).html());
					$(this).parents(\'.content\').prev(\'.head\').find(\'div\').append(\'<span class="bbox on">\'+v+\'</span>\');	
				}	
			}	
		})

		//自定义标签
		$(\'#add\').click(function(){
			var v = $(\'#self\').val();
			if(v == \'\'){
				alert(\'请填写自定义标签！\');
			}else{
				if((v != \'\') && (num.length < 5)){
					//增加span
					$(this).parent(\'.right\').append(\'<span class="bbox on">\'+v+\'</span>\');
					$(this).parents(\'.content\').prev(\'.head\').find(\'div\').append(\'<span class="bbox on">\'+v+\'</span>\');
					//将内容插入到num数组
					num.push(v);
					//将文本框清空
					$(\'#self\').val(\'\');
				}else{
					alert(\'最多只能选择五项！\');
				}
			} 		
		})
		
		//确定
		$(\'#comfirm\').click(function(){
			if(num.length == 0){
				alert(\'请至少选择一项标签！\');
			}else{
				//删除tag类下带on类的子元素
				$(\'.tag\').children(\'.on\').remove();
				//遍历后添加
				for(var i = 0; i < num.length; i++){
					$(\'#tags\').before(\'<span class="bbox on">\'+num[i]+\'</span>\');
				}
				$(\'#tags\').html(\'更改\');	
				$(\'.box\').hide();
				$(\'.bg\').hide();
				//将数组转化为字符串，放入隐藏域中
				var str = num.join(\';\');
				//将标签添加到隐藏域
				$(\'#addtag\').val(str);
				//隐藏提示div
				$(\'.empty\').hide(); 
			}
		})
		
		//提交按钮
		$(\'#sub\').click(function(){
			//判断标签隐藏域是否为空
			if($(\'#addtag\').val() == \'\'){
				$(\'.empty\').show();
				$(\'.empty\').html(\'标签不能为空。\');
				//阻止表单提交
				return false;
			}
		})
		
		//上传图片
		$(\'#uploadImg\').click(function(){
			$(\'.bg\').show();
			//设置uploadFile的left和top值
			var bleft = ($(window).width() - $(\'.uploadFile\').width()) / 2;
			var btop = ($(window).height() - $(\'.uploadFile\').height()) / 2;
			$(\'.uploadFile\').css({\'left\':bleft, \'top\':btop});
			$(\'.uploadFile\').show();
		})

		//关闭上传图片box
		$(\'#closeImg\').click(function(){
			$(\'.bg\').hide();
			$(\'.uploadFile\').hide();
		})
	})
 ', \yii\web\View::POS_END) ?>

<!-- 图片上传 -->
<?php
	$this->registerCssFile(Yii::$app->request->baseUrl.'/css/ShearPhoto.css', ['depends' => ['frontend\assets\AppAsset']]);
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/ShearPhoto.js', ['depends' => ['frontend\assets\AppAsset']]);
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/webcam_ShearPhoto.js', ['depends' => ['frontend\assets\AppAsset']]);
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/alloyimage.js', ['depends' => ['frontend\assets\AppAsset']]);
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/handle.js', ['depends' => ['frontend\assets\AppAsset']]);
 ?>

<div class="uploadFile" id="uploadFile">
	<span id="cup">封面图片上传</span>
	<a id="closeImg" class="btn btn-danger" href="javascript:;">关闭</a>

	<div id="shearphoto_main">
		<!--primary范围开始-->
		<div class="primary">
			<!--main范围开始-->
			<div id="main">
				<div class="point">
				</div>
				<!--选择加载图片方式开始-->
				<div id="SelectBox">
					<form id="ShearPhotoForm" enctype="multipart/form-data" method="post" target="POSTiframe">
						<input name="shearphoto" type="hidden" value="我要传参数" autocomplete="off">
						<!--示例传参数到服务端，后端文件UPLOAD.php用$_POST['shearphoto']接收,注意：HTML5切图时，这个参数是不会传的-->
						<a href="javascript:;" id="selectImage">
							<input type="file" name="UpFile" autocomplete="off" />
						</a>
					</form>
					<!-- <a href="javascript:;" id="PhotoLoading"></a>
					<a href="javascript:;" id="camerasImage"></a> -->
				</div>
				<!--  选择加载图片方式结束  --->
				<div id="relat">
					<div id="black">
					</div>
					<div id="movebox">
						<div id="smallbox">
							<img src="images/default.gif" class="MoveImg" />
							<!--  截框上的小图  -->
						</div>
						<!--动态边框开始-->
						<i id="borderTop">
	                        </i>

						<i id="borderLeft">
	                        </i>

						<i id="borderRight">
	                        </i>

						<i id="borderBottom">
	                        </i>
						<!--动态边框结束-->
						<i id="BottomRight">
	                        </i>
						<i id="TopRight">
	                        </i>
						<i id="Bottomleft">
	                        </i>
						<i id="Topleft">
	                        </i>
						<i id="Topmiddle">
	                        </i>
						<i id="leftmiddle">
	                        </i>
						<i id="Rightmiddle">
	                        </i>
						<i id="Bottommiddle">
	                        </i>
					</div>
					<img src="images/default.gif" class="BigImg" />
					<!--MAIN上的大图-->
				</div>
			</div>
			<!--main范围结束-->
			<div style="clear: both"></div>
			<!--工具条开始-->
			<div id="Shearbar">
				<a id="LeftRotate" href="javascript:;">
					<em>
	                </em> 向左旋转
				</a>
				<em class="hint L">
	        	</em>
				<div class="ZoomDist" id="ZoomDist">
					<div id="Zoomcentre">
					</div>
					<div id="ZoomBar">
					</div>
					<span class="progress">
	                </span>
				</div>
				<em class="hint R">
	       		 </em>
				<a id="RightRotate" href="javascript:;">
	                向右旋转
	                <em>
	                </em>
	        	</a>
				<!-- <p class="Psava"> -->
					<a id="againIMG" href="javascript:;">重新选择</a>
					<a id="saveShear" href="javascript:;">保存截图</a>
				<!-- </p> -->
			</div>
			<!--工具条结束-->
		</div>
		<!--primary范围结束-->
		<div style="clear: both"></div>
	</div>
	<!--shearphoto_main范围结束-->
</div>



 