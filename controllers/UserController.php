<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        
        $filter = Yii::$app->request->queryParams;
        
        //setup type filter
        if(explode('?', Yii::$app->request->url)[0] == '/admin-users')
          $filter['UserSearch']['type'] = 'admin';
        else if (explode('?', Yii::$app->request->url)[0] == '/operators')
          $filter['UserSearch']['type'] = 'operator';
          
        $dataProvider = $searchModel->search($filter);

        return $this->render('index'.ucfirst($filter['UserSearch']['type']), [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateOperator()
    {
        $model = new User();

        $model->type = 'operator';
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createOperator', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateAdmin()
    {
        $model = new User();

        $model->type = 'admin';
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createAdmin', [
                'model' => $model,
            ]);
        }
    }    

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateAdmin($id)
    {
        $model = $this->findModel($id);
        $model->password = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('updateAdmin', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateOperator($id)
    {
        $model = $this->findModel($id);
        $model->password = '';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('updateOperator', [
                'model' => $model,
            ]);
        }
    }    
    
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
