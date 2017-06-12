<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container" style="background: #f8f8f8;">
        <ul class="nav navbar-nav">
            <!-- <li class="heading"><?= __('Ações') ?></li> -->
            <li class="dropdown">
                <a  href="courses" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Cadastro
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link('Usuários', ['controller' => 'Users', 'action' => 'index'],  ['class' => 'dropdown-option', 'style' => 'margin-top: 0px;']) ?></li>
                    <li><?= $this->Html->link('Perfis', ['controller' => 'Profiles', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Cursos', ['controller' => 'Courses', 'action' => 'index']) ?></li>
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
    <h3><?= __('Cursos') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' =>'modal:open']) ?>
    <table id="example" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('code', ['label' => 'Código do curso']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('name', ['label' => 'Curso']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('users_id', ['label' => 'Coordenador']) ?></th>
                <th scope="col" class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td width="15%"><?= $this->Number->format($course->code) ?></td>
                <td width="50%"><?= h($course->name) ?></td>
                <td><?= $course->has('user') ? $course->user->name : '' ?></td>
                <td class="actions" width="20%">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $course->id], ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $course->id], ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar o curso {0}?', $course->name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
