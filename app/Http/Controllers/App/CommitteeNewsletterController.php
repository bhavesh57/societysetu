<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\SocietyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeNewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::with('author')
            ->withCount('recipients')
            ->latest()
            ->paginate(10);

        return view('app.committee.newsletters.index', compact('newsletters'));
    }

    public function create()
    {
        return view('app.committee.newsletters.create');
    }

    public function store(Request $request)
    {
        $societyId = session('current_society_id');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'target_audience' => ['required', 'in:owners_only,tenants_only,both'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('newsletters', 'public');
        }

        $newsletter = Newsletter::create([
            'society_id' => $societyId,
            'created_by' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target_audience' => $validated['target_audience'],
            'attachment_path' => $attachmentPath,
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Auto-populate recipients based on audience
        $this->populateRecipients($newsletter);

        return redirect()->route('committee.newsletters.index')
            ->with('success', 'Newsletter published successfully and dispatched to targeted residents.');
    }

    protected function populateRecipients(Newsletter $newsletter): void
    {
        $eligibleUserIds = collect();

        if ($newsletter->target_audience === 'both') {
            $eligibleUserIds = SocietyMember::where('society_id', $newsletter->society_id)
                ->where('status', 'active')
                ->pluck('user_id')
                ->unique();
        } elseif ($newsletter->target_audience === 'owners_only') {
            $eligibleUserIds = SocietyMember::where('society_id', $newsletter->society_id)
                ->where('role_type', 'house_owner')
                ->where('status', 'active')
                ->pluck('user_id')
                ->unique();
        } elseif ($newsletter->target_audience === 'tenants_only') {
            $eligibleUserIds = SocietyMember::where('society_id', $newsletter->society_id)
                ->where('role_type', 'tenant')
                ->where('status', 'active')
                ->pluck('user_id')
                ->unique();
        }

        foreach ($eligibleUserIds as $userId) {
            NewsletterRecipient::firstOrCreate([
                'newsletter_id' => $newsletter->id,
                'user_id' => $userId,
            ], [
                'read_at' => null,
            ]);
        }
    }
}
