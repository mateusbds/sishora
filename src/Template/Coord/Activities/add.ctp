<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($activity) ?>
<fieldset>
    <legend><?= __('Adicione uma nova atividade') ?></legend>

    <div class="form-group">
        <?php
            echo $this->Form->input('name', ['label' => 'Nome', 'type' => 'text' , 'class' => 'form-control', 'placeholder' => 'nome da atividade'] );
            // echo $this->Form->input('grades._ids', ['options' => $grades]);
        ?>
    </div>
    
</fieldset>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'action' => 'index']) ?>
</div>