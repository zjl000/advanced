<?php 
	namespace frontend\models;
	use yii\db\ActiveRecord;
	use frontend\models\User_profile;
	use frontend\models\Memoirs_reply;
	use yii\web\UploadedFile;
	
	class Memoirs extends ActiveRecord{
		// public $cover;
		
		public function rules(){
			return [
				[['bookname', 'subtitle', 'cover', 'introduction', 'noreply', 'friend','finish', 'publication'], 'required'],	
				[['bookname', 'subtitle'], 'string', 'max'=>80],
				// [['cover'], 'file', 'extensions'=>'jpg, png, gif'],
				[['cover', 'introduction'],'safe'],
				[['noreply', 'friend', 'finish', 'publication'], 'integer']
			];
		} 

		//标签
		public function attributeLabels(){
			return [
				// 'cover'=>'作品封面',
				'bookname'=>'作品名称',
				'subtitle'=>'副标题',
				'tag'=>'作品标签',
				'introduction'=>'作品简介',
				'friend'=>'隐私设置',
				'noreply'=>'不允许评论',
				'publication'=>'文体类型',
				'finish'=>'完成状态',
			];
		}

		//获取用户信息
		public function getUser(){
			return $this->hasOne(User_profile::className(),['user_id'=>'uid']);
		}
	}
 ?>