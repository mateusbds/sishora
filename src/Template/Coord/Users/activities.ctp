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
    <h3><?= __('Atividades Complementares') ?></h3>
    <table id="example" class="table table-striped table-bordered display">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name', ['label' => 'Usuário']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id', ['label' => 'Matrícula']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('grades_activity_id', ['label' => 'Atividade na Grade']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('description', ['label' => 'Descrição']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('carga_horaria') ?></th>
                <th scope="col"><?= $this->Paginator->sort('carga_aproveitada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('instituicao', ['label' => 'Instituição']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_name', ['label' => 'Nome do arquivo']) ?></th>
                <th scope="col" class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $activity): ?>
            <tr>
                <td><?= $activity->has('user_id') ? $activity->user->name : '' ?></td>
                <td><?= $activity->has('user_id') ? $activity->user->id : '' ?></td>
                <td><?= $activity->has('grades_activity') ? $activity->grades_activity->activity->name : '' ?></td>
                <td><?= h($activity->description) ?></td>
                <td><?php echo $this->Number->format($activity->carga_horaria);
                if($activity->grades_activity->unit == 0)
                {
                    echo ' Hora(s)';
                }
                else if($activity->grades_activity->unit == 1)
                {
                    echo ' Dia(s)';
                }
                else if($activity->grades_activity->unit == 2)
                {
                    echo ' Quantidade';
                }
                ?></td>
                <td><?= $this->Number->format($activity->carga_horaria)." Hora(s)" ?> </td>
                <td><?= h($activity->instituicao) ?></td>
                <td><?= $this->Html->link(h($activity->file_name), ['action' => 'download', $activity->user_id, base64_encode($activity->file_name)]) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Validar'), ['action' => 'validate', $activity->id], ['class' => 'btn-warning btn btn-xs', 'confirm' => __('Tem certeza que deseja validar essa atividade?')]) ?>
                    <?= $this->Html->link(__('Rejeitar'), ['action' => 'reject', $activity->id], ['class' => 'btn-danger btn btn-xs', 'rel' => 'modal:open']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
