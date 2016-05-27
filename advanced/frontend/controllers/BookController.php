<?php 
	namespace frontend\controllers;
	use yii\web\Controller;
	use frontend\models\Memoirs;
	use frontend\models\Memoirs_tag;
	use yii\data\Pagination;
	use yii\helpers\HtmlPurifier;

	class BookController extends Controller{
		public $layout = 'public';
		public function actionIndex(){
			header('content-type:text/html;charset=utf-8');
			//行业标签
			$tag1 = Memoirs_tag::find()->where(['pid'=>1])->asArray()->all();

			//经历标签
			$tag2 = Memoirs_tag::find()->where(['pid'=>2])->asArray()->all();

			//分页
			$pagination = new Pagination([
	            'defaultPageSize' => 5,
	            'totalCount' => Memoirs::find()->count(),
	        ]);

			//没有筛选条件时，设置默认传递过来的条件参数为空
	        $status = '';
			$tagid0 = '';
			$tagid1 = '';
			$search = '';
			
			//筛选传递过来的查询条件
			if(\YII::$app->request->post()){
				$request = \YII::$app->request;
				$status = $request->post('status');//出版状态
				$tagid0 = $request->post('tagid0');
				$tagid1 = $request->post('tagid1');
				$search = HtmlPurifier::process($request->post('m-search')); 

				//根据传递过来的标签ID，找出对应的标签名
				if($tagid0 != ''){
					$t0 = Memoirs_tag::find()->where(['tagid'=>$tagid0])->one();
					$tname0 = $t0->name;	
				}
				if($tagid1 != ''){
					$t1 = Memoirs_tag::find()->where(['tagid'=>$tagid1])->one();
					$tname1 = $t1->name;
				}

				//设置默认值
				$status = ($status != '') ? $status : '';
				$tagid0 = ($tagid0 != '') ? $tagid0 : '';
				$tagid1 = ($tagid1 != '') ? $tagid1 : '';
				$search = ($search != '') ? $search : '';

				//筛选查询条件
				//状态
				if($status != ''){
					$data = Memoirs::find()->where(['publication'=>$status]);	
				}else{
					$data = Memoirs::find();
				}
				//行业
				if(!empty($tagid0)){
					$data = $data->andWhere(['like', 'tag', $tname0]);
				}
				//经历
				if(!empty($tagid1)){
					$data = $data->andWhere(['like', 'tag', $tname1]);
				}
				//搜索查询
				if(!empty($search)){
					$data = $data->andWhere(['like', 'bookname', $search]);
					$data = $data->orWhere(['like', 'username', $search]);
				}

				//根据条件查询对应数据
				$data = $data->orderby('viewnum desc')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();

				// echo '<pre>';
				// print_r(\YII::$app->request->post());die;						
			}else{
				//没有筛选条件时的所有数据
				$data = Memoirs::find()->orderby('viewnum desc')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			}

			//查询数据总数
			$count = count($data);

			// echo $count;die;

			//跳转
			return $this->render('index',['tag1'=>$tag1, 'tag2'=>$tag2, 'data'=>$data, 'pagination'=>$pagination, 'count'=>$count, 'status'=>$status, 'tagid0'=>$tagid0, 'tagid1'=>$tagid1, 'search'=>$search]);
		}
	}
 ?>