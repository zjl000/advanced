<?php 
	namespace frontend\controllers;
	use yii\web\Controller;
	use frontend\models\Memoirs;
	use frontend\models\Memoirs_chapter;
	use frontend\models\Memoirs_volume;
	use frontend\models\Memoirs_reply;

	class ReadController extends Controller{
		public $layout = 'read';
		//封面页
		public function actionIndex(){
			header("content-type:text/html;charset=utf8");
			//获取session里的数据，用于验证登陆
			$session = \YII::$app->session;
			$login = $session->get('login');
			$username = $session->get('username');

			//将数据传递给布局文件
			\YII::$app->params['login'] = $login;
			\YII::$app->params['username'] = $username;
			// echo $username;die;

			//接收传递过来的值（书籍ID和作品简介页参数）
			$id = \YII::$app->request->get('id');
			$read = \YII::$app->request->get('read');

			//根据书籍ID查询单条信息
			$data = Memoirs::find()->where(['bookid'=>$id])->one();
			//当前书籍的评论信息
			$reply = Memoirs_reply::find()->where(['bookid'=>$id]);
			$reply = $reply->joinWith('user')->orderby('dateline desc')->asArray()->all();

			//将数据传递给布局文件
			// $view = \YII::$app->view;
			// $view->params['data'] = $data;
			\YII::$app->params['data'] = $data;
			\YII::$app->params['reply'] = $reply;

			//查询章节信息
			$chapter = Memoirs_chapter::find()->where(['bookid'=>$id])->asArray()->all();
			
			//判断章节卷是否存在
			if($chapter[0]['volumeid'] != 0){
				//判断卷是否存在，存在则根据卷表查出对应的章节（joinWith贪婪加载）
				$volume = Memoirs_volume::find()->joinWith('chapter')->orderby('volumeid, chapterid')->asArray()->all();
			}else{
				$volume = '';
			}

			//作品简介页参数存在，则返回该页
			if(isset($read)){
				//查询用户信息
				$uid = $data['uid'];
				$memoirs = Memoirs::find()->where(['uid'=>$uid])->one();
				$user = $memoirs->user;

				return $this->render('introduction',['chapter'=>$chapter, 'data'=>$data, 'user'=>$user, 'volume'=>$volume]);
			}
		
			// echo "<pre>";
			// print_r($reply);die;
			return $this->render('index',['data'=>$data, 'chapter'=>$chapter, 'volume'=>$volume]);
		}

		//书籍内容阅读页
		public function actionContent(){
			header('content-type:text/html;charset=utf8');
			//获取session里的数据，用于验证登陆
			$session = \YII::$app->session;
			$login = $session->get('login');
			$username = $session->get('username');
			\YII::$app->params['login'] = $login;
			\YII::$app->params['username'] = $username;

			//判断是否通过ajax传递
			if(\Yii::$app->request->isAjax){
				//接收传递过来的章节ID
				$chapterid = \Yii::$app->request->get('chapterid');

				//根据章节ID查询章节信息
				$chapterinfo = Memoirs_chapter::find()->where(['chapterid'=>$chapterid])->asArray()->one();

				//响应格式化，返回json数据
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

				return $chapterinfo;

				// echo '<pre>';
				// print_r($chapterinfo);die;
			}else{
				//接收传递过来的章节ID
				$chapterid = \Yii::$app->request->get('chapterid');

				//根据章节ID查询章节信息
				$chapterinfo = Memoirs_chapter::find()->where(['chapterid'=>$chapterid])->asArray()->one();

				//查询对应的书籍信息
				$bookid = $chapterinfo['bookid'];

				$data = Memoirs::find()->where(['bookid'=>$bookid])->asArray()->one();

				//当前书籍的评论信息
				$reply = Memoirs_reply::find()->where(['bookid'=>$bookid]);
				$reply = $reply->joinWith('user')->orderby('dateline desc')->asArray()->all();

				//将数据传递给布局文件
				\YII::$app->params['data'] = $data;
				\YII::$app->params['reply'] = $reply;

				//根据书籍ID查询所有章节信息
				$chapter = Memoirs_chapter::find()->where(['bookid'=>$bookid])->asArray()->all();
				
				//判断章节卷是否存在
				if($chapter[0]['volumeid'] != 0){
					//判断卷是否存在，存在则根据卷表查出对应的章节（joinWith贪婪加载）
					$volume = Memoirs_volume::find()->joinWith('chapter')->orderby('volumeid, chapterid')->asArray()->all();
				}else{
					$volume = '';
				}

				return $this->render('content',['chapterinfo'=>$chapterinfo, 'data'=>$data, 'chapter'=>$chapter, 'volume'=>$volume]);
			}

		}

		//评论
		public function actionReply(){
			//当前用户ID
			$session = \YII::$app->session;
			$uid = $session->get('uid');

			//接收通过ajax传递过来的值	
			if(\YII::$app->request->isAjax){
				$bookid = \YII::$app->request->post('bookid');//书籍ID
				$content = \YII::$app->request->post('content');//评论内容

				//书籍数据
				$memoirs = Memoirs::find()->where(['bookid'=>$bookid])->one();
			
				//实例化评论表
				$reply = new Memoirs_reply();

				$reply->uid = $uid;//当前评论用户ID
				$reply->bookid = $bookid;//书籍ID
				$reply->author = $memoirs['username'];//作者名
				$reply->dateline = time();//评论发表时间
				$reply->message = $content;//评论内容

				//保存
				if ($reply->save()) {
					 //回忆录表 评论数量+1
					$memoirs->replynum = $memoirs->replynum + 1;
					$memoirs->save();
				}

				$res = $reply->attributes;//返回所有插入数据
				
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;//格式化响应数据
				// echo '<pre>';
				// print_r($res);die;

				return $res;
			}
		}

		//删除评论
		public function actionDelreply(){
			//接收传递过来的ID
			$replyid = \YII::$app->request->post('replyid');

			//找到当前的评论信息
			$reply = Memoirs_reply::findOne($replyid);
			
			//回忆录表 评论数量-1
			$bookid = $reply['bookid'];
			$memoirs = Memoirs::findOne($bookid); 
			$memoirs->replynum = $memoirs->replynum - 1;
			$memoirs->save();

			//删除并返回
			return $reply->delete();
		}

		//回复
		public function actionSendreply(){
			//获取当前的用户ID
			$session = \YII::$app->session;
			$cuid = $session->get('uid');

			//判断是否通过ajax传值
			if(\YII::$app->request->isAjax){
				$bookid = \YII::$app->request->post('bookid');//书籍ID
				$uid = \YII::$app->request->post('uid');//被回复人ID
				$author = \YII::$app->request->post('author');//作者
				$message = \YII::$app->request->post('message');//回复内容

				//实例化评论表
				$reply = new Memoirs_reply();

				$reply->uid = $uid;//回复的用户ID
				$reply->bookid = $bookid;//书籍ID
				$reply->authorid = $cuid;//回复人ID
				$reply->author = $author;//作者
				$reply->dateline = time();//评论发表时间
				$reply->message = $message;//回复内容

				//保存
				if ($reply->save()) {
					//回忆录表 评论数量+1
					$memoirs = Memoirs::findOne($bookid); 
					$memoirs->replynum = $memoirs->replynum + 1;
					$memoirs->save();
				}

				$res = $reply->attributes;//返回所有插入数据
				
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;//格式化响应数据

				return $res;			
			}
		}
	}
 ?>