<?php 
	namespace frontend\models;
	use yii\db\ActiveRecord;
	use frontend\models\User;
	
	class Memoirs_reply extends ActiveRecord{
		//查询评论对应的用户信息
		public function getUser(){
			return $this->hasOne(User::className(), ['id'=>'uid']);
		}
	}
 ?>