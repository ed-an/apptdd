<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Models\Project;
use App\Models\Task;

trait RecordsActivity
{

    public  $oldAttributes = [];

    /**
     * @return void
     * Boot the trait.
     */

    public static function bootRecordsActivity()
    {

        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }

    }

    /**
     * @param string $event
     * @param $model
     * @return string
     */
    protected function activityDescription(string $description): string
    {
       return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * @return string[]
     */
    public static function recordableEvents(): array
    {
        return static::$recordableEvents ?? ['created', 'updated', 'deleted'];
    }

      /**
     * Record activity for a project.
     *
     * @param string $description
     */
    public function recordActivity($description)
    {

        $this->activity()->create([
            'user_id' =>($this->project ?? $this)->owner->id,//($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }


    /**
     * Fetch the changes to the model.
     *
     * @param  string $description
     * @return array|null
     */
    protected function activityChanges()
    {

        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }


    /**
     * The activity feed for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }




}
