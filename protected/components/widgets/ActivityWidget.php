<?php

/**
 * @property Activity $activity
 */
class ActivityWidget extends CWidget {

    public $activity;

    public function run() {
        $this->render('comp.views.widgets.activityWidget');
    }

}
