<?= $this->Form->create($usersGradesActivity) ?>
<fieldset>
    <legend><?= __('Observação') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('obs', ['label' => 'Observação', 'class' => 'form-control', 'style' => 'resize: none;']);
        ?>
    </div>
</fieldset>
<div class="row">
    <?= $this->Form->button('Enviar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>
</div>