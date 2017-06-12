<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($user) ?>
<fieldset>
    <legend><?= __('Novo') ?></legend>
    <div class="form-group" >
    <?php
        echo $this->Form->input('username', ['label' => 'Usuário', 'class' => 'form-control']);
        echo $this->Form->input('password', ['label' => 'Senha', 'type' => 'password', 'class' => 'form-control']);
        echo $this->Form->input('passwordconfirm', ['label' => 'Confirmar Senha', 'type' => 'password', 'class' => 'form-control passwordConfirm']);
        echo $this->Form->label(null, '', ['id' => 'passwordMatch', 'style' => 'display: none; color: red;']);
        echo $this->Form->input('name', ['label' => 'Nome', 'class' => 'form-control']);
        echo $this->Form->input('email', ['label' => 'Email', 'class' => 'form-control']);
        echo $this->Form->input('profile_id', ['options' => $profiles, 'label' => 'Perfil', 'class' => 'form-control']);
        echo $this->Form->label(null, 'Grade', ['id' => 'grade-id2', 'style' => 'display: none;']);
        echo $this->Form->input('grade_id', ['options' => $grades, 'label' => false, 'class' => 'form-control','empty' => true, 'style' => 'display: none;']);
    ?>
    </div>
</fieldset>
<?= $this->Form->button('Salvar', ['class' => 'btn btn-primary', 'style' => 'margin-right: 5px;']) ?>
<?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>
<?= $this->Form->end() ?>

<script>
$(document).ready(function() {
    var perfil = $("#profile-id option:selected" ).val();

    $("body").on('change', '#profile-id', function(){
        var perfil = $("#profile-id option:selected" ).val();

        if(perfil == 3)
        {
            $("#grade-id").show();
            $("#grade-id2").show();
        }
        else
        {
            $("#grade-id").hide();
            $("#grade-id2").hide();
            $("#grade-id").value("0");
        }
    });
});

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

