<!--<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <!-- <li class="heading"><?= __('Ações') ?></li> -->
            <li><?= $this->Html->link(__('Usuários'), ['controller' => 'Users', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Atividades Complementares'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Grades'), ['controller' => 'Grades', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Eixos de atuação'), ['controller' => 'Actuations', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Cursos'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Atividades da Grade'), ['controller' => 'GradesActivities', 'action' => 'index']) ?></li>
            <!--<li><?= $this->Html->link(__('Turmas Concludentes'), ['controller' => 'teams', 'action' => 'index']) ?></li>-->
            <li><?= $this->Html->link('Logout', ['action' => 'logout']) ?></li>
        </ul>
    </div>
</nav>
<br/>
<br/>
<br/>
<div>
    <h3><?= __('Atividades da grade') ?></h3>
    <?= $this->Html->link(__('Cadastrar'), ['action' => 'add'], ['class' => 'btn btn-primary', 'id' =>'manual-ajax']) ?>
    <script>
        $('#manual-ajax').click(function(event) {
            event.preventDefault();
            $.get(this.href, function(html) {
                $(html).appendTo('body').modal();
            });
        });
    </script>
    <table cellpadding="0"  id="example" class="table table-striped table-bordered display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!--<th scope="col"><?= $this->Paginator->sort('id') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('activity_id', ['label' => 'Atividade']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('grade_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('equivalence', ['label' => 'Equivalência']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('limite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('actuation_id', ['label' => 'Eixo de Atuação']) ?></th>
                <th scope="col" class="actions"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gradesActivities as $gradesActivity): ?>
            <tr>
                <!--<td><?= $this->Number->format($gradesActivity->id) ?></td>-->
                <td><?= $gradesActivity->has('activity') ? $gradesActivity->activity->name : '' ?></td>
                <td><?= $gradesActivity->has('grade') ? $gradesActivity->grade->description : '' ?></td>
                <td><?= $this->Number->format($gradesActivity->equivalence) ?></td>
                <td><?= $this->Number->format($gradesActivity->limite) ?></td>
                <td><?= $gradesActivity->has('actuation') ? $gradesActivity->actuation->name : '' ?></td>
                <td class="actions">
                    <!--<?= $this->Html->link(__('View'), ['action' => 'view', $gradesActivity->id]) ?>-->
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $gradesActivity->id], ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open']) ?>
                    <!--TODO: Colocar a classe e o confirm na mesma array
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $gradesActivity->id], ['class' => 'btn-danger btn btn-xs', 'confirm' => __('Você tem certeza que deseja deletar # {0}?', $gradesActivity->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>-->
