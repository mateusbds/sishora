<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grades Activity'), ['action' => 'edit', $gradesActivity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grades Activity'), ['action' => 'delete', $gradesActivity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gradesActivity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grades Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grades Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Activities'), ['controller' => 'Activities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['controller' => 'Activities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grades'), ['controller' => 'Grades', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grade'), ['controller' => 'Grades', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Actuations'), ['controller' => 'Actuations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Actuation'), ['controller' => 'Actuations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="gradesActivities view large-9 medium-8 columns content">
    <h3><?= h($gradesActivity->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Activity') ?></th>
            <td><?= $gradesActivity->has('activity') ? $this->Html->link($gradesActivity->activity->name, ['controller' => 'Activities', 'action' => 'view', $gradesActivity->activity->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grade') ?></th>
            <td><?= $gradesActivity->has('grade') ? $this->Html->link($gradesActivity->grade->id, ['controller' => 'Grades', 'action' => 'view', $gradesActivity->grade->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Actuation') ?></th>
            <td><?= $gradesActivity->has('actuation') ? $this->Html->link($gradesActivity->actuation->name, ['controller' => 'Actuations', 'action' => 'view', $gradesActivity->actuation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($gradesActivity->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Equivalence') ?></th>
            <td><?= $this->Number->format($gradesActivity->equivalence) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Limite') ?></th>
            <td><?= $this->Number->format($gradesActivity->limite) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($gradesActivity->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Grade Id') ?></th>
                <th scope="col"><?= __('Team Id') ?></th>
                <th scope="col"><?= __('Profiles Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gradesActivity->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->grade_id) ?></td>
                <td><?= h($users->team_id) ?></td>
                <td><?= h($users->profiles_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
