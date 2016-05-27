<?php 
	namespace frontend\models;
	use yii\db\ActiveRecord;
	
	class Memoirs_tag extends ActiveRecord{
		public function rules(){
			return [
				[['tagid','pid'],'integer'],
				['name','string','length'=>45]
			];
		}
	}
 ?>