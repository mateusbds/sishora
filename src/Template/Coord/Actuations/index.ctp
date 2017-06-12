<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container" style="background: #f8f8f8;">
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
    <h3><?= __('Eixo de Atuação') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' =>'modal:open']) ?>
    <table id="example" class="table table-striped table-bordered display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!--<th scope="col"><?= $this->Paginator->sort('id') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('name', ['label' => 'Nome']) ?></th>
                <th width="20%"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actuations as $actuation): ?>
            <tr>
                <!--<td><?= $this->Number->format($actuation->id) ?></td>-->
                <td><?= h($actuation->name) ?></td>
                <td class="actions">
                    <!--<?= $this->Html->link(__('View'), ['action' => 'view', $actuation->id]) ?>-->
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $actuation->id],  ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $actuation->id] , ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar # {0}?', $actuation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
