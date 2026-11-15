<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantNewsletterController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $newsletters = Newsletter::where(function ($q) {
                $q->where('target_audience', 'tenants_only')
                  ->orWhere('target_audience', 'both');
            })
            ->where('status', 'published')
            ->with(['author'])
            ->latest('published_at')
            ->paginate(10);

        return view('app.tenant.newsletters.index', compact('newsletters'));
    }

    public function show(Newsletter $newsletter)
    {
        // Enforce audience isolation
        if (!in_array($newsletter->target_audience, ['tenants_only', 'both'])) {
            abort(403, 'This announcement is restricted to house owners.');
        }

        // Mark as read in newsletter_recipients
        NewsletterRecipient::where('newsletter_id', $newsletter->id)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        return view('app.tenant.newsletters.show', compact('newsletter'));
    }
}
