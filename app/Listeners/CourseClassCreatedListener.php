<?php

namespace App\Listeners;

use App\Events\CourseClassCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Repositories\ForumRepository;

class CourseClassCreatedListener
{


    /** @var  ForumRepository */
    private $forumRepository;

    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ForumRepository $forumRepo)
    {   
        $this->forumRepository = $forumRepo;
    }

    /**
     * Handle the event.
     *
     * @param  CourseClassCreated  $event
     * @return void
     */
    public function handle(CourseClassCreated $event)
    {

        //Create the forum of the class
        $this->forumRepository->create([
            'course_class_id'=>$event->courseClass->id,
            'parent_forum_id'=>null,
            'group_name'=>'Assignment Discussions',
            'posting'=>'Discussions about assignments, projects, etc.',
        ]);

        $this->forumRepository->create([
            'course_class_id'=>$event->courseClass->id,
            'parent_forum_id'=>null,
            'group_name'=>'Examination Discussions',
            'posting'=>'Discussions about examinations, notes review, etc.',
        ]);

    }
}
