<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\UserProfile;
use frontend\models\Memoirs;
use yii\web\UploadedFile;
use frontend\models\Memoirs_tag;
use yii\data\Pagination;

class SpaceController extends Controller {
	public $layout = 'space';
	public $layout_data;
	public $navarr = array('index' => '主页', 'memoirs' => '往事', 'profile' => '个人资料', 'set' => '设置');

	//主页
	public function actionIndex() {	
		//用户信息	
		$userprofile = UserProfile::find()->where(['user_id' => $_GET['uid']])->one();		
		$user = $userprofile->hasOne(User::className(), ['id'=>'user_id'])->asArray()->one();
		$this->layout_data['account'] = $user['nickname']?$user['nickname']:$user['username'];
		$this->layout_data['motto'] = $userprofile['motto']?$userprofile['motto']:'还没有编辑个人签名！';
		$this->layout_data['avatar'] = $userprofile['avatar']?$userprofile['avatar']:'/res/site/noavatar.gif';
		return $this->render('index');
	}

	//回忆录信息
	public function actionMemoirs() {	
		//用户信息	
		$userprofile = UserProfile::find()->where(['user_id' => $_GET['uid']])->one();		
		$user = $userprofile->hasOne(User::className(), ['id'=>'user_id'])->asArray()->one();
		$this->layout_data['account'] = $user['nickname']?$user['nickname']:$user['username'];
		$this->layout_data['motto'] = $userprofile['motto']?$userprofile['motto']:'还没有编辑个人签名！';
		$this->layout_data['avatar'] = $userprofile['avatar']?$userprofile['avatar']:'/res/site/noavatar.gif';

		//分页
		$query = Memoirs::find()->where(['uid'=>$_GET['uid']]);
		$countQuery = clone $query;

		$page = new Pagination([
			'pageSize'=>4,
			'totalCount'=>$countQuery->count()
		]);

		// 当前用户的回忆录书籍信息
		$memoirs = $query->orderby('dateline desc')->offset($page->offset)->limit($page->limit)->asArray()->all();

		// echo "<pre>";
		// print_r($memoirs);die;

		return $this->render('memoirs',['memoirs'=>$memoirs, 'page'=>$page]);
	}

	//创建回忆录书籍
	public function actionCreate(){
		//用户信息	
		$userprofile = UserProfile::find()->where(['user_id' => $_GET['uid']])->one();		
		$user = $userprofile->hasOne(User::className(), ['id'=>'user_id'])->asArray()->one();
		$this->layout_data['account'] = $user['nickname']?$user['nickname']:$user['username'];
		$this->layout_data['motto'] = $userprofile['motto']?$userprofile['motto']:'还没有编辑个人签名！';
		$this->layout_data['avatar'] = $userprofile['avatar']?$userprofile['avatar']:'/res/site/noavatar.gif';

		//行业标签
		$tag1 = Memoirs_tag::find()->where(['pid'=>1])->asArray()->all();

		//经历标签
		$tag2 = Memoirs_tag::find()->where(['pid'=>2])->asArray()->all();

		//传递给视图文件
		\Yii::$app->params['tag1'] = $tag1;
		\Yii::$app->params['tag2'] = $tag2;	
		
		//实例化回忆录表
		$model = new Memoirs();

		if($model->load(\YII::$app->request->post())){
			// echo '<pre>';
			// print_r(\YII::$app->request->post());die;
			
			$post = \YII::$app->request->post();

			// $image = UploadedFile::getInstance($model, 'cover');
			// $ext = $image->getExtension(); //上传图片的扩展名
			// $imageName = date('Ymd').rand(1000,9999).'.'.$ext; //设置图片名
			// $image->saveAs('images/'.$imageName); //将图片保存到服务器			
			
			$model->cover = $post['cover']; //将图片名保存到数据库
			$model->uid = $_GET['uid']; //用户ID
			$model->username = $user['username']; //用户名
			$model->bookname = $post['Memoirs']['bookname']; //书名
			$model->subtitle = $post['Memoirs']['subtitle']; //副标题
			$model->introduction = $post['Memoirs']['introduction']; //简介
			$model->friend = $post['Memoirs']['friend']; //隐私设置
			$model->noreply = $post['Memoirs']['noreply']; //是否允许评论
			$model->publication = $post['Memoirs']['publication']; //是否出版
			$model->finish = $post['Memoirs']['finish']; //是否完成
			$model->tag = $post['addtag']; //标签
			$model->dateline = time(); //创建时间


			if($model->save()){			
				return $this->redirect(['space/manager', 'bookid'=>$model->attributes['bookid']]);
			}
		}else{
			return $this->render('create',['model'=>$model]);
		}
	}

	//管理回忆录
	public function actionManager(){
		//切换布局文件
		$this->layout = 'public';
		//接收书籍ID
		$bookid = \Yii::$app->request->get('bookid');
		//查询对应的书籍信息
		$data = Memoirs::findOne($bookid);

		// echo '<pre>';
		// print_r($data);
		return $this->render('manager', ['data'=>$data]);
	}

	//更新回忆录信息
	public function actionUpdate($bookid){
		//用户信息	
		$userprofile = UserProfile::find()->where(['user_id' => $_GET['uid']])->one();		
		$user = $userprofile->hasOne(User::className(), ['id'=>'user_id'])->asArray()->one();
		$this->layout_data['account'] = $user['nickname']?$user['nickname']:$user['username'];
		$this->layout_data['motto'] = $userprofile['motto']?$userprofile['motto']:'还没有编辑个人签名！';
		$this->layout_data['avatar'] = $userprofile['avatar']?$userprofile['avatar']:'/res/site/noavatar.gif';

		//行业标签
		$tag1 = Memoirs_tag::find()->where(['pid'=>1])->asArray()->all();

		//经历标签
		$tag2 = Memoirs_tag::find()->where(['pid'=>2])->asArray()->all();

		//传递给视图文件
		\Yii::$app->params['tag1'] = $tag1;
		\Yii::$app->params['tag2'] = $tag2;	
		
		//根据接收过来的书籍ID查询对应数据
		$model = $this->find($bookid);

		if($model->load(\YII::$app->request->post())){	
			$post = \YII::$app->request->post();		
			
			$model->cover = !empty($post['cover']) ? $post['cover'] : $model['cover']; //将图片名保存到数据库
			$model->uid = $_GET['uid']; //用户ID
			$model->username = $user['username']; //用户名
			$model->bookname = $post['Memoirs']['bookname']; //书名
			$model->subtitle = $post['Memoirs']['subtitle']; //副标题
			$model->introduction = $post['Memoirs']['introduction']; //简介
			$model->friend = $post['Memoirs']['friend']; //隐私设置
			$model->noreply = $post['Memoirs']['noreply']; //是否允许评论
			$model->publication = $post['Memoirs']['publication']; //是否出版
			$model->finish = $post['Memoirs']['finish']; //是否完成
			$model->tag = $post['addtag']; //标签
			$model->dateline = time(); //创建时间

			if($model->save()){			
				return $this->redirect(['space/manager', 'bookid'=>$bookid]);
			}
		}else{
			return $this->render('update',['model'=>$model, 'uid'=>$_GET['uid'], 'bookid'=>$bookid]);
		}
	}

	//删除回忆录书籍
	public function actionDelete($bookid){
		// $this->find($bookid)->delete();

		return $this->render('space/manager', ['bookid'=>$bookid]);
	}

	//根据书籍ID查询对应信息
	protected function find($id){
        if(($model = Memoirs::findOne($id)) !== null) {
            return $model;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
