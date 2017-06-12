<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($user) ?>
<fieldset>
    <legend><?= __('Editar') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('username', ['label' => 'Usuário', 'class' => 'form-control']);
            echo $this->Form->input('password', ['label' => 'Senha', 'type' => 'password', 'class' => 'form-control']);
            echo $this->Form->input('passwordconfirm', ['label' => 'Confirmar Senha', 'type' => 'password', 'class' => 'form-control passwordConfirm']);
            echo $this->Form->label(null, '', ['id' => 'passwordMatch', 'style' => 'display: none; color: red;']);
            echo $this->Form->input('name', ['label' => 'Nome', 'class' => 'form-control']);
            echo $this->Form->input('email', ['label' => 'Email', 'type' => 'email', 'class' => 'form-control']);
            echo $this->Form->input('grade_id', ['options' => $grades, 'empty' => true, 'class' => 'form-control']);
        ?>
    </div>
</fieldset>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'action' => 'index']) ?>
</div>

<script>
$(document).ready(function () {
    var password = $("#password").val();
    var confirmPassword = $("#passwordconfirm").val();

    $("body").on("focusout", ".passwordConfirm", function() {
        password = $("#password").val();
        confirmPassword = $("#passwordconfirm").val();
        if (password != confirmPassword) {
            $("#passwordMatch").show();
            $("#passwordMatch").html("Passwords do not match!");
        }
        else
            $("#passwordMatch").hide();
    });
});
</script>