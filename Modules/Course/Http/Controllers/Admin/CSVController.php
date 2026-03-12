<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\Entities\Batch;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseLocale;
use Modules\Course\Entities\Venue;
use Validator;
use League\Csv\Reader;
use Modules\Course\Entities\TrainingCalendar;
use Illuminate\Support\Facades\Storage;

class CSVController extends Controller
{
    public function bulkImport(Request $request)
    {
        // Validate the CSV file
        $validator = Validator::make($request->all(), [
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle the uploaded file
        if ($request->hasFile('csvFile')) {
            $file = $request->file('csvFile');
            $filePath = $file->getRealPath();

            // Open and read the CSV file
            $fileHandle = fopen($filePath, 'r');
            $header = null;
            $data = [];
            $excludedRows = [];

            while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($fileHandle);

            foreach ($data as $record) {
                $courseLocale = CourseLocale::where('title', $record['course'])->first();

                if ($courseLocale) {
                    $courseId = $courseLocale->course_id;
                    $course = Course::find($courseId);
                }
                if ($course) {
                    $batch = Batch::firstOrCreate(
                        ['name' => $record['batch'], 'course_id' => $course->id],
                        ['course_id' => $course->id] // Set the course_id if creating a new batch
                    );
                    $batchId = $batch->id;

                    // Create TrainingCalendar entry
                    TrainingCalendar::create([
                        'title' => $record['title'],
                        'batch_id' => $batchId,
                        'course_id' => $course->id,
                        'start_date' => $record['start_date'],
                        'end_date' => $record['end_date'],
                    ]);
                } else {
                    // Store the excluded row with a message
                    $excludedRows[] = [
                        'title' => $record['title'],
                        'course' => $record['course']
                    ];
                }
            }

            // Check if there are any excluded rows and create the message
            if (count($excludedRows) > 0) {
                $excludedMessage = "The following rows were excluded because the specified courses were not found in the database:<br><ul>";
                foreach ($excludedRows as $row) {
                    $excludedMessage .= "<li>Title: {$row['title']} - Course: {$row['course']}</li>";
                }
                $excludedMessage .= "</ul>";
            } else {
                $excludedMessage = '';
            }

            // Redirect back with success message and excluded rows if any
            return redirect()->route('training_calendar_list')->with([
                'success' => 'CSV data imported successfully.',
                'excludedMessage' => $excludedMessage,
            ]);
        }

        return redirect()->route('training_calendar_list')->with('error', 'File upload failed.');
    }




    public function csvDownload()
    {
        $file = resource_path('files/trainingCalendar/training_calendar_demo.csv');

        return response()->download($file);
    }
}
