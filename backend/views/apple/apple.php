<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<form action="/getaplles">
    <button type="submit" class="btn btn-primary">Generate apples</button>
</form>

<div>
<h2>Apple page</h2>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
        <?php if (Yii::$app->session->hasFlash('eatingStatus')): ?>
            <p><?= Yii::$app->session->getFlash('eatingStatus') ?></p>
        <?php endif; ?>

            <?php if(!empty($result)):?>
                <?php foreach($result as $value):?> 
                <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="/assets/images/apple.png" width="50" height="50" style="background-color:<?= $value['color'] ?>;">
                        <div class="card-body">
                        <?php if ($value['appleStatus'] != 1 && $value['appleStatus'] != 3): ?>
                            <h5 class="card-title">Яблоко можно кушать</h5>
                        <?php endif; ?>

                        <?php if ($value['appleStatus'] == 1): ?>
                            <h5 class="card-title">Яблоко висит на дереве</h5>
                        <?php endif; ?>

                        <?php if ($value['appleStatus'] == 3): ?>
                            <h5 class="card-title">Яблоко гнилое</h5>
                        <?php endif; ?>
                            
                            
                            <?php if($value['eatingProcent']): ?>
                                <p class="card-text">Сколько можно съесть -> <?= $value['eatingProcent'] ?></p>
                            <?php endif; ?>
                        </div>
                        <ul class="list-group list-group-flush">
                        
                        <?= Html::beginForm(['/falltogroundapple'], 'post') ?>
                        <input type="hidden" name="appleId" value="<?= $value['id'] ?>">
                            <li class="list-group-item">  <button type="submit" class="btn btn-success">Сорвать с дерева</button></li>
                        <?= Html::endForm() ?>
                            
                        
                            
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                            
                                <?php $form = ActiveForm::begin([
                                    'method' => 'post',
                                    'action' => ['/eatapple'],
                                    'options' => ['class' => 'form-horizontal'],
                                ]) ?>
                                        <button id="button-addon1" type="submit" class="btn btn-info btn-outline-secondary">Откусить</button>
                                        <label for="procentInput">Сколько процентов откусить?</label>
                                        <?= $form->field($model, 'eatingProcent') ?>

                                        <input type="hidden" name="appleId" value="<?= $value['id'] ?>"> 
                                        <input type="hidden" name="appleSize" value="<?= $value['eatingProcent'] ?>">
                                        <input type="hidden" name="status" value="<?= $value['appleStatus'] ?>">
                                <?php ActiveForm::end() ?>
                                </div>
                            </li>
                            <form action="/deleteapple/<?= $value['id']?>" method="get">
                                <li class="list-group-item"> <button type="submit" class="btn btn-warning">Удалить</button></li>
                            </form>
                        </ul>
                        <div class="card-body">

                        </div>
                        </div>
                    </div>
      
                <?php endforeach;?>  
            <?php endif ?>
            </div>
        </div>
    </div>
</div>