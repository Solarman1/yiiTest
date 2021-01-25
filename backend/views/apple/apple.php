<?php
use yii\helpers\Html;
?>

<form action="/getaplles">
    <button type="submit" class="btn btn-primary">Generate apples</button>
</form>

<div>
<h2>Apple page</h2>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
      
            <?php if(!empty($result)):?>
                <?php foreach($result as $value):?>
                    <?php foreach($value as $item):?>    
                <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="/assets/images/apple.png" width="50" height="50" style="background-color:<?php $item['color']?>;">
                        <div class="card-body">
                            <h5 class="card-title"><?php $item['id']?></h5>
                            <p class="card-text"></p>
                        </div>
                        <ul class="list-group list-group-flush">
                        
                        <?= Html::beginForm(['/falltogroundapple'], 'post') ?>
                        <input type="hidden" name="appleId" value="<?php // $result->id?>">
                            <li class="list-group-item">  <button type="submit" class="btn btn-success">Сорвать с дерева</button></li>
                        <?= Html::endForm() ?>
                            
                        
                            
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <button id="button-addon1" type="button" class="btn btn-info btn-outline-secondary">Откусить</button>
                                    <label for="procentInput">Сколько процентов откусить?</label>
                                    <input id="procentInput" type="text" class="form-control" aria-describedby="button-addon1">
                                </div>
                            </li>
                            <li class="list-group-item"> <button type="button" class="btn btn-warning">Удалить</button></li>
                        </ul>
                        <div class="card-body">

                        </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                <?php endforeach;?>  
            <?php endif ?>
            </div>
        </div>
    </div>
</div>