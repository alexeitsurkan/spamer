<?php

use yii\bootstrap\ActiveForm;

/**
 * @var $chat_list
 * @var $model
 */
?>
<div class="row">
    <div class="col-md-offset-3 col-sm-6">
        <section class="card">
            <div class="card-body">

                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model,'chat_id')->label('чат')->dropDownList($chat_list)?>
                <?= $form
                    ->field($model, 'text')
                    ->textarea(
                        [
                            'rows' => '15'
                        ]
                    )
                    ->label('Текст сообщения') ?>

                <button class="btn btn-success" type="submit">Отправить</button>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>