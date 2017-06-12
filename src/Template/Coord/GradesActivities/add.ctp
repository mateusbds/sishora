<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($gradesActivity) ?>
<fieldset>
    <legend><?= __('Novo') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('activity_id', ['options' => $activities, 'label' => 'Atividade Complementar', 'class'=>'form-control']);
            echo $this->Form->input('amount', ['label' => 'Quantidade', 'class' => 'form-control', 'type' => 'textbox']);
            echo $this->Form->input('unit', ['label' => 'Unidade', 'class' => 'form-control', 'options' => ['0' => 'Horas', '1' => 'Dias', '2' => 'Quantidade']]);
            echo $this->Form->input('compHours', ['label' => 'Nº Horas Complementares', 'class' => 'form-control', 'type' => 'textbox']);
            echo $this->Form->input('limite', ['class' => 'form-control', 'type' => 'textbox']);
            echo $this->Form->input('actuation_id', ['options' => $actuations, 'label' => 'Eixo de atuação', 'class' => 'form-control']);
        ?>
    </div>
</fieldset>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button', 'controller' => 'Users', 'rel' => 'modal:close']) ?>
</div>

