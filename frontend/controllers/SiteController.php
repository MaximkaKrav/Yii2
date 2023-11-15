<?php

namespace frontend\controllers;


use common\models\LoginForm;
use frontend\models\Device;
use frontend\models\SearchDevices;
use frontend\models\Store;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\TablesDeviceAndStoreModel;
use frontend\models\User;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
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
        $searchModel = new SearchDevices();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * @throws \Throwable
     */
    public function actionTables()
    {
//        $rows = TablesDeviceAndStoreModel::find()->all();
//        return $this->render('tables', ['rows' =>$rows]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Device::find(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]
        );

        return $this->render(
            'tables',
            [
                'dataProvider' => $dataProvider,
            ]
        );


    }

    public function actionView($id)
    {
        $model = TablesDeviceAndStoreModel::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = TablesDeviceAndStoreModel::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            Yii::$app->formatter->asDatetime(date('Y-d-m h:i:s'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = TablesDeviceAndStoreModel::findOne($id);
        $model->delete();
        return $this->redirect(['tables']);
    }
    public function actionStore($store_id)
    {
        $dataProvider = new \yii\data\ActiveDataProvider(
            [
                'query' => Device::find()->where(['store_id' => $store_id]),
            ]
        );

        return $this->render('store', ['dataProvider' => $dataProvider]);
    }
    public function actionCreate()
    {
        $model = new TablesDeviceAndStoreModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tables']);
        }

        return $this->render(
            'create',
            [
                'model' => $model,
            ]
        );
    }

    public function actionStores($store_id)
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => TablesDeviceAndStoreModel::find()->where(['store_id' => $store_id]),
            ]
        );

        return $this->renderPartial(
            'store',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }



    public function actionFilter($store_id)
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => TablesDeviceAndStoreModel::find()->where(['store_id' => $store_id]),
            ]
        );

        return $this->renderPartial(
            'store',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }




    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->status == 10;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}
