<?php

namespace App\Http\Controllers;

use App\Models\VitrinAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VitrinAnalyticsController extends Controller
{
    /**
     * Track an analytics event
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function track(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'vitrin_id' => 'required|integer|exists:vitrins,id',
                'event_type' => 'required|string|max:50',
                'source' => 'nullable|string|max:255',
                'page' => 'nullable|string|max:255',
                'user_agent' => 'nullable|string|max:500',
                'metadata' => 'nullable|json',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Create a new analytics record
            $analytics = new VitrinAnalytics();
            $analytics->vitrin_id = $request->input('vitrin_id');
            $analytics->event_type = $request->input('event_type');
            $analytics->source = $request->input('source');
            $analytics->ip_address = $request->ip();
            $analytics->user_agent = $request->input('user_agent');
            $analytics->page = $request->input('page');
            $analytics->metadata = $request->input('metadata');
            $analytics->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Analytics event tracked successfully',
                'data' => [
                    'id' => $analytics->id,
                    'event_type' => $analytics->event_type
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to track analytics event: ' . $e->getMessage(), [
                'data' => $request->all(),
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to track analytics event'
            ], 500);
        }
    }
    
    /**
     * Get analytics summary for a vitrin
     * 
     * @param Request $request
     * @param int $vitrinId
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary(Request $request, $vitrinId)
    {
        try {
            // Make sure the user has access to this vitrin
            if (!$this->userCanAccessVitrin($request->user(), $vitrinId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }
            
            // Get the date range from the request
            $startDate = $request->input('start_date', now()->subDays(30)->startOfDay());
            $endDate = $request->input('end_date', now()->endOfDay());
            
            // Get page views count
            $pageViews = VitrinAnalytics::where('vitrin_id', $vitrinId)
                ->where('event_type', 'page_view')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            // Get contacts count
            $contacts = VitrinAnalytics::where('vitrin_id', $vitrinId)
                ->where('event_type', 'contact_click')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            // Get appointments count
            $appointments = VitrinAnalytics::where('vitrin_id', $vitrinId)
                ->where('event_type', 'appointment_click')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            // Get average time spent (in seconds)
            $avgTimeSpent = VitrinAnalytics::where('vitrin_id', $vitrinId)
                ->where('event_type', 'time_spent')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->avg('metadata->seconds') ?? 0;
                
            // Get top traffic sources
            $sources = VitrinAnalytics::where('vitrin_id', $vitrinId)
                ->where('event_type', 'page_view')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select('source')
                ->selectRaw('count(*) as count')
                ->groupBy('source')
                ->orderByDesc('count')
                ->limit(5)
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'page_views' => $pageViews,
                    'contacts' => $contacts,
                    'appointments' => $appointments,
                    'avg_time_spent' => round($avgTimeSpent),
                    'top_sources' => $sources,
                    'date_range' => [
                        'start' => $startDate,
                        'end' => $endDate
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get analytics summary: ' . $e->getMessage(), [
                'vitrin_id' => $vitrinId,
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get analytics summary'
            ], 500);
        }
    }
    
    /**
     * Check if the user can access the vitrin
     * 
     * @param \App\Models\User|null $user
     * @param int $vitrinId
     * @return bool
     */
    private function userCanAccessVitrin($user, $vitrinId)
    {
        if (!$user) {
            return false;
        }
        
        // Admin can access all vitrins
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Check if the user owns the vitrin
        return $user->vitrins()->where('id', $vitrinId)->exists();
    }
} 