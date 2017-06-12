<?= $this->Form->create($usersGradesActivity) ?>
<fieldset>
    <legend><?= __('Observação') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('obs', ['label' => 'Observação', 'class' => 'form-control', 'disabled' => true, 'style' => 'resize: none;']);
        ?>
    </div>
</fieldset>
<div class="row">
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Fechar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>
</div>