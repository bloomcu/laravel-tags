<?php

use Illuminate\Database\Eloquent\Model;
use MetriFi\Tags\Traits\HasTags;

// Setup a stub model for testing
class LessonStub extends Model
{
    use HasTags;

    // This model is loaded from the test environment database
    protected $connection = 'testbench';
    public $table = 'lessons';
}
