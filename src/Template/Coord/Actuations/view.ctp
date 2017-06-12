<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <!-- <li class="heading"><?= __('Ações') ?></li> -->
            <li><?= $this->Html->link(__('Usuários'), ['action' => '#']) ?></li>
            <li><?= $this->Html->link(__('Perfis'), ['controller' => 'Profiles', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Atividades Complementares'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Grades'), ['controller' => 'Grades', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Eixos de atuação'), ['controller' => 'Actuations', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Cursos'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Atividades da Grade'), ['controller' => 'GradesActivities', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Eixo de Atuação da Grade'), ['controller' => 'GradesActuations', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('Turmas Concludentes'), ['controller' => 'teams', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('Logout', ['action' => 'logout']) ?></li>
        </ul>
    </div>
</nav>
<div class="actuations view large-9 medium-8 columns content">
    <h3><?= h($actuation->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($actuation->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($actuation->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Grades Activities') ?></h4>
        <?php if (!empty($actuation->grades_activities)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Activity Id') ?></th>
                <th scope="col"><?= __('Grade Id') ?></th>
                <th scope="col"><?= __('Equivalence') ?></th>
                <th scope="col"><?= __('Limit') ?></th>
                <th scope="col"><?= __('Actuation Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($actuation->grades_activities as $gradesActivities): ?>
            <tr>
                <td><?= h($gradesActivities->id) ?></td>
                <td><?= h($gradesActivities->activity_id) ?></td>
                <td><?= h($gradesActivities->grade_id) ?></td>
                <td><?= h($gradesActivities->equivalence) ?></td>
                <td><?= h($gradesActivities->limit) ?></td>
                <td><?= h($gradesActivities->actuation_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'GradesActivities', 'action' => 'view', $gradesActivities->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'GradesActivities', 'action' => 'edit', $gradesActivities->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'GradesActivities', 'action' => 'delete', $gradesActivities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gradesActivities->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Grades') ?></h4>
        <?php if (!empty($actuation->grades)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('QntHours') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($actuation->grades as $grades): ?>
            <tr>
                <td><?= h($grades->id) ?></td>
                <td><?= h($grades->qntHours) ?></td>
                <td><?= h($grades->status) ?></td>
                <td><?= h($grades->course_id) ?></td>
                <td><?= h($grades->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Grades', 'action' => 'view', $grades->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Grades', 'action' => 'edit', $grades->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Grades', 'action' => 'delete', $grades->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grades->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
