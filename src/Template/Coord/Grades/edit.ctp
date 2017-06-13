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
<div class="container" style="padding-bottom: 15px;">
    <?= $this->Form->create($grade) ?>
    <fieldset class="form-group">
        <legend style="padding-top:20px;"><?= __('Editar') ?></legend>
        <div class="form-group">
            <?php
                echo $this->Form->input('description', ['label' => 'Descrição', 'class' => 'form-control']);
                echo $this->Form->input('qntHours', ['label' => 'Quantidade de Horas', 'class' => 'form-control', 'type' => 'textbox']);
                echo $this->Form->input('status', ['label' => 'Ativa', 'class' => 'checkbox']);
            ?>
        </div>
    </fieldset>
    <div class="row container">
        <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
        <?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'action' => 'index']) ?>
    </div>
</div>
<!-- Grades Activity -->
<div class="container" style="margin-top: 15px;">
    <div>
        <legend style="padding-top:20px;"><?= __('Atividades da Grade') ?></legend>
        <?= $this->Html->link(__('Cadastrar'), ['controller' => 'GradesActivities', 'action' => 'add', $id], ['class' => 'btn btn-primary', 'rel' =>'modal:open']) ?>
        <table cellpadding="0"  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('activity_id', ['label' => 'Atividade']) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('grade_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('amount', ['label' => 'Quantidade']) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('unit', ['label' => 'Unidade']) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('compHours', ['label' => 'Nº Horas Comp.']) ?></th>
                    <th scope="col"><?= $this->Paginator->sort('limite') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('actuation_id', ['label' => 'Eixo de Atuação']) ?></th>
                    <th scope="col" class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mgradesActivities as $gradesActivity): ?>
                <tr>
                    <td><?= $gradesActivity->has('activity') ? $gradesActivity->activity->name : '' ?></td>
                    <td><?= $gradesActivity->has('grade') ? $gradesActivity->grade->description : '' ?></td>
                    <td><?= $this->Number->format($gradesActivity->amount) ?></td>
                    <td><?php 
                    if($gradesActivity->unit == 0)
                    {
                        echo "Horas";
                    }
                    else if($gradesActivity->unit == 1)
                    {
                        echo "Dias";
                    }
                    else if($gradesActivity->unit == 2)
                    {
                        echo "Quantidade";
                    }
                    ?></td>
                    <td><?= $this->Number->format($gradesActivity->compHours) ?></td>
                    <td><?= $this->Number->format($gradesActivity->limite) ?>%</td>
                    <td><?= $gradesActivity->has('actuation') ? $gradesActivity->actuation->name : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Editar'), ['controller' => 'GradesActivities', 'action' => 'edit', $gradesActivity->id, $id], ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['controller' => 'GradesActivities', 'action' => 'delete', $gradesActivity->id, $id], ['class' => 'btn-danger btn btn-xs'], ['confirm' => __('Você tem certeza que deseja deletar # {0}?', $gradesActivity->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>