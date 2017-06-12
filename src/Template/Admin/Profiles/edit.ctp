<?php
/**
  * @var \App\View\AppView $this
  */
?>

<?= $this->Form->create($profile) ?>
<fieldset>
    <legend><?= __('Editar') ?></legend>
    <?php
        echo $this->Form->input('name', ['label' => 'Nome', 'class' => 'form-control']);
    ?>
</fieldset>
<br/>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'action' => 'index']) ?>
</div>

