<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index()
    {
        $topCategories = Category::withCount('jobs')
            ->whereHas('jobs', function ($query) {
                $query->where('status', 'active');
            })
            ->orderByDesc('jobs_count')
            ->take(5)
            ->get();


        return response()->json(['data' => $topCategories]);
    }

    public function getJobsByCategory(Request $request)
    {
        $categoryName = $request->input('category');
        $categoryId = Category::where('name', $categoryName)->value('id');

        $category = Category::findOrFail($categoryId);

        $jobs = $category->jobs()
            ->where('status', 'active')
            ->with(['company' => function ($query) {
                $query->select('id', 'name');
            }])->paginate(5);

        return response()->json(['data' => $jobs->items()]);
    }


    public function saveJobCandidate(Request $request)
    {
        $jobId = $request->input('jobId');
        $candidateId = $request->input('candidateId');


        try {
            $existingRecord = DB::table('candidate_job')
                ->where('job_id', $jobId)
                ->where('candidate_id', $candidateId)
                ->exists();

            if ($existingRecord) {
                return response()->json(['status' => 'fail', 'message' => 'You have already applied for this job.']);
            } else {
                DB::table('candidate_job')->insert([
                    'job_id' => $jobId,
                    'candidate_id' => $candidateId,
                ]);

                return response()->json(['status' => 'success', 'message' => 'Application successful!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function getTopCompanies()
    {
        $topCompanies = Company::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(5)
            ->get();

        return response()->json(['data' => $topCompanies]);
    }

    public function getBlogsPageInfo()
    {
        $blogs = DB::table('blog_page_infos')->get();

        return response()->json(['status' => 'success', 'data' => $blogs]);
    }

    public function getContactPageInfo()
    {
        $contacts = DB::table('contact_page_infos')->get();

        return response()->json(['status' => 'success', 'data' => $contacts]);
    }

    public function getAboutPageInfo()
    {
        $about = DB::table('about_page_infos')->get();

        return response()->json(['status' => 'success', 'data' => $about]);
    }

    public function getAllBlogs()
    {
        $blogs = DB::table('blog_infos')->get();

        return response()->json(['status' => 'success', 'data' => $blogs]);
    }
}
