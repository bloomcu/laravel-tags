<?php

class TagsTest extends TestCase
{
    protected $lesson;

    public function setUp(): void
    {
        parent::setUp();

        // Create tags to work with
        foreach (['Red', 'White', 'Blue', 'Purple', 'Ash Grey'] as $tag) {
            \TagStub::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
                'count' => 0
            ]);
        }

        // Create a lesson to work with
        $this->lesson = \LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

    public function test_can_tag_lesson()
    {
        // Tag lesson
        $this->lesson->tag(['red', 'white']);

        // Assert lesson has 2 tags
        $this->assertCount(2, $this->lesson->tags);

        // Assert lesson has the right tags
        foreach (['Red', 'White'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }
}
