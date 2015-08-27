<?php
/* @var $this ActivityWidget */
?>

<div style="margin-bottom: 5px;">

    <!-- data creazione attività -->
    <span style="color: #bababa;"><?= date('d-m-Y', strtotime($this->activity->Created)); ?></span>
    <!-- icona -->
    <?php if ($this->activity->ActivityType->isRecall) : ?>
        <i class="fa fa-phone"></i>
    <?php elseif ($this->activity->ActivityType->isClosed) : ?>
        <i class="fa fa-times" style="color: red;"></i>
    <?php elseif ($this->activity->ActivityType->isSuccess) : ?>
        <i class="fa fa-check" style="color: green;"></i>
    <?php endif; ?>
    <!-- tipo attività -->
    <strong><?= $this->activity->ActivityType->Description; ?></strong>
    <?php if ($this->activity->ActivityType->isRecall) : ?>
        (<small style="<?php if ($this->activity->RecallPrioritary) echo 'background: yellow;'; ?>">
            <strong><?= date('d-m-Y', strtotime($this->activity->RecallDateTime)); ?></strong> alle <?= date('H:i', strtotime($this->activity->RecallDateTime)); ?>
        </small>)
    <?php endif; ?>

    <a id="<?= $this->activity->ActivityID; ?>_expander" class="expander" href="" style="float: right;margin-right: 5px;" onclick="return false;"><i class="fa fa-plus-square-o"></i></a>
</div>

<div id="<?= $this->activity->ActivityID; ?>_details" style="border: 1px solid #e5eCf9;display: none;margin-bottom: 10px;padding:5px;">
    <span style="color: #bababa;">Registrata il <?= $this->activity->createdString; ?></span>
    <?php if (Yii::app()->user->isSupervisor()) : ?>
        <!-- eliminazione attività -->
        <form id="<?= $this->activity->ActivityID; ?>_activity_delete_form" name="DeleteActivity" style="float: right;" method="post">
            <input name="DeleteActivity[ActivityID]" type="hidden" value="<?= $this->activity->ActivityID; ?>" />
            <input name="DeleteActivity[CampaignID]" type="hidden" value="<?= $this->activity->CampaignID; ?>" />
            <a href="#" style="float: right;" onclick="return submitDeleteActivity(<?= $this->activity->ActivityID; ?>)"><i class="fa fa-trash-o"></i></a>
        </form>
    <?php endif; ?>
    <?php if ($this->activity->Notes || $this->activity->ContactID) : ?>
        <table style="margin-top: 10px;">
            <?php if ($this->activity->ContactID) : ?>
                <tr style="vertical-align: top;">
                    <td style="vertical-align: top;"><strong>Referente:</strong></td>
                    <td style="font-size: 10px;text-align: justify;"><?= Html::encode($this->activity->Contact->completeName); ?></td> 
                </tr>
            <?php endif; ?>
            <?php if ($this->activity->Notes) : ?>
                <tr style="vertical-align: top;">
                    <td style="vertical-align: top;"><strong>Note:</strong></td>
                    <td style="font-size: 10px;text-align: justify;"><?= Html::encode($this->activity->Notes); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</div>

<div id="<?= $this->activity->ActivityID; ?>_details" style="border: 1px solid #e5eCf9;display: none;margin-bottom: 10px;padding:5px;">
    <span style="color: #bababa;">Registrata il <?= $this->activity->createdString; ?></span>
    <?php if (Yii::app()->user->isSupervisor()) : ?>
        <!-- eliminazione attività -->
        <form id="<?= $this->activity->ActivityID; ?>_activity_delete_form" name="DeleteActivity" style="float: right;" method="post">
            <input name="DeleteActivity[ActivityID]" type="hidden" value="<?= $this->activity->ActivityID; ?>" />
            <input name="DeleteActivity[CampaignID]" type="hidden" value="<?= $this->activity->CampaignID; ?>" />
            <a href="#" style="float: right;" onclick="return submitDeleteActivity(<?= $this->activity->ActivityID; ?>)"><i class="fa fa-trash-o"></i></a>
        </form>
    <?php endif; ?>
    <?php if ($this->activity->Notes || $this->activity->ContactID) : ?>
        <table style="margin-top: 10px;">
            <?php if ($this->activity->ContactID) : ?>
                <tr style="vertical-align: top;">
                    <td style="vertical-align: top;"><strong>Referente:</strong></td>
                    <td style="font-size: 10px;text-align: justify;"><?= Html::encode($this->activity->Contact->completeName); ?></td> 
                </tr>
            <?php endif; ?>
            <?php if ($this->activity->Notes) : ?>
                <tr style="vertical-align: top;">
                    <td style="vertical-align: top;"><strong>Note:</strong></td>
                    <td style="font-size: 10px;text-align: justify;"><?= Html::encode($this->activity->Notes); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</div>