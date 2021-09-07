<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Marcas;
//use app\models\Lineas;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Accesorios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accesorios-form">

        <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>

        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'fk_status')->widget(Select2::classname(),[
                    'data'      => $status,
                    'options'   => [
                        'allowClear' => true,
                        'prompt'     => 'Selecciona un registro',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>    
            </div>
            <div class=col-md-6>
                <?= $form->field($model, 'fecha_recepcion')->widget(DatePicker::classname(), [
                            'class'    => 'form-control',
                            'value'    => 'fecha_recepcion',
                            'language' => 'es',
                            'options'  => ['placeholder' => 'Selecciona una fecha'],
                            'pluginOptions' => [
                                'format'         => 'yyyy-m-dd',
                                'autoclose'      => true,
                                'todayHighlight' => true,
                            ]
                        ]); ?>
            </div>
        </div>
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'fk_tipo_accesorio')->widget(Select2::classname(),[
                    'data'      => $tiposaccesorios,
                    'options'   => [
                        'allowClear' => true,
                        'prompt'     => 'Selecciona un registro',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>    
            </div>
            <div class=col-md-6>
                <?= $form->field($model, 'num_serie')->textInput(['maxlength' => true]) ?>
            </div>
        </div>  
            <?php
                $marca = ArrayHelper::map(Marcas::find()->where(['fk_tipo' => 2])->andwhere(['fk_status' => 1])->all(), 'id_marca', 'nombre');
                
               /* $linea = ArrayHelper::map(Lineas::find()->where(['fk_marca' =>'fkMarca'])->andwhere(['fk_status' => 1])->orderBy(['nombre' => SORT_ASC])->all(), 'id_linea', 'nombre');*/

                if ($model->isNewRecord){ 
            ?>
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'id_marca')->widget(Select2::classname(),[
                    'data'      => $marca,
                    'options'   => [
                        'allowClear' => true,
                        'prompt'     => 'Selecciona un registro',
                        'onchange'=>'
                                $.get( "'.Url::toRoute('accesorios/linea').'", { id: $(this).val() } )
                                .done(function(data) {
                                    $("#droplinea").html(data);
                                }
                            );'
                    ],
                    'pluginOptions'  => [
                        'allowClear' => true
                    ],
                ]);?> 
             </div>
            <div class=col-md-6> 
                <?= $form->field($model, 'fk_linea')->dropDownList( ['prompt'=>'Selecciona un registro'], ['id' => 'droplinea']); ?>
            </div>
        </div>
            <?php
                    }else{
                       // var_dump($model->fkLinea->fkMarca);
            ?>
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'fkMarca')->widget(Select2::classname(),[
                    'data'      => $marca,
                    'options'   => [
                        'selected'=>'fkMarca',
                        'allowClear' => true,
                        'load'=>'
                                $.get( "'.Url::toRoute('accesorios/linea').'", { id: $(this).val() } )
                                .done(function(data) {
                                    $("#droplinea").html(data);
                                }
                            );',
                        'onchange'=>'
                                $.get( "'.Url::toRoute('accesorios/linea').'", { id: $(this).val() } )
                                .done(function(data) {
                                    $("#droplinea").html(data);
                                }
                            );'
                    ],
                    'pluginOptions'  => [
                        'allowClear' => true
                    ],
                ]);?>
               
            </div>
            <div class=col-md-6>
                <?= $form->field($model, 'fk_linea')->dropDownList($lineas, ['id' => 'droplinea']); ?>
            </div>          
        </div>
            <?php
                }
            ?>   
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'fk_recurso_compra')->widget(Select2::classname(),[
                    'data'      => $recursoscompras,
                    'options'   => [
                        'allowClear' => true,
                        'prompt'     => 'Selecciona un registro',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>    
            </div>
             <div class=col-md-6>
                <?= $form->field($model, 'contrato_compra')->textInput(['maxlength' => true]) ?>
            </div>
        </div> 
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'inventario_interno')->textInput(['maxlength' => true]) ?>
            </div>
            <div class=col-md-6>
                <?= $form->field($model, 'inventario_segpub')->textInput(['maxlength' => true]) ?>
            </div>
        </div>  
        <div class="row">
            <div class=col-md-6>
                <?= $form->field($model, 'fk_status_ubicacion')->widget(Select2::classname(),[
                    'data'      => $ubicaciones,
                    'options'   => [
                        'allowClear' => true,
                        'prompt'     => 'Selecciona un registro',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>    
            </div>
        </div>
        <div class="row">
            <div class=col-md-12>
                <?= $form->field($model, 'observaciones')->textArea(['rows' => 4]) ?>
            </div>
        </div>


        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>

    <?php ActiveForm::end(); ?>

</div>