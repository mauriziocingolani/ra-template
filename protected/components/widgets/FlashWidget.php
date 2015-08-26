<?php

class FlashWidget extends CWidget {

    public $prefix;

    public function run() {
        $this->render('comp.views.widgets.flashWidget');
    }

}
