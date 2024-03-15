<?php

namespace App\Http\Controllers;

use App\Models\AboutPageInfo;
use App\Models\BlogPageInfo;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\ContactPageInfo;
use App\Models\Job;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getJobs()
    {
        $jobs = Job::all();
        return response()->json(['status' => 'success', 'data' => $jobs]);
    }

    public function updateJobStatus(Request $request)
    {
        $jobId = $request->input('jobId');
        $jobStatus = $request->input('jobStatus');

        try {
            $affectedRows = Job::where('id', $jobId)
                ->update(['status' => $jobStatus]);

            if ($affectedRows > 0) {
                return response()->json(['status' => 'success', 'message' => 'Job status updated successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Update failed!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteJob(Request $request)
    {
        $jobId = $request->input('jobId');

        try {

            Job::destroy($jobId);

            return response()->json(['status' => 'success', 'message' => 'The job has been deleted.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function getCompanies()
    {
        $companies = Company::all();
        return response()->json(['status' => 'success', 'data' => $companies]);
    }


    public function updateCompanyStatus(Request $request)
    {
        $companyId = $request->input('companyId');
        $companyStatus = $request->input('companyStatus');

        try {
            $affectedRows = Company::where('id', $companyId)
                ->update(['status' => $companyStatus]);

            if ($affectedRows > 0) {
                return response()->json(['status' => 'success', 'message' => 'Company status updated successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Update failed!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // the below function needs to be fixed. it is currently deleting the company from companies table rather it should delete the user with
    // the incoming id along with the company that this user created

    public function deleteCompany(Request $request)
    {
        $companyId = $request->input('companyId');

        try {

            Company::where('user_id', $companyId)->delete();
            User::destroy($companyId);

            return response()->json(['status' => 'success', 'message' => 'The company has been deleted.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getJobAndCompanyData()
    {
        $pendingCompany = Company::where('status', 'pending')->count();

        $activeCompnay = Company::where('status', 'active')->count();

        $activeJobs = Job::where('status', 'active')->count();

        $data = [$pendingCompany, $activeCompnay, $activeJobs];

        return response()->json(['data' => $data]);
    }

    public function savePageData(Request $request)
    {
        // try {
        //     DB::table('page_infos')->insert($request->all());

        //     return response()->json(['status' => 'success', 'message' => 'Page Information saved successfully.']);
        // } catch (Exception $e) {
        //     return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        // }


        $data = $request->json()->all();

        try {
            if (isset($data['about'])) {

                $aboutData = $data['about'];
                $newData = AboutPageInfo::create($aboutData);
                return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
            } else if (isset($data['contact'])) {

                $contactData = $data['contact'];
                $newData = ContactPageInfo::create($contactData);
                return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
            } else if (isset($data['blog'])) {

                $blogData = $data['blog'];
                $newData = BlogPageInfo::create($blogData);
                return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function saveBlogData(Request $request)
    {
        try {
            DB::table('blog_infos')->insert($request->all());
            return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }

        return response()->json(['data' => $request->all()]);
    }

    public function getBlogs()
    {
        try {
            $blogs = DB::table('blog_infos')->get();
            return response()->json(['status' => 'success', 'data' => $blogs]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function getCandidateCount($id)
    {
        $candidateCount = DB::table('candidate_job')
            ->where('job_id', $id)
            ->distinct()
            ->count('candidate_id');

        return response()->json(['status' => 'success', 'data' => $candidateCount]);
    }

    public function getJob($id)
    {
        $job = Job::find($id);

        return response()->json(['status' => 'success', 'data' => $job]);
    }

    public function getCandidateForJob($id)
    {
        $candidateIds = DB::table('candidate_job')
            ->where('job_id', $id)
            ->pluck('candidate_id');

        // Fetch all candidates corresponding to the retrieved candidate_ids
        $candidates = Candidate::whereIn('user_id', $candidateIds)->get();

        $dataArray = [];

        foreach ($candidates as $candidate) {
            // Accessing necessary attributes
            $id = $candidate->id;
            $candidateInfo = $candidate->candidate_info;
            $createdAt = $candidate->created_at;

            // Decoding candidate_info if it's a JSON string
            $decodedInfo = json_decode($candidateInfo, true);

            // Constructing associative array
            $candidateData = [
                'id' => $id,
                'candidate_info' => $decodedInfo,
                'created_at' => $createdAt,
            ];

            // Pushing to dataArray
            $dataArray[] = $candidateData;
        }

        return response()->json(['status' => 'success', 'data' => $dataArray]);
    }
}
