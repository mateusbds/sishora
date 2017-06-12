<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grades'), ['controller' => 'Grades', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grade'), ['controller' => 'Grades', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="activities view large-9 medium-8 columns content">
    <h3><?= h($activity->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($activity->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($activity->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Grades') ?></h4>
        <?php if (!empty($activity->grades)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('QntHours') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($activity->grades as $grades): ?>
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
