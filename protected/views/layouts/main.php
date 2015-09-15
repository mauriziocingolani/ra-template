<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    </head>

    <body>

        <div class="container" id="page">

            <!-- HEADER -->
            <div id="header">
                <div id="logo">
                    <table style="margin-bottom: 0;"> 
                        <tr>
                            <td style="padding-right: 0;width: 200px;">
                                <?php echo CHtml::image(Yii::app()->params['app']['logo'], '', array('style' => 'width: ' . Yii::app()->params['app']['logoWidth'] . ';')); ?>
                            </td>
                            <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->name); ?></td>
                        </tr>
                    </table>
                </div>
            </div><!-- header -->

            <!-- MENU' NAVIGAZIONE -->
            <div id="mainmenu">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Home',
                            'url' => Yii::app()->homeUrl,
                            'active' => Yii::app()->controller->id == 'site',
                        ),
                        array(
                            'label' => 'Aziende',
                            'url' => array('/aziende'),
                            'visible' => !Yii::app()->user->isGuest,
                            'active' => Yii::app()->controller->id == 'companies',
                        ),
                        array(
                            'label' => 'Campagne',
                            'url' => array('/campagne'),
                            'visible' => !Yii::app()->user->isGuest && Yii::app()->user->isSupervisor(),
                            'active' => Yii::app()->controller->id == 'campaigns',
                        ),
                        array(
                            'label' => 'Reports',
                            'url' => array('/reports'),
                            'visible' => !Yii::app()->user->isGuest && Yii::app()->user->isSupervisor(),
                            'active' => Yii::app()->controller->id == 'reports',
                        ),
                        array(
                            'label' => 'Login',
                            'url' => array('/login'),
                            'visible' => Yii::app()->user->isGuest,
                            'active' => Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'login',
                            'itemOptions' => array('style' => 'float: right;'),
                        ),
                        array(
                            'label' => 'Esci (' . Yii::app()->user->name . ')',
                            'url' => array('/logout'),
                            'visible' => !Yii::app()->user->isGuest,
                            'itemOptions' => array('style' => 'float: right;'),
                        ),
                    ),
                ));
                ?>
            </div>

            <!-- BREADCRUMBS -->
            <?php if (isset($this->crumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->crumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <!-- CONTENUTO PRINCIPALE -->
            <div id="content">
                <?php echo $content; ?>
            </div><!-- content -->

            <?php if (!Yii::app()->user->isGuest && Yii::app()->controller->id == 'companies') : ?>

                <?php $lasts = Yii::app()->user->user->lastCompanies; ?>
                <?php if (count($lasts) > 0) : ?>
                    <div id="last" style="padding: 20px;">
                        <hr />
                        <h4>Ultime agenzie lavorate:</h4>
                        <ul style="font-size: 10px;">
                            <?php foreach ($lasts as $c) : ?>
                                <li><?= Html::link($c->CompanyName, '/azienda/' . $c->CompanyID); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <div class="clear"></div>

            <!-- FOOTER -->
            <div id="footer">
                <strong><?php echo Yii::app()->name; ?></strong> - &copy;<?php echo Yii::app()->params['app']['year']; ?> - <?php echo Html::link('Licenza', array('/licenza')); ?>
                <p>
                    sviluppo web: <?php echo CHtml::link('Maurizio Cingolani', 'http://www.mauriziocingolani.it', array('target' => 'blank')); ?>
                    &CenterDot;
                    <?php echo CHtml::mailto('<i class="fa fa-envelope-o"></i>', 'm.cingolani@ggfgroup.it'); ?>
                    <?php echo CHtml::link('<i class="fa fa-linkedin"></i>', 'http://it.linkedin.com/in/mauriziocingolani', array('target' => 'blank')); ?>
                    <?php echo CHtml::link('<i class="fa fa-twitter"></i>', 'http://www.twitter.com/m_cingolani', array('target' => 'blank')); ?>
                    <?php echo CHtml::link('<i class="fa fa-github"></i>', 'https://github.com/mauriziocingolani', array('target' => 'blank')); ?>
                </p>
                <?php if (!Yii::app()->user->isGuest) : ?>
                    <small>
                        Powered by <?php echo Html::link('Yii ' . Yii::getVersion(), 'http://www.yiiframework.com/doc/api/', array('target' => 'blank')); ?>
                        (PHP: <?php echo PHP_VERSION; ?>)
                    </small>
                <?php endif; ?>
            </div>

        </div><!-- page -->

    </body>
</html>
