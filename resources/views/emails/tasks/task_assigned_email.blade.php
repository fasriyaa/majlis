@component('mail::message')
# Task Assigned

The following task have been assigned to you

@component('mail::panel')
  <?php $link = "http://pfm.besomv.com/task_timeline/" . $task->id; ?>
  <p>Task Name: {{$task->text}} </p>
  <p>Due Date: {{date('d F Y'), strtotime($task->start_date . ' + ' . $task->duration .'days')}}</p>
  <p>Link: <a href = "{{$link}}">Task Link </a></p>
@endcomponent



Thanks,<br>
PFM Team
@endcomponent
