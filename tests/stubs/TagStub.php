<?php

use Illuminate\Database\Eloquent\Model;

// Setup a stub model for testing
class TagStub extends Model
{
    // This model is loaded from the test environment database
    protected $connection = 'testbench';
    public $table = 'tags';
}
