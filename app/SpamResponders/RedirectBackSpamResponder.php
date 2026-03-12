<?php
namespace App\SpamResponders;

use Closure;
use Illuminate\Http\Request;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class RedirectBackSpamResponder implements SpamResponder
{
    public function respond(Request $request, Closure $closure)
    {
        return redirect()->back()
            ->with('error', 'Spam detected. Please try again.');
    }
}
