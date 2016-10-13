<?php

namespace frontend\controllers;

use common\models\Subscriber;
use Yii;

class UserController extends \yii\web\Controller
{
    /**
     * add Subscriber to Mailchip grouping by $groupings_id and
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new Subscriber();
        $groupings_id = 741;
        $groupings_group_names = ['subscriber', 'customer'];
        $merge_vars['groupings'] = [['id' => $groupings_id, 'groups' => $groupings_group_names]];
        if ($model->load(Yii::$app->request->post())) {

            $email['email'] = $model->email;
            $mailchimp = new \Mailchimp(\Yii::$app->params['mailchimpAPIkey']);
            $list_id = $mailchimp->lists->getList(['list_name' => 'List2_customer']);    // set the desired list_name

            $result = $mailchimp->lists->subscribe(
                $list_id['data'][0]['id'],
                $email,
                $merge_vars
            );

            $model->mail_chimp_euid = $result['euid'];
            $model->mail_chimp_leid = $result['leid'];

            if(!$model->validate() || !$model->save()){

                return $this->render('contact', [
                    'model' => $model,
                    'errors' => $model->getErrors(),
                ]);
            }
            return $this->redirect('contact');
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
