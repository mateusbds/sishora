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
    <h3><?= __('Turmas Concludentes') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' =>'modal:open']) ?>
    <!--<script>
        $('#manual-ajax').click(function(event) {
            event.preventDefault();
            $.get(this.href, function(html) {
                $(html).appendTo('body').modal();
            });
        });
    </script>-->
    <table  cellpadding="0"  id="example" class="table table-striped table-bordered display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('courses_id', ['label' => 'Curso']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('ano') ?></th>
                <th width="10%"><?= $this->Paginator->sort('semestre') ?></th>
                <th width="30%"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $team): ?>
            <tr>
                <td><?= $team->has('course') ? $team->course->name : '' ?></td>
                <td><?= h($team->ano) ?></td>
                <td><?= $this->Number->format($team->semestre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver Alunos'), ['action' => 'viewUsers', $team->id],  ['class' => 'btn-primary btn btn-xs', 'rel' => 'modal:open']) ?>
                    <?= $this->Html->link(__('Emitir Relatório'), ['action' => 'pdf_view', $team->id],  ['class' => 'btn-primary btn btn-xs']) ?>
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $team->id],  ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $team->id], ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar esta grade?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>