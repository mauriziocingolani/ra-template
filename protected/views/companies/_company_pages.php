<?php ?>

<style>
    a.active span {
        background: #EFF4FA;
    }
</style>

<p class="<?php if (Yii::app()->controller->id == 'companies' && Yii::app()->controller->action->id == 'company') echo 'active'; ?>">
    <a class="link <?php if (Yii::app()->controller->id == 'companies' && Yii::app()->controller->action->id == 'company') echo 'active'; ?>" 
       href="<?= Yii::app()->baseUrl; ?>/azienda/<?= $model->CompanyID; ?>" 
       style="margin-top: 20px;">
        <span>anagrafica</span>
    </a>
    <a class="link <?php if (Yii::app()->controller->id == 'companies' && Yii::app()->controller->action->id == 'profile') echo 'active'; ?>" 
       href="<?= Yii::app()->baseUrl; ?>/azienda/<?= $model->CompanyID; ?>/profilazione" 
       style="margin-top: 20px;">
        <span>profilazione</span>
    </a>
</p>