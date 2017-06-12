<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Users Grades Activity'), ['action' => 'edit', $usersGradesActivity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Users Grades Activity'), ['action' => 'delete', $usersGradesActivity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersGradesActivity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users Grades Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Users Grades Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grades Activities'), ['controller' => 'GradesActivities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grades Activity'), ['controller' => 'GradesActivities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usersGradesActivities view large-9 medium-8 columns content">
    <h3><?= h($usersGradesActivity->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $usersGradesActivity->has('user') ? $this->Html->link($usersGradesActivity->user->name, ['controller' => 'Users', 'action' => 'view', $usersGradesActivity->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grades Activity') ?></th>
            <td><?= $usersGradesActivity->has('grades_activity') ? $this->Html->link($usersGradesActivity->grades_activity->id, ['controller' => 'GradesActivities', 'action' => 'view', $usersGradesActivity->grades_activity->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($usersGradesActivity->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Instituicao') ?></th>
            <td><?= h($usersGradesActivity->instituicao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Name') ?></th>
            <td><?= h($usersGradesActivity->file_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($usersGradesActivity->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Carga Horaria') ?></th>
            <td><?= $this->Number->format($usersGradesActivity->carga_horaria) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Validated') ?></th>
            <td><?= $usersGradesActivity->validated ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
