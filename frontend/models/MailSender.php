<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class MailSender extends Model
{
    public static function sendEmail($email, $subject, $body, $view)
    {
        return Yii::$app->mailer->compose(['html' => $view], ['title' => $subject, 'body' => $body])
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject($subject)
            ->send();
    }
}
