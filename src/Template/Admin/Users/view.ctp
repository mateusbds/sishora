<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grades'), ['controller' => 'Grades', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grade'), ['controller' => 'Grades', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Teams'), ['controller' => 'Teams', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Team'), ['controller' => 'Teams', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Profiles'), ['controller' => 'Profiles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profile'), ['controller' => 'Profiles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grades Activities'), ['controller' => 'GradesActivities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grades Activity'), ['controller' => 'GradesActivities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grade') ?></th>
            <td><?= $user->has('grade') ? $this->Html->link($user->grade->id, ['controller' => 'Grades', 'action' => 'view', $user->grade->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Team') ?></th>
            <td><?= $user->has('team') ? $this->Html->link($user->team->id, ['controller' => 'Teams', 'action' => 'view', $user->team->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Profile') ?></th>
            <td><?= $user->has('profile') ? $this->Html->link($user->profile->name, ['controller' => 'Profiles', 'action' => 'view', $user->profile->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Grades Activities') ?></h4>
        <?php if (!empty($user->grades_activities)): ?>
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
            <?php foreach ($user->grades_activities as $gradesActivities): ?>
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
</div>
