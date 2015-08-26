<?php if (Yii::app()->user->hasFlash(($this->prefix ? $this->prefix . '_' : '') . 'success')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash(($this->prefix ? $this->prefix . '_' : '') . 'success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash(($this->prefix ? $this->prefix . '_' : '') . 'error')) : ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash(($this->prefix ? $this->prefix . '_' : '') . 'error'); ?>
    </div>
<?php endif; ?>