<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($usersGradesActivity, ['type' => 'file']) ?>
<fieldset>
    <legend><?= __('Editar atividade') ?></legend>
    <?php
        echo $this->Form->input('grades_activity_id', ['options' => $gradesActivities, 'empty' => true, 'label' => 'Atividade da Grade', 'class' => 'form-control', 'id' => 'gradesActivity']);
        echo $this->Form->input('description', ['label' => 'Descrição', 'class' => 'form-control']);
        echo $this->Form->input('carga_horaria', ['label' => 'Carga Horária', 'class' => 'form-control', 'type' => 'textbox', 'id' => 'cargaHoraria']);
        echo $this->Form->label(null, 'Carga Aproveitada: ');
        echo $this->Form->label(null, '0', ['style' => 'font-weight: normal;', 'id' => 'cargaAproveitada']);
        echo $this->Form->input('instituicao', ['label' => 'Instituição', 'class' => 'form-control']);
        echo $this->Form->input('Model.file_name', ['label' => 'Nome do arquivo', 'type' => 'file', 'style' => 'margin-bottom: 10px;']);
        echo $this->Form->label('Filename', 'O documento anterior será substituido.', ['style' => 'font-weight: normal;']);
    ?>
</fieldset>
<?= $this->Form->button('Salvar', ['class' => 'btn btn-primary', 'style' => 'margin-right: 5px;']) ?>
<?= $this->Html->link('Cancelar',['action' => 'index'], ['class' => 'btn btn-primary', 'type' => 'button', 'rel' => 'modal:close']) ?>
<?= $this->Form->end() ?>

<?php $horasComplementares = $horasComplementares->toArray() ?>
<?php $js_array = json_encode($horasComplementares) ?>

<script>
$(document).ready(function() {
    atividade = $("#gradesActivity option:selected" ).val();
    x = $("#cargaHoraria").val();
    var gradesActivities = <?php echo($js_array) ?>;
    var qntHoras = <?php echo($users['qntHours']) ?>;

    for (i = 0; i < gradesActivities.length; i++) {
            if(gradesActivities[i].id == atividade) {
                if(gradesActivities[i].unit == 0) {
                    x = x / gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
                else if(gradesActivities[i].unit == 1) {
                    x = x * gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
                else if(gradesActivities[i].unit == 2) {
                    x = x * gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
            }
        }

    if(atividade != undefined && atividade != null)
        $("#cargaAproveitada").html(Math.trunc(x));

    $("body").on('change', '#gradesActivity', function(){
        atividade = $("#gradesActivity option:selected" ).val();
        x = $("#cargaHoraria").val();

        for(var i = 0; i < gradesActivities.length; i++)
        {
            if(gradesActivities[i].id == atividade) {
                if(gradesActivities[i].unit == 0) {
                    $("#cargaHorariaLabel").html("Carga Horária (Em horas)");
                    if(x) {
                        x = x / gradesActivities[i].compHours;
                        if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                            x = qntHoras * (gradesActivities[i].limite / 100);
                        }
                    }
                }
                else if(gradesActivities[i].unit == 1) {
                    $("#cargaHorariaLabel").html("Carga Horária (Em dias)");
                    if(x) {
                        x = x * gradesActivities[i].compHours;
                        if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                            x = qntHoras * (gradesActivities[i].limite / 100);
                        }
                    }
                }
                else if(gradesActivities[i].unit == 2) {
                    $("#cargaHorariaLabel").html("Carga Horária (Em quantidade)");
                    if(x) {
                        x = x * gradesActivities[i].compHours;
                        if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                            x = qntHoras * (gradesActivities[i].limite / 100);
                        }
                    }
                }
            }
        }

        if(atividade != undefined && atividade != null)
            $("#cargaAproveitada").html(Math.trunc(x));

    });

    $("body").on('blur', '#cargaHoraria', function(){
        atividade = $("#gradesActivity option:selected" ).val();
        x = $("#cargaHoraria").val();

        for (i = 0; i < gradesActivities.length; i++) {
            if(gradesActivities[i].id == atividade) {
                if(gradesActivities[i].unit == 0) {
                    x = x / gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
                else if(gradesActivities[i].unit == 1) {
                    x = x * gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
                else if(gradesActivities[i].unit == 2) {
                    x = x * gradesActivities[i].compHours;
                    if(x >= qntHoras * (gradesActivities[i].limite / 100)) {
                        x = qntHoras * (gradesActivities[i].limite / 100);
                    }
                }
            }
        }
        if(atividade)
            $("#cargaAproveitada").html(Math.trunc(x));
    });

    $("body").on($.modal.BEFORE_CLOSE, function(event, modal) {
        atividade = 0;
        x = 0;
        gradesActivities = 0;
    });
});
</script>