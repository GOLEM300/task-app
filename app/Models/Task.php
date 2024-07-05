<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Task
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status values 'done', 'testing', 'in_working', 'wait'.
 * @property Carbon $date_create
 * @property Carbon $date_to_finish
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
