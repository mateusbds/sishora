<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container" style="background: #f8f8f8;">
        <a class="navbar-brand" href="#">SisHora</a>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a  href="courses" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Cadastro
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link('Usuários', ['controller' => 'Users', 'action' => 'index'],  ['class' => 'dropdown-option', 'style' => 'margin-top: 0px;']) ?></li>
                    <li><?= $this->Html->link('Atividades dos alunos', ['controller' => 'Users', 'action' => 'activities']) ?></li>
                    <li role="separator" class="divider"></li>
                    <li><?= $this->Html->link('Grades', ['controller' => 'Grades', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Cursos', ['controller' => 'Courses', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Atividades Complementares', ['controller' => 'Activities', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Eixos de atuação', ['controller' => 'Actuations', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Turmas Concludentes', ['controller' => 'teams', 'action' => 'index']) ?></li>
                </ul>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?= $this->request->session()->read('Auth.User.username') ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu"><?= $this->Html->link('Logout', ['action' => 'logout'], ['class' => 'dropdown-option']) ?></ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h3><?= __('Usuários') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' => 'modal:open']) ?>
    <table id="example" class="table table-striped table-bordered display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', ['label' => 'Matrícula']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('username', ['label' => 'Usuário']) ?></th>
                <!--<th scope="col"><?= $this->Paginator->sort('password') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('name', ['label' => 'Nome']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('email', ['label' => 'Email']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('grade_id', ['label' => 'Grade']) ?></th>
                <!--<th scope="col"><?= $this->Paginator->sort('team_id', ['label' => 'Turma Concludente']) ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('profiles_id', ['label' => 'Perfil']) ?></th>
                <th scope="col" class="actions"><?= __('Ação') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->matricula ?></td>
                <td><?= h($user->username) ?></td>
                <!--<td><?= h($user->password) ?></td>-->
                <td><?= h($user->name) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= $user->has('grade') ? $user->grade->description : '' ?></td>
                <!--<td><?= $user->has('team') ? $this->Html->link($user->team->id, ['controller' => 'Teams', 'action' => 'view', $user->team->id]) : '' ?></td>-->
                <td><?= $user->has('profile') ? $user->profile->name : '' ?></td>
                <td class="actions">
                    <!--<?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>-->
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $user->id], ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar # {0}?', $user->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>