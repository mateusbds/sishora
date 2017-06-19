<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GradesActivity Entity
 *
 * @property int $id
 * @property int $activity_id
 * @property int $grade_id
 * @property float $amount
 * @property string $unit
 * @property int $compHours
 * @property float $limite
 * @property int $actuation_id
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \App\Model\Entity\Grade $grade
 * @property \App\Model\Entity\Actuation $actuation
 * @property \App\Model\Entity\User[] $users
 */class GradesActivity extends Entity
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
