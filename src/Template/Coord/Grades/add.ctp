<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($grade) ?>
<fieldset>
    <legend><?= __('Novo') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('description', ['label' => 'Descrição', 'class' => 'form-control']);
            echo $this->Form->input('qntHours', ['label' => 'Quantidade de Horas', 'class' => 'form-control', 'type' => 'textbox']);
            echo $this->Form->input('status', ['label' => 'Ativa', 'class' => 'checkbox']);
        ?>
    </div>
</fieldset>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'action' => 'index']) ?>
</div>