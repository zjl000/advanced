<?php 
	namespace frontend\controllers;
	use yii\web\Controller;
	use frontend\models\Memoirs;

	class RecommandController extends Controller{
		//布局文件
		public $layout = 'public';

		public function actionIndex(){
			//查询回忆录表，返回4条数据
			$data = Memoirs::find()->limit(6)->asArray()->all();
			// echo "<pre>";
			// print_r($data);die;
			return $this->render('index',['data'=>$data]);
		}

		//用户单击阅读后，将回忆录表里的阅读量+1
		public function actionUpdate(){
			//判断是否通过Ajax传值
			if(\YII::$app->request->isAjax){
				$bookid = \YII::$app->request->get('bookid');

				//查询回忆录表
				$memoirs = Memoirs::findOne($bookid);
				//阅读量+1，updateCounters是yii2自带的计数静态方法
				// $memoirs->viewnum = $memoirs->viewnum + 1;
				$memoirs->updateCounters(['viewnum'=>1]);

				//更新
				$memoirs->save();
			}
		}
	}
 ?>