<?= $this->layout = false ?>

<style>
    *{
        font-family: "Times New Roman", Times, serif;
    }
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th {
        height: 50px;
    }
</style>

<div style="text-align: center; margin-bottom: 20px;">
    <?= $this->Dompdf->image("caninde.jpg") ?>
</div>

<div>
    <div>
        <div style="display: inline;"><b>Curso:</b>
            <?= $course[0]['name'] ?>
        </div>
        <div style="display: inline; margin-left: 60px"><b>Turma:</b>
            <?= $team['id'] ?>
        </div>
    </div>
    <div>
        <div style="display: inline;"><b>Ano:</b>
            <?= $team['ano'] ?>
        </div>
        <div style="display: inline;"><b>Semestre:</b>
            <?= $team['semestre'] ?>
        </div>
    </div>

    <div>
    <h4 style="text-align: center; vertical-align: middle;">Lista de alunos</h4>
    </div>

    <table width="100%">
        <thead>
            <tr>
                <th width="20%"><?= 'Matrícula' ?></th>
                <th scope="col"><?= 'Nome' ?></th>
                <th width="20%"><?= 'Horas Complementares' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= isset($user->activitycomphour->hours) ? $user->activitycomphour->hours : '' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="position:absolute;
                bottom:0;           
                left:0; ">
        <div style="text-align: center; margin-bottom: 10px;">Data: __/__/____</div>
        <div style="text-align: center; margin-bottom: 10px;">_________________________</div>
        <div style="text-align: center; margin-bottom: 10px;">Assinatura do coordenador</div>
        <div style="text-align: center; margin-bottom: 10px;">_________________________</div>
        <div style="text-align: center; margin-bottom: 10px;">Matrícula</div>
    </div>
</div>