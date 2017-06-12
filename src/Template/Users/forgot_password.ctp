<div class="container" style="width : 40%">
    <legend><?= __('Recuperar Senha') ?></legend>
    <?= $this->Form->create(null); ?>
    <fieldset class="form-group">
        <div class="form-group">
            <?php
                echo $this->Form->input('email', ['class' => 'form-control']);
                echo $this->Form->button('Enviar', ['class' => 'btn btn-success', 'style' => 'margin-top: 10px;']);
                echo $this->Form->end();
            ?>
        </div>
    </fieldset>
</div>