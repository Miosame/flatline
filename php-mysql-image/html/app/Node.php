<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Node extends Model
{
    use SoftDeletes;
    protected $fillable = ['hostname','ipaddr4','ipaddr6','macaddr','online','comment'];
}