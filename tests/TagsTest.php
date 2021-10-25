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

    public function test_can_untag_lesson()
    {
        // Tag lesson
        $this->lesson->tag(['red', 'white', 'blue']);

        // Untag lesson
        $this->lesson->untag(['red', 'white']);

        // Assert lesson has 1 tag
        $this->assertCount(1, $this->lesson->tags);

        // Assert lesson has the right tag
        $this->assertContains('Blue', $this->lesson->tags->pluck('name'));
    }

    public function test_can_untag_all_lesson_tags()
    {
        // Tag lesson
        $this->lesson->tag(['red', 'white', 'blue']);

        // Untag lesson
        $this->lesson->untagAll();

        // Reload lesson
        $this->lesson->load('tags');

        // Assert lesson has 0 tags
        $this->assertCount(0, $this->lesson->tags);
    }

    public function test_non_existing_tags_are_ignored_on_tagging()
    {
        // Tag lesson
        $this->lesson->tag(['red', 'white', 'hamburger']);

        // Assert lesson has only 2 tags
        $this->assertCount(2, $this->lesson->tags);
    }

    public function test_random_tag_cases_are_normalised()
    {
        // Tag lesson
        $this->lesson->tag(['Red', 'WHITE', 'bLuE', 'Ash-grey']);

        // Assert lesson has 4 tags
        $this->assertCount(4, $this->lesson->tags);

        // Assert lesson has the right tags
        foreach (['Red', 'White', 'Blue', 'Ash Grey'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }
}
