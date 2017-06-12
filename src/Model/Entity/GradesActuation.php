<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GradesActuation Entity
 *
 * @property int $id
 * @property int $actuation_id
 * @property int $grade_id
 * @property float $percentPerHour
 *
 * @property \App\Model\Entity\Actuation $actuation
 * @property \App\Model\Entity\Grade $grade
 */class GradesActuation extends Entity
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
        'actuation_id' => false,
        'grade_id' => false
    ];
}
