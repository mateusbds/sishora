<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($actuation) ?>
<fieldset>
    <legend><?= __('Novo') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('name', ['label' => 'Nome', 'class' => 'form-control']);
        ?>
    </div>
</fieldset>
    <div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button',  'rel' => 'modal:close']) ?>
</div>