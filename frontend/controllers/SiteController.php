<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Comment;
use common\models\Contact;
use common\models\Item;
use common\models\Page;
use common\models\Product;
use common\models\Subscriber;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $limit = Item::ITEM_VIEW_LIMIT_DESKTOP;
        if (Yii::$app->devicedetect->isMobile()) {
            $limit = Item::ITEM_VIEW_LIMIT_MOBILE;
        }

        $items = Item::find()
            ->where(['status' => Item::PUBLISHED, 'isDeleted' => false])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        $popular = Item::find()
            ->where(['status' => Item::PUBLISHED, 'isDeleted' => false, 'recommended' => true])
            ->limit(8)
            ->all();

        return $this->render('index', [
            'items' => $items,
            'popular' => $popular
        ]);
    }

    public function actionMore()
    {
        if (Yii::$app->request->isAjax) {

            $limit = Item::ITEM_VIEW_LIMIT_DESKTOP;
            if (Yii::$app->devicedetect->isMobile()) {
                $limit = Item::ITEM_VIEW_LIMIT_MOBILE;
            }
            Yii::$app->response->format = Response::FORMAT_HTML;
            $post = Yii::$app->request->post();
            $items = Item::find()->orderBy(['created_at' => SORT_DESC])->limit($limit)->offset($post['offset'])->all();
            if (empty($items)) {
                return false;
            }
            $template = $this->renderPartial('item', ['items' => $items]);
            return $template;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page, sync data with MailChimp, save data on DB
     * @return mixed
     */
//    public function actionContact()
//    {
//        $model = new Subscriber();
//        $groupings_id = 741;
//        $groupings_group_names = ['subscriber', 'customer'];
//        $merge_vars['groupings'] = [['id' => $groupings_id, 'groups' => $groupings_group_names]];
//        if ($model->load(Yii::$app->request->post())) {
//
//            $email['email'] = $model->email;
//            $mailchimp = new \Mailchimp(\Yii::$app->params['mailchimpAPIkey']);
//            $list_id = $mailchimp->lists->getList(['list_name' => 'List2_customer']);    // set the desired list_name
//
//            $result = $mailchimp->lists->subscribe(
//                $list_id['data'][0]['id'],
//                $email,
//                $merge_vars
//            );
//
//            $model->mail_chimp_euid = $result['euid'];
//            $model->mail_chimp_leid = $result['leid'];
//
//            if(!$model->save()){
//
//                return $this->render('contact', [
//                    'model' => $model,
//                    'errors' => $model->getErrors(),
//                ]);
//            }
//            return $this->redirect('contact');
//        }
//
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
//    }

//    public function actionStart(){
//        $email['email'] = 'belemets.egor@gmail.com';
//        $mailchimp = new \Mailchimp(\Yii::$app->params['mailchimpAPIkey']);
//        $list_id = $mailchimp->lists->getList();
//        header('content-type: text/html; charset=utf-8;');
//        echo '<pre>';
//        @print_r($list_id);
//        echo '</pre>';
//        exit(__FILE__ .': '. __LINE__);
////        $cid = $mailchimp->campaigns->getList(['name'=>'Test']);
//        print_r( $list_id); die();
//        $mailchimp->campaigns->send($cid['data'][0]['id']);
//    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
