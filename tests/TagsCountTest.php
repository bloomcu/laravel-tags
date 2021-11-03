<?php

class TagsCountTest extends TestCase
{
    protected $lesson;

    public function setUp(): void
    {
        parent::setUp();

        // Create a lesson to work with
        $this->lesson = \LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

    public function test_tag_count_is_incremented_when_tagged()
    {
        // Create a tag
        $tag = \TagStub::create([
            'title' => 'Red',
            'slug' => Str::slug('Red'),
            'count' => 0
        ]);

        // Tag the lesson
        $this->lesson->tag(['red']);

        // Get tag back from db
        $tag = $tag->fresh();

        // Assert tag count is 1
        $this->assertEquals(1, $tag->count);
    }

    public function test_tag_count_is_decremented_when_untagged()
    {
        // Create a tag
        $tag = \TagStub::create([
            'title' => 'Red',
            'slug' => Str::slug('Red'),
            'count' => 100
        ]);

        // Tag the lesson, then untag it
        $this->lesson->tag(['red']);
        $this->lesson->untag(['red']);

        // Get tag back from db
        $tag = $tag->fresh();

        // Assert tag count is 1
        $this->assertEquals(100, $tag->count);
    }

    public function test_tag_count_cannot_be_less_than_zero()
    {
        // Create a tag
        $tag = \TagStub::create([
            'title' => 'Red',
            'slug' => Str::slug('Red'),
            'count' => 0
        ]);

        // Untag the lesson, despite not already being tagged
        $this->lesson->untag(['red']);

        // Get tag back from db
        $tag = $tag->fresh();

        // Assert tag count is still zero
        $this->assertEquals(0, $tag->count);
    }

    public function test_tag_count_does_not_increment_if_tag_already_exists()
    {
        // Create a tag
        $tag = \TagStub::create([
            'title' => 'Red',
            'slug' => Str::slug('Red'),
            'count' => 0
        ]);

        // Tag lesson with same tag multiple times
        $this->lesson->tag(['red']);
        $this->lesson->tag(['red']);

        // Get tag back from db
        $tag = $tag->fresh();

        // Assert red tag count is only 1
        $this->assertEquals(1, $tag->count);
    }
}
