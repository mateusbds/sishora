<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($team) ?>
<fieldset>
    <legend><?= __('Turma') ?></legend>
    <div class="form-group">
        <?php
            echo $this->Form->input('ano', ['class' => 'form-control', 'type' => 'textbox']);
            echo $this->Form->input('semestre', ['class' => 'form-control', 'options' => ['1' => '1', '2' => '2']]);
        ?>
    </div>

    <!-- Multiselect -->
    <div class="row">
        <div class="col-xs-5">
            <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                <?php foreach ($users as $user): ?>
                    <?php if($user->team_id == null)
                    { ?>
                        <option value=<?= $user->id ?>> <?= $user->name ?> </option> 
                    <?php } 
                endforeach; ?>
            </select>
        </div>
        
        <div class="col-xs-2">
            <button type="button" id="search_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
            <button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
            <button type="button" id="search_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
        </div>
        
        <div class="col-xs-5">
            <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple">
                <?php foreach ($users as $user):
                    if($user->team_id == $team->id)
                    { ?>
                        <option value=<?= $user->id ?>> <?= $user->name ?> </option> 
                    <?php } 
                endforeach; ?>
            </select>
        </div>
    </div> <!-- Multiselect -->

</fieldset>
<div class="row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Cancelar',['action' => '#'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#search').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length > 1;
        }
    });
});
</script>