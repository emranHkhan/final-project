<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Job;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function saveCandidate(Request $request)
    {
        try {
            $candidateInfo = $request->input('candidate_info');
            $userId = auth()->id();

            $candidate = Candidate::updateOrCreate(
                ['user_id' => $userId],
                ['candidate_info' => json_encode($candidateInfo)]
            );

            return response()->json(['status' => 'success', 'data' => json_decode($candidate->candidate_info, true)]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getAppliedJobsCount($id)
    {
        try {
            $jobCount = DB::table('candidate_job')
                ->where('candidate_id', $id)
                ->count();

            return response()->json(['status' => 'success', 'data' => $jobCount]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getAppliedJobs($id)
    {
        $jobIds = DB::table('candidate_job')
            ->where('candidate_id', $id)
            ->pluck('job_id');

        $jobs = Job::whereIn('id', $jobIds)->get();

        return response()->json(['status' => 'success', 'data' => $jobs]);
    }
}
