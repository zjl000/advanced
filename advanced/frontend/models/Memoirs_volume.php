<?php 
	namespace frontend\models;
	use yii\db\ActiveRecord;
	use frontend\models\Memoirs_chapter;
	
	class Memoirs_volume extends ActiveRecord{
		public function getChapter(){
			return $this->hasMany(Memoirs_chapter::className(),['bookid'=>'bookid', 'volumeid'=>'volumeid']);
		}
	}
 ?>