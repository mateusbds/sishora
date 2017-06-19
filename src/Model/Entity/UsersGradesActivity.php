<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersGradesActivity Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $grades_activity_id
 * @property string $description
 * @property int $carga_horaria
 * @property string $instituicao
 * @property string $file_name
 * @property bool $validated
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\GradesActivity $grades_activity
 */
class UsersGradesActivity extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
