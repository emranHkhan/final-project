<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $id = $request->id;
            $company = Company::where('user_id', $id)->first();

            return response()->json(['status' => 'success', 'data' => $company]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function postJob(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'title' => 'required|string|max:50',
                'salary' => 'required|string|max:50',
                'location' => 'required|string|max:50',
                'category' => 'required|string|min:5|max:50',
                'tags' => 'required|string',
                'company_id' => 'required|integer'
            ]);

            $category = Category::firstOrCreate(['name' => $request->input('category')]);
            $company = Company::where('user_id', $request->input('company_id'))->first();

            if ($company) {
                Job::create([
                    'title' => $request->input('title'),
                    'salary' => $request->input('salary'),
                    'location' => $request->input('location'),
                    'tags' => $request->input('tags'),
                    'company_id' => $company->id,
                    'category_id' => $category->id
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Cannot create the job.']);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Successful! Waiting for admin approval']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getJobSummary()
    {

        $company = Company::where('user_id', request()->input('id'))->first();
        $companyId = $company->id;

        try {
            $pendingJobsCount = Job::where('company_id', $companyId)
                ->where('status', 'pending')
                ->count();

            $activeJobsCount = Job::where('company_id', $companyId)
                ->where('status', 'active')
                ->count();

            return response()->json(['status' => 'success', 'pendings' => $pendingJobsCount, 'actives' => $activeJobsCount]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getJobs()
    {
        $jobs = Job::all();

        return response()->json(['status' => 'success', 'data' => $jobs]);
    }
}
