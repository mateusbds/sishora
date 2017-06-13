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
    <h3><?= __('Grades') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' => 'modal:open']) ?>
    <table id="example" class="table table-striped table-bordered display" width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('course_id', ['label' => 'Curso']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('description', ['label' => 'Descrição']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('qntHours',['label' => 'Quantidade de Horas']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $grade): ?>
            <tr>
                <!--<td><?= $this->Number->format($grade->id) ?></td>-->
                <td><?= $grade->has('course') ? $grade->course->name : '' ?></td>
                <td><?= h($grade->description) ?></td>
                <td><?= $this->Number->format($grade->qntHours) ?> Horas</td>
                <td><?php
                    if($grade->status == 1)
                    {
                        echo ('Ativa');
                    }
                    else if ($grade->status == 0)
                    {
                        echo ('Descontinuada');
                    }
                ?></td>
                <td class="actions">
                    <!--<?= $this->Html->link(__('View'), ['action' => 'view', $grade->id]) ?>-->
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $grade->id], ['class' => 'btn-warning btn btn-xs']) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $grade->id], ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar # {0}?', $grade->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>