 @php
     $satus = [
         'scheduled' => ['text' => 'Scheduled', 'class' => 'badge-light-info'],
         'paid' => ['text' => 'Paid', 'class' => 'badge-light-success'],
         'pending' => ['text' => 'Pending', 'class' => 'badge badge-light-warning'],
         'return' => ['text' => 'Return', 'class' => 'badge badge-light-danger'],
         'active' => ['text' => 'Active', 'class' => 'badge-light-success'],
         'inactive' => ['text' => 'Inactive', 'class' => 'badge badge-light-danger'],
         'review' => ['text' => 'Review', 'class' => 'adge badge-light-warning'],
         'approved' => ['text' => 'Approved', 'class' => 'badge-light-success'],
         'rejected' => ['text' => 'Rejected', 'class' => 'badge badge-light-danger'],
         'unpaid' => ['text' => 'Unpaid', 'class' => 'adge badge-light-warning'],
         'assigned' => ['text' => 'Assigned', 'class' => 'badge badge-light-info'],
         'in_progress' => ['text' => 'In Progress', 'class' => 'badge badge-light-warning'],
         'reopened' => ['text' => 'Reopened', 'class' => 'badge-light-success'],
         'course_enquiry' => ['text' => 'Course Enquiry', 'class' => 'badge-light-success'],
         'course_curriculum' => ['text' => 'Course Curriculum', 'class' => 'badge-light-success'],
         'demo_class' => ['text' => 'Demo Class', 'class' => 'badge-light-info'],
         'training_calender_enquiry' => ['text' => 'Training Calender', 'class' => 'badge-light-warning'],
         'contact_form' => ['text' => 'Contact Form', 'class' => 'badge badge-light-danger'],

     ];
 @endphp
 @if (isset($satus[$data->status]))
    <div class="badge {{ $satus[$data->status]['class'] }}">{{ strtoupper($satus[$data->status]['text']) }} </div>
@elseif (isset($satus[$data->type]))
<div class="badge {{ $satus[$data->type]['class'] }}">{{ strtoupper($satus[$data->type]['text']) }} </div>
@else
    <div class="badge {{ $satus['active']['class'] }}">{{ strtoupper($data->status) }} </div>
@endif
