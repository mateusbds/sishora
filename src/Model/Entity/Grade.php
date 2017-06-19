<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grade Entity
 *
 * @property int $id
 * @property int $qntHours
 * @property bool $status
 * @property int $course_id
 * @property string $description
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Actuation[] $actuations
 */class Grade extends Entity
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
