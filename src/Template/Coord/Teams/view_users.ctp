<?php
/**
  * @var \App\View\AppView $this
  */
?>

<?= __('Lista dos alunos da turma') ?>
<select class="form-control" style="margin-bottom: 15px;" size="20">
    <?php foreach ($users as $user): ?>
            <option> <?= $user->name ?> </option> 
        <?php endforeach; ?>
</select>
<?= $this->Html->link('Cancelar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>