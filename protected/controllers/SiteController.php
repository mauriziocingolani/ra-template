<?php

class SiteController extends TemplateController {

    public function actionIndex() {
        $tweets = null;
//        if (Yii::app()->user->isSupervisor()) :
//            $tweets = Yii::app()->cache->get('tweets');
//            if ($tweets == null) :
//                $tweets = Yii::app()->twitter->getTweets();
//                Yii::app()->cache->set('tweets', $tweets, 60 * 60 * 2); # in cache per 2 ore
//            endif;
//        endif;
        $this->render('index', array(
            'tweets' => $tweets,
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
